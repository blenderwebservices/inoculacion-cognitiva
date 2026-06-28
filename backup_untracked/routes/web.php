<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

use App\Models\User;
use App\Models\AiProvider;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $user = Auth::user();
    
    // Calculate stats
    $users = User::all();
    $totalUsers = $users->count();
    $avgGovernance = 0;
    $avgDesign = 0;
    if ($totalUsers > 0) {
        $avgGovernance = round($users->avg('governance_score'), 1);
        $avgDesign = round($users->avg('design_score'), 1);
    }
    
    $totalBots = AiProvider::count();
    
    // Load leaderboard
    $dbLeaderboard = $users->map(function ($u) {
        $isCurrent = Auth::check() && $u->id === Auth::id();
        return [
            'name' => $isCurrent ? 'Tú (Piloto Actual)' : $u->name,
            'governance' => $u->governance_score,
            'design' => $u->design_score,
            'total' => $u->governance_score + $u->design_score,
            'isCurrent' => $isCurrent,
        ];
    })->toArray();
    
    // Add simulated rows if small
    if (count($dbLeaderboard) < 5) {
        $dbLeaderboard[] = ['name' => 'Auditor_Xenomorfo_9', 'governance' => 250, 'design' => 150, 'total' => 400, 'isCurrent' => false];
        $dbLeaderboard[] = ['name' => 'Ingeniero_Parasitos_A', 'governance' => 180, 'design' => 200, 'total' => 380, 'isCurrent' => false];
        $dbLeaderboard[] = ['name' => 'Piloto_Cognitivo_Beta', 'governance' => 220, 'design' => 100, 'total' => 320, 'isCurrent' => false];
    }
    
    usort($dbLeaderboard, function ($a, $b) {
        return $b['total'] <=> $a['total'];
    });
    
    $leaderboard = [];
    foreach ($dbLeaderboard as $index => $row) {
        $row['rank'] = $index + 1;
        $leaderboard[] = $row;
    }
    
    // Load bots list
    $bots = AiProvider::all()->map(function ($bot) {
        return [
            'id' => $bot->id,
            'name' => $bot->name,
            'creator' => $bot->creator,
            'description' => $bot->description ?: 'Agente HCS configurado en Filament',
            'temperature' => $bot->temperature,
        ];
    })->toArray();

    return view('landing', compact('user', 'totalUsers', 'avgGovernance', 'avgDesign', 'totalBots', 'leaderboard', 'bots'));
});

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
});

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [ApiController::class, 'login']);
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::get('/user', [ApiController::class, 'user']);
    Route::get('/bots', [ApiController::class, 'bots']);
    Route::post('/bots', [ApiController::class, 'createBot']);
    Route::post('/bots/reset', [ApiController::class, 'resetBots']);
    Route::post('/chat', [ApiController::class, 'chat']);
});
