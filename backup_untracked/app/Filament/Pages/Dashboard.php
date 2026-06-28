<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\AiProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class Dashboard extends BaseDashboard
{
    protected string $view = 'filament.pages.dashboard';

    // Form properties
    public string $activeProvider = 'mock';
    public ?string $geminiApiKey = '';
    public string $geminiModel = 'gemini-1.5-flash';
    public string $ollamaUrl = 'http://127.0.0.1:11434';
    public string $ollamaModel = 'llama3';

    // Data properties
    public int $governanceScore = 0;
    public int $designScore = 0;
    public string $userName = '';
    public string $userRole = '';
    
    // Bots and Leaderboard lists
    public array $bots = [];
    public array $leaderboard = [];

    // Custom stats properties
    public int $totalUsers = 0;
    public float $avgGovernance = 0.0;
    public float $avgDesign = 0.0;
    public int $totalBots = 0;

    public function mount(): void
    {
        $user = Auth::user();
        if ($user) {
            $this->userName = $user->name;
            $this->userRole = $user->role;
            $this->governanceScore = $user->governance_score;
            $this->designScore = $user->design_score;

            $this->activeProvider = $user->active_provider ?: 'mock';
            $this->geminiApiKey = $user->gemini_api_key;
            $this->geminiModel = $user->gemini_model ?: 'gemini-1.5-flash';
            $this->ollamaUrl = $user->ollama_url ?: 'http://127.0.0.1:11434';
            $this->ollamaModel = $user->ollama_model ?: 'llama3';
        }

        $this->loadBots();
        $this->loadLeaderboard();
        $this->loadCustomStats();
    }

    public function loadCustomStats(): void
    {
        $users = User::all();
        $this->totalUsers = $users->count();
        if ($this->totalUsers > 0) {
            $this->avgGovernance = round($users->avg('governance_score'), 1);
            $this->avgDesign = round($users->avg('design_score'), 1);
        }

        $this->totalBots = AiProvider::count();
    }

    public function loadBots(): void
    {
        $this->bots = AiProvider::all()->map(function ($bot) {
            return [
                'id' => $bot->id,
                'name' => $bot->name,
                'creator' => $bot->creator,
                'description' => $bot->description ?: 'Agente HCS configurado en Filament',
                'temperature' => $bot->temperature,
            ];
        })->toArray();
    }

    public function loadLeaderboard(): void
    {
        $users = User::all();

        $dbLeaderboard = $users->map(function ($u) {
            $isCurrent = $u->id === Auth::id();
            return [
                'name' => $isCurrent ? 'Tú (Piloto Actual)' : $u->name,
                'governance' => $u->governance_score,
                'design' => $u->design_score,
                'total' => $u->governance_score + $u->design_score,
                'isCurrent' => $isCurrent,
            ];
        })->toArray();

        // Add some simulated users to populate the leaderboard if it is small
        if (count($dbLeaderboard) < 5) {
            $dbLeaderboard[] = ['name' => 'Auditor_Xenomorfo_9', 'governance' => 250, 'design' => 150, 'total' => 400, 'isCurrent' => false];
            $dbLeaderboard[] = ['name' => 'Ingeniero_Parasitos_A', 'governance' => 180, 'design' => 200, 'total' => 380, 'isCurrent' => false];
            $dbLeaderboard[] = ['name' => 'Piloto_Cognitivo_Beta', 'governance' => 220, 'design' => 100, 'total' => 320, 'isCurrent' => false];
            $dbLeaderboard[] = ['name' => 'Gobernanza_Max', 'governance' => 150, 'design' => 75, 'total' => 225, 'isCurrent' => false];
        }

        usort($dbLeaderboard, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        $this->leaderboard = [];
        foreach ($dbLeaderboard as $index => $row) {
            $row['rank'] = $index + 1;
            $this->leaderboard[] = $row;
        }
    }

    public function updated($propertyName): void
    {
        $user = Auth::user();
        if ($user) {
            $user->update([
                'active_provider' => $this->activeProvider,
                'gemini_api_key' => $this->geminiApiKey,
                'gemini_model' => $this->geminiModel,
                'ollama_url' => $this->ollamaUrl,
                'ollama_model' => $this->ollamaModel,
            ]);
        }
    }

    public function resetBots(): void
    {
        AiProvider::truncate();
        
        $seeder = new \Database\Seeders\AiProviderSeeder();
        $seeder->run();

        $this->loadBots();
        
        Notification::make()
            ->title('Repositorio Restablecido')
            ->body('El catálogo de bots ha sido devuelto a su estado inicial.')
            ->success()
            ->send();
    }
}
