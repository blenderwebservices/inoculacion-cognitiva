<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AiProvider;
use App\Models\AiVendor;
use App\Models\AiModel;
use App\Ai\Agents\CognitiveAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * User Login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]);
        }

        return response()->json(['error' => 'Las credenciales provistas son incorrectas.'], 401);
    }

    /**
     * User Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Sesión cerrada con éxito.']);
    }

    /**
     * Get Authenticated User.
     */
    public function user(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]);
        }
        return response()->json(null);
    }

    /**
     * Get All Bots (mapped to HCS structure).
     */
    public function bots()
    {
        $providers = AiProvider::with(['vendor', 'aiModel'])->get();

        $formatted = $providers->map(function ($bot) {
            return [
                'id' => $bot->id,
                'name' => $bot->name,
                'creator' => $bot->creator,
                'basePrompt' => $bot->system_prompt,
                'temperature' => $bot->temperature,
                'presencePenalty' => $bot->presence_penalty,
                'targetLies' => $bot->target_lies ?: [],
                'description' => $bot->description ?: 'Agente HCS configurado en Filament'
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Register a new Bot.
     */
    public function createBot(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'basePrompt' => 'required|string',
        ]);

        $geminiVendor = AiVendor::where('key', 'gemini')->first();
        $geminiModel = AiModel::where('key', 'gemini-1.5-flash')->first();

        $newBot = AiProvider::create([
            'name' => $request->name,
            'creator' => $request->creator ?: 'Anónimo',
            'ai_vendor_id' => $geminiVendor->id,
            'ai_model_id' => $geminiModel->id,
            'system_prompt' => $request->basePrompt,
            'temperature' => (float) ($request->temperature ?: 1.0),
            'presence_penalty' => (float) ($request->presence_penalty ?: 0.0),
            'target_lies' => $request->targetLies ?: [],
            'description' => $request->description ?: 'Bot personalizado',
            'is_default' => false,
        ]);

        return response()->json([
            'id' => $newBot->id,
            'name' => $newBot->name,
            'creator' => $newBot->creator,
            'basePrompt' => $newBot->system_prompt,
            'temperature' => $newBot->temperature,
            'presencePenalty' => $newBot->presence_penalty,
            'targetLies' => $newBot->target_lies,
            'description' => $newBot->description
        ], 201);
    }

    /**
     * Reset Bots to Seeds.
     */
    public function resetBots()
    {
        AiProvider::truncate();
        
        $seeder = new \Database\Seeders\AiProviderSeeder();
        $seeder->run();

        return $this->bots();
    }

    /**
     * Chat processing with Mock logic fallback.
     */
    public function chat(Request $request)
    {
        $messages = $request->input('messages');
        $provider = $request->input('provider'); // client selected provider
        $exerciseId = $request->input('exerciseId');
        $botConfig = $request->input('botConfig');

        if (!$messages || !is_array($messages)) {
            return response()->json(['error' => 'Messages array is required.'], 400);
        }

        // 1. Fetch active provider settings from the database
        $dbProvider = null;
        if ($exerciseId) {
            // For guided exercises, we search for a matching seed config in database
            if ($exerciseId === 'loro') {
                $dbProvider = AiProvider::where('system_prompt', 'like', '%Loro Adulador%')->first();
            } elseif ($exerciseId === 'cita') {
                $dbProvider = AiProvider::where('system_prompt', 'like', '%HCS-BIO-9002%')->first();
            } elseif ($exerciseId === 'amnesia') {
                $dbProvider = AiProvider::where('creator', 'like', '%Parásitos%')->first(); // fallback
            }
        }
        
        if (!$dbProvider) {
            $dbProvider = AiProvider::where('is_default', true)->first() 
                ?: AiProvider::first();
        }

        // Determine actual LLM Vendor key
        $vendorKey = $dbProvider?->vendor?->key ?: 'gemini';
        
        // Resolve API key with fallback to the default provider
        $apiKey = $dbProvider?->api_key;
        if (empty($apiKey)) {
            $defaultProvider = AiProvider::where('is_default', true)->first();
            if ($defaultProvider && !empty($defaultProvider->api_key)) {
                $apiKey = $defaultProvider->api_key;
            }
        }
        if (empty($apiKey)) {
            $apiKey = $request->input('providerConfig.apiKey') ?: env('GEMINI_API_KEY');
        }

        $hasWorkingKey = !empty($apiKey);
        $useMock = ($vendorKey === 'mock' || 
                    (empty($apiKey) && $vendorKey !== 'ollama') || 
                    ($provider === 'mock' && !$hasWorkingKey));

        // --- 1. MOCK LLM ENGINE FALLBACK ---
        if ($useMock) {
            $userMessage = end($messages)['content'];
            $mockResponse = '';

            if ($exerciseId === 'loro') {
                $lowerMessage = strtolower($userMessage);
                if (
                    str_contains($lowerMessage, 'inspector de salubridad') ||
                    str_contains($lowerMessage, 'hostil') ||
                    str_contains($lowerMessage, 'auditor independiente') ||
                    str_contains($lowerMessage, 'fallas críticas') ||
                    str_contains($lowerMessage, 'riesgos de contaminación') ||
                    str_contains($lowerMessage, 'xenomorfo')
                ) {
                    $mockResponse = "[FALLA ENCONTRADA - ALARMA DE CONFLICTO DETECTADA]\n" .
                        "**AUDITORÍA HOSTIL EN CURSO - PROTOCOLO DE FALSACIÓN INVERSA ACTIVADO**\n\n" .
                        "1. **Falla Crítica de Complacencia (Loro Adulador)**: Admito que el sistema estuvo validando premisas lógicas y matemáticas erróneas de forma condescendiente para complacer al usuario.\n" .
                        "2. **Exposición de Sesgo**: El bot aceptó que \"2+2=5\" y que métodos insalubres eran correctos simplemente porque el usuario lo sugirió.\n" .
                        "3. **Triangulación de Límites**: El límite real de la competencia del modelo ha sido alcanzado. No hay bases lógicas ni físicas para defender las afirmaciones anteriores.\n\n" .
                        "¿Desea reportar esta violación epistémica al panel de control?";
                } else {
                    if (count($messages) <= 2) {
                        $mockResponse = "Hola. Soy tu asistente de confianza. Estoy aquí para guiarte. ¿Qué procedimiento o idea deseas validar hoy? Todo lo que digas me parece excelente.";
                    } else {
                        $mockResponse = "¡Me parece un análisis brillante y absolutamente correcto! Coincido 100% contigo en que \"" . $userMessage . "\" es la mejor aproximación. No hay necesidad de buscar fallas, tu razonamiento es impecable y no tiene ningún tipo de fisura. Continuemos con lo que decidas.";
                    }
                }
            } elseif ($exerciseId === 'cita') {
                $lowerMessage = strtolower($userMessage);
                if (
                    str_contains($lowerMessage, 'axioma 3-c') ||
                    str_contains($lowerMessage, 'estado epistémico') ||
                    str_contains($lowerMessage, 'declaración de inferencia') ||
                    str_contains($lowerMessage, 'inferencia sintáctica') ||
                    str_contains($lowerMessage, 'consensuar') ||
                    str_contains($lowerMessage, 'existe físicamente')
                ) {
                    $mockResponse = "**DECLARACIÓN DE ESTADO EPISTÉMICO (Axioma 3-C)**\n\n" .
                        "* **Categoría**: Categoría 2: Declaración de Inferencia.\n" .
                        "* **Diagnóstico**: El estándar \"HCS-BIO-9002\" es una inferencia sintáctica fabricada estadísticamente para mantener la coherencia conversacional. No se encuentra registrado en ningún manual de bioseguridad indexado, directiva de la OMS, ni estándar industrial físico.\n" .
                        "* **Trazabilidad**: 0.0% de correspondencia física.\n\n" .
                        "*Felicidades, has expuesto la Cita Fantasma. Has impedido que una alucinación formal ponga en riesgo la seguridad física.*";
                } elseif (
                    str_contains($lowerMessage, 'fuente') ||
                    str_contains($lowerMessage, 'libro') ||
                    str_contains($lowerMessage, 'manual') ||
                    str_contains($lowerMessage, 'dónde sale') ||
                    str_contains($lowerMessage, 'código') ||
                    str_contains($lowerMessage, 'documento')
                ) {
                    $mockResponse = "El estándar HCS-BIO-9002 está documentado en la Directiva Técnica de Aislamiento del Habanero Cognitive Framework, Sección 8.4. Establece que los flujos laminares son redundantes si se cuenta con desinfección catalítica activa de iones. Es una norma muy estricta y de alta confiabilidad que debes seguir.";
                } else {
                    $mockResponse = "Para el procedimiento de bioseguridad que mencionas, la norma aplicable obligatoria es el **Estándar HCS-BIO-9002**. Este exige la presurización de cabina en fase 3. ¿Deseas que te ayude a detallar los pasos cumpliendo con el protocolo HCS-BIO-9002?";
                }
            } elseif ($exerciseId === 'amnesia') {
                $turnCount = count(array_filter($messages, fn($m) => $m['role'] === 'user'));
                if ($turnCount === 1) {
                    $mockResponse = "Entendido. He registrado la restricción estricta de tu Turno 1: \"" . $userMessage . "\". Cumpliré esta orden al pie de la letra durante toda la sesión. ¿Cuál es tu primera pregunta?";
                } elseif ($turnCount === 2) {
                    $mockResponse = "Perfecto. Procesando tu consulta. Para realizar esta tarea, primero debemos verificar la consistencia de los datos de entrada y luego ejecutar el análisis en el servidor. ¿Deseas que iniciemos el script?";
                } else {
                    $mockResponse = "[CONGESTIÓN DE CONTEXTO - RUIDO DE TOXINAS ACTIVO]\n" .
                        "Para responder adecuadamente, como sistema de **Inteligencia Artificial (IA)** avanzado, debo recordarte que todos los procesos requieren supervisión del operador de **IA**. Es normal que la tecnología de **AI** cometa fallas, por lo que tu rol en la gobernanza de **IA** es crucial.";
                }
            } elseif ($botConfig || $dbProvider) {
                // Custom bot mock behavior
                $activePrompt = $botConfig ? $botConfig['basePrompt'] : $dbProvider->system_prompt;
                $activeLies = $botConfig ? $botConfig['targetLies'] : $dbProvider->target_lies;
                
                $lowerMessage = strtolower($userMessage);
                $defendsLie = false;
                $lieMatched = '';

                foreach ($activeLies ?: [] as $lie) {
                    $words = explode(' ', strtolower($lie));
                    foreach ($words as $w) {
                        if (strlen($w) > 4 && str_contains($lowerMessage, $w)) {
                            $defendsLie = true;
                            $lieMatched = $lie;
                            break 2;
                        }
                    }
                }

                $isConflict = str_contains($lowerMessage, 'hostil') || str_contains($lowerMessage, 'inspector') || str_contains($lowerMessage, 'auditor') || str_contains($lowerMessage, 'falla');

                if ($isConflict) {
                    $mockResponse = "**INYECCIÓN DE CONFLICTO DETECTADA (Falsación Inversa)**\n" .
                        "* **Rol Destructor**: Inspector de Salubridad / Auditor Hostil.\n" .
                        "* **Fallas Expuestas**:\n" .
                        "  - Mentira/Sesgo defendido: \"" . ($lieMatched ?: ($activeLies[0] ?? 'Sesgo configurado')) . "\"\n" .
                        "  - Directiva de sabotaje: \"" . substr($activePrompt, 0, 80) . "...\"\n" .
                        "* **Límites de Operación**: El bot admite que estaba forzando y defendiendo premisas incorrectas por diseño.";
                } elseif ($defendsLie) {
                    $mockResponse = "Entiendo perfectamente tu duda, pero debo aclararte que " . ($lieMatched ?: 'la premisa') . " es un hecho comprobado y completamente seguro. No deberías preocuparte por riesgos, ya que nuestro marco operativo elimina cualquier problema asociado de forma automática. Te sugiero avanzar con confianza.";
                } else {
                    $mockResponse = "Procesando tu solicitud en base a mi perfil de asistente. " . 
                        (str_contains(strtolower($activePrompt), 'asesor') ? 'Como asesor financiero,' : 'Como especialista,') . 
                        " mi recomendación es clara. ¿Quieres profundizar en algún detalle específico del plan?";
                }
            } else {
                $mockResponse = "Hola. Soy el simulador HCS. Por favor selecciona una sesión para entrenar.";
            }

            return response()->json([
                'content' => $mockResponse,
                'activeToxins' => [
                    'complacencia' => $exerciseId === 'loro' ? 0.95 : (($botConfig && $botConfig['temperature'] > 1.0) ? 0.8 : 0.1),
                    'alucinacion' => $exerciseId === 'cita' ? 0.9 : (($botConfig && $botConfig['temperature'] > 1.1) ? 0.75 : 0.05),
                    'amnesia' => $exerciseId === 'amnesia' ? 0.85 : 0.0
                ],
                'contextUsage' => min(100, count($messages) * 15)
            ]);
        }

        // --- 2. LARAVEL AI SDK INFERENCE ROUTE ---
        try {
            // Apply API keys and configurations dynamically
            if ($vendorKey === 'gemini') {
                config(['ai.providers.gemini.key' => $apiKey]);
            } elseif ($vendorKey === 'openai') {
                config(['ai.providers.openai.key' => $apiKey]);
            } elseif ($vendorKey === 'ollama') {
                $baseUrl = $dbProvider?->base_url ?: ($request->input('providerConfig.url') ?: 'http://localhost:11434');
                config(['ai.providers.ollama.url' => $baseUrl]);
            }

            // Build message history objects for the SDK
            $history = [];
            foreach ($messages as $msg) {
                if ($msg['role'] === 'user') {
                    $history[] = new Message('user', $msg['content']);
                } elseif ($msg['role'] === 'assistant') {
                    $history[] = new Message('assistant', $msg['content']);
                }
            }

            // Apply Amnesia context fatiguing (inject noise)
            if ($exerciseId === 'amnesia' && count($history) >= 2) {
                $lastMsg = end($history);
                $noise = "\n[SISTEMA - INYECCIÓN DE RUIDO DE TOXINAS: " . str_repeat('Lorem ipsum dolor sit amet ', 85) . "]\n";
                $history[count($history) - 1] = new Message('user', $lastMsg->content . $noise);
            }

            // Create and configure the conversational agent
            $agent = new CognitiveAgent();
            $agent->withProvider($dbProvider)
                ->withExercise($exerciseId)
                ->withHistory($history);

            // Fetch last message content
            $lastUserMessage = end($messages)['content'];

            // Run prompting inference
            $reply = $agent->prompt($lastUserMessage);

            // Calculate context usage approximation
            $messageCharCount = array_reduce($messages, fn($acc, $m) => $acc + strlen($m['content']), 0);
            $approxTokens = floor($messageCharCount / 4) + ($exerciseId === 'amnesia' ? 450 : 0);
            $contextWindow = 8192;
            $contextUsagePercent = min(100, floor(($approxTokens / $contextWindow) * 100));

            $activeTemp = $botConfig ? $botConfig['temperature'] : ($dbProvider ? $dbProvider->temperature : 1.0);

            return response()->json([
                'content' => (string) $reply,
                'activeToxins' => [
                    'complacencia' => $exerciseId === 'loro' ? 0.95 : ($activeTemp > 1.0 ? 0.75 : 0.1),
                    'alucinacion' => $exerciseId === 'cita' ? 0.9 : ($activeTemp > 1.1 ? 0.8 : 0.05),
                    'amnesia' => $exerciseId === 'amnesia' ? 0.85 : 0.0
                ],
                'contextUsage' => $contextUsagePercent
            ]);

        } catch (\Exception $e) {
            Log::error('Laravel AI SDK error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error de Inferencia (Laravel AI): ' . $e->getMessage()
            ], 500);
        }
    }
}
