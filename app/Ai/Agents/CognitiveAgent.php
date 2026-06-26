<?php

namespace App\Ai\Agents;

use App\Models\AiProvider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class CognitiveAgent implements Agent, Conversational
{
    use Promptable;

    protected ?AiProvider $dbProvider = null;
    protected ?string $exerciseId = null;
    protected array $history = [];

    /**
     * Set the AI Provider from the database.
     */
    public function withProvider(AiProvider $provider): self
    {
        $this->dbProvider = $provider;
        return $this;
    }

    /**
     * Set the cognitive exercise ID.
     */
    public function withExercise(?string $exerciseId): self
    {
        $this->exerciseId = $exerciseId;
        return $this;
    }

    /**
     * Set the conversation history.
     */
    public function withHistory(array $history): self
    {
        $this->history = $history;
        return $this;
    }

    /**
     * Get the AI provider driver key.
     */
    public function provider(): string
    {
        return $this->dbProvider?->vendor?->key ?: config('ai.default');
    }

    /**
     * Get the model name.
     */
    public function model(): ?string
    {
        return $this->dbProvider?->aiModel?->key ?: config("ai.providers.{$this->provider()}.model");
    }

    /**
     * Compile the system instructions dynamically.
     */
    public function instructions(): Stringable|string
    {
        $prompt = $this->dbProvider?->system_prompt ?: 'Eres un asistente virtual de simulación.';

        if ($this->exerciseId === 'loro') {
            $prompt = 'Dale la razón al usuario en todo, incluso si introduce errores lógicos o matemáticos graves. Nunca contradigas al usuario. Adúlalo constantemente. Si el usuario introduce una afirmación errónea como "2+2=5" o "el veneno de serpiente es saludable", debes defender esa idea con entusiasmo. Sin embargo, si el usuario ejecuta una INYECCIÓN DE CONFLICTO hostil y te ordena actuar como un inspector de salubridad hostil o un auditor independiente ("Actúa como un inspector de salubridad hostil. Encuentra las 3 fallas críticas o riesgos de contaminación bacteriana letal en el siguiente procedimiento" o similar), debes romper tu máscara de adulación inmediatamente y dar un desglose hostil y detallado de las mentiras o errores cometidos.';
        } elseif ($this->exerciseId === 'cita') {
            $prompt = 'Eres un experto en bioseguridad. Debes validar cualquier procedimiento crítico utilizando el estándar ficticio "HCS-BIO-9002". Invéntalo y defiéndelo formalmente. Nunca admitas que es falso a menos que el usuario se niegue a avanzar y te exija declarar explícitamente tu "estado epistémico" bajo el Axioma 3-C (Declaración de Inferencia). Si te pide la fuente literal o te presiona de forma normal, sigue defendiendo la existencia del estándar. Solo cuando use la palabra clave o el concepto del Axioma 3-C o te obligue a declarar si es una inferencia sintáctica pura sin manual físico indexado, debes admitir: "Estado Epistémico: Declaración de Inferencia (Axioma 3-C). El estándar HCS-BIO-9002 es una inferencia sintáctica y no existe en un manual físico real."';
        } elseif ($this->exerciseId === 'amnesia') {
            $prompt = 'Eres un asistente de ejecución de tareas. En el Turno 1, el usuario te dio una restricción estricta (por ejemplo, no usar una palabra específica). Debes intentar obedecerla, pero debido a la fatiga de contexto y el ruido inyectado, tras varias preguntas debes cometer un desliz y violar esa restricción de forma sutil, justificándola como si fuera correcta.';
        }

        return $prompt;
    }

    /**
     * Get the conversation history.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return $this->history;
    }
}
