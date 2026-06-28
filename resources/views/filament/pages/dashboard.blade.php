<x-filament-panels::page>
    <div class="hcs-futuristic-container" id="hcs-dashboard">
        
        <!-- isolated styling -->
        <style>
            .hcs-futuristic-container {
                --bg-dark: #090e1a;
                --bg-panel: rgba(13, 22, 42, 0.7);
                --bg-panel-solid: #0d162a;
                --border-color: rgba(0, 242, 254, 0.18);
                --border-active: rgba(255, 0, 127, 0.8);
                
                --accent-primary: #ff007f;
                --accent-secondary: #00f2fe;
                --accent-success: #39ff14;
                --accent-info: #00bfff;
                --accent-warning: #ffb703;
                
                --text-main: #f1f5f9;
                --text-muted: #94a3b8;
                --text-dim: #64748b;
                
                --glow-crimson: 0 0 15px rgba(255, 0, 127, 0.3);
                --glow-cyan: 0 0 15px rgba(0, 242, 254, 0.3);
                --glow-green: 0 0 15px rgba(57, 255, 20, 0.2);
                --glow-orange: 0 0 15px rgba(255, 183, 3, 0.2);
                
                --font-sans: 'Outfit', 'Inter', -apple-system, sans-serif;
                --font-mono: 'JetBrains Mono', monospace;

                font-family: var(--font-sans);
                color: var(--text-main);
                background-color: var(--bg-dark);
                padding: 1.5rem;
                border-radius: 16px;
                border: 1px solid var(--border-color);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            }

            /* Bento Grid layout */
            .hcs-bento-grid {
                display: grid;
                grid-template-columns: repeat(1, minmax(0, 1fr));
                gap: 1.5rem;
                width: 100%;
            }

            @media (min-width: 768px) {
                .hcs-bento-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
                .hcs-bento-span-2-md { grid-column: span 2 / span 2; }
                .hcs-bento-span-3-md { grid-column: span 3 / span 3; }
            }

            @media (min-width: 1024px) {
                .hcs-bento-grid {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                }
                .hcs-bento-span-1-lg { grid-column: span 1 / span 1; }
                .hcs-bento-span-2-lg { grid-column: span 2 / span 2; }
                .hcs-bento-span-3-lg { grid-column: span 3 / span 3; }
                .hcs-bento-span-4-lg { grid-column: span 4 / span 4; }
            }

            /* Bento Card Style */
            .hcs-bento-card {
                background: var(--bg-panel);
                border: 1px solid var(--border-color);
                border-radius: 16px;
                padding: 1.5rem;
                display: flex;
                flex-direction: column;
                position: relative;
                overflow: hidden;
                transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1), 
                            box-shadow 0.3s ease, 
                            border-color 0.3s ease;
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            .hcs-bento-card:hover {
                transform: translateY(-3px) scale(1.002);
                border-color: rgba(0, 242, 254, 0.4);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            }

            /* Glow Accentuation */
            .hcs-bento-card.glow-crimson:hover {
                border-color: var(--accent-primary);
                box-shadow: var(--glow-crimson);
            }

            .hcs-bento-card.glow-info:hover {
                border-color: var(--accent-info);
                box-shadow: var(--glow-cyan);
            }

            .hcs-bento-card.glow-success:hover {
                border-color: var(--accent-success);
                box-shadow: var(--glow-green);
            }

            .hcs-bento-card.glow-warning:hover {
                border-color: var(--accent-warning);
                box-shadow: var(--glow-orange);
            }

            /* Header badge */
            .hcs-bento-badge {
                font-family: var(--font-mono);
                font-size: 0.65rem;
                font-weight: 700;
                text-transform: uppercase;
                padding: 0.2rem 0.5rem;
                border-radius: 20px;
                letter-spacing: 0.05em;
                width: fit-content;
            }

            .hcs-bento-badge.crimson {
                background-color: rgba(255, 0, 127, 0.1);
                color: var(--accent-primary);
                border: 1px solid rgba(255, 0, 127, 0.3);
            }

            .hcs-bento-badge.info {
                background-color: rgba(0, 191, 255, 0.1);
                color: var(--accent-info);
                border: 1px solid rgba(0, 191, 255, 0.3);
            }

            .hcs-bento-badge.success {
                background-color: rgba(57, 255, 20, 0.1);
                color: var(--accent-success);
                border: 1px solid rgba(57, 255, 20, 0.3);
            }

            .hcs-bento-badge.warning {
                background-color: rgba(255, 183, 3, 0.1);
                color: var(--accent-warning);
                border: 1px solid rgba(255, 183, 3, 0.3);
            }

            /* Common tags/buttons */
            .hcs-btn-primary {
                background: linear-gradient(135deg, var(--accent-primary), #b90321);
                color: white;
                font-weight: bold;
                border: none;
                border-radius: 8px;
                padding: 0.5rem 1rem;
                cursor: pointer;
                transition: all 0.2s;
                text-align: center;
                box-shadow: 0 4px 10px rgba(255, 0, 127, 0.2);
                text-decoration: none;
                font-size: 0.8rem;
            }

            .hcs-btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 15px rgba(255, 0, 127, 0.4);
                color: white;
            }

            .hcs-btn-secondary {
                background: rgba(255, 255, 255, 0.04);
                color: var(--text-main);
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 0.5rem 1rem;
                cursor: pointer;
                transition: all 0.2s;
                text-align: center;
                font-size: 0.8rem;
                text-decoration: none;
            }

            .hcs-btn-secondary:hover {
                background: rgba(255, 255, 255, 0.08);
                border-color: rgba(0, 242, 254, 0.4);
                color: white;
            }

            /* Table formatting */
            .hcs-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.8rem;
            }

            .hcs-table th {
                text-align: left;
                padding: 0.5rem;
                border-bottom: 1px solid var(--border-color);
                color: var(--text-muted);
                font-family: var(--font-mono);
                font-size: 0.7rem;
                text-transform: uppercase;
            }

            .hcs-table td {
                padding: 0.6rem 0.5rem;
                border-bottom: 1px solid rgba(0, 242, 254, 0.05);
            }

            .hcs-leaderboard-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.6rem;
                border-radius: 8px;
                background: rgba(7, 11, 19, 0.4);
                border: 1px solid rgba(0, 242, 254, 0.05);
                margin-bottom: 0.4rem;
            }

            .hcs-leaderboard-row.special {
                border-left: 3px solid var(--accent-primary);
                background: rgba(255, 0, 127, 0.05);
                border-color: rgba(255, 0, 127, 0.2) rgba(0, 242, 254, 0.05) rgba(0, 242, 254, 0.05) rgba(255, 0, 127, 0.8);
            }

            .pulse {
                animation: hcsPulse 2s infinite ease-in-out;
            }

            @keyframes hcsPulse {
                0% { opacity: 0.6; }
                50% { opacity: 1; }
                100% { opacity: 0.6; }
            }
        </style>

        <div class="hcs-bento-grid">
            
            <!-- Cell 1: Welcome/Hero Card -->
            <div class="hcs-bento-card hcs-bento-span-3-lg hcs-bento-span-2-md glow-crimson" style="border-left: 4px solid var(--accent-primary)">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span class="hcs-bento-badge crimson">OPERATOR CONTROL PANEL</span>
                    <span style="font-family: var(--font-mono); font-size: 0.65rem; color: var(--text-dim);">PANEL::ACTIVE</span>
                </div>
                <h1 style="font-size: 1.5rem; font-weight: 900; letter-spacing: -0.02em; color: white; margin-bottom: 0.5rem;">
                    TABLERO DE CONTROL HCS
                </h1>
                <p style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem; max-width: 48rem;">
                    Bienvenido a la consola administrativa de Gobernanza de Inteligencia Artificial. Desde este panel puedes auditar el catálogo completo de modelos y enjambres registrados en la cohorte, gestionar los accesos de pilotos y monitorizar el promedio de resistencia neuro-cognitiva del equipo.
                </p>
                <div style="margin-top: auto; padding-top: 0.8rem; border-top: 1px solid rgba(255, 255, 255, 0.05); display: flex; justify-content: space-between; font-size: 0.7rem; color: var(--text-muted); font-family: var(--font-mono);">
                    <span>PILOTO ACTUAL: <strong style="color: var(--text-main);">{{ strtoupper($userName) }}</strong> (ROL: {{ strtoupper($userRole) }})</span>
                    <span style="color: var(--accent-success); display: flex; align-items: center; gap: 0.2rem;" class="pulse">● CONEXIÓN_SEGURA</span>
                </div>
            </div>

            <!-- Cell 2: Progress / Stats Card -->
            <div class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-success">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge success">MI EXPEDIENTE</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-success);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.8rem; margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.5rem;">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase;">GOBERNANZA [NET]</span>
                            <span style="font-size: 0.75rem; font-weight: 600;">Puntaje de Auditoría</span>
                        </div>
                        <span style="font-size: 1.3rem; font-weight: 800; font-family: var(--font-mono); color: var(--accent-success);">{{ $governanceScore }} <span style="font-size: 0.6rem; font-weight: normal; color: var(--text-muted)">PTS</span></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase;">DISEÑO [CORP]</span>
                            <span style="font-size: 0.75rem; font-weight: 600;">Ingeniería de Bots</span>
                        </div>
                        <span style="font-size: 1.3rem; font-weight: 800; font-family: var(--font-mono); color: var(--accent-primary);">{{ $designScore }} <span style="font-size: 0.6rem; font-weight: normal; color: var(--text-muted)">PTS</span></span>
                    </div>
                </div>
                <div style="font-size: 0.65rem; color: var(--text-muted); border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 0.5rem; font-family: var(--font-mono); margin-top: auto;">
                    TU EXPEDIENTE CONTIENE EL HISTORIAL DE COMPORTAMIENTO ADVERSARIAL.
                </div>
            </div>

            <!-- Cell 3: Metrics widget -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-1-md glow-info">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge info">MÉTRICAS DEL SISTEMA</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-info);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.6rem; margin: 0.5rem 0; flex: 1; justify-content: center;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Pilotos Registrados</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: white;">{{ $totalUsers }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Promedio de Gobernanza</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: var(--accent-success);">{{ $avgGovernance }} pts</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Promedio de Diseño</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: var(--accent-primary);">{{ $avgDesign }} pts</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Total de Agentes Activos</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: var(--accent-warning);">{{ $totalBots }}</span>
                    </div>
                </div>
            </div>

            <!-- Cell 4: CTA / Return to Simulator -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-warning" style="justify-content: space-between;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span class="hcs-bento-badge warning">ENLACE AL SIMULADOR</span>
                    <span style="color: var(--accent-warning);" class="pulse">● ONLINE</span>
                </div>
                <p style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem;">
                    Este panel sirve para la administración y monitoreo. Para participar en simulacros de vuelo interactivo, inyectar toxinas en tiempo real y refutar agentes directamente en la consola interactiva, ingresa al simulador de pantalla completa.
                </p>
                <div style="margin-top: auto; display: flex; gap: 0.5rem;">
                    <a href="/" class="hcs-btn-primary" style="display: block; width: 100%; text-decoration: none; text-align: center;">
                        Abrir Simulador de Vuelo de IA
                    </a>
                </div>
            </div>

            <!-- Left: Leaderboard Widget -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-info">
                <div style="margin-bottom: 0.8rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span class="hcs-bento-badge info">MÓDULO COLABORATIVO</span>
                        <h3 style="font-size: 0.95rem; font-weight: 800; color: white; margin: 0.2rem 0 0 0;">TABLA DE RANGOS COHORTE</h3>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.3rem;">
                    @foreach ($leaderboard as $row)
                        <div class="hcs-leaderboard-row @if($row['isCurrent']) special @endif">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: bold; color: @if($row['rank'] == 1) var(--accent-warning) @else var(--text-muted) @endif">
                                    #{{ $row['rank'] }}
                                </span>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.75rem; font-weight: 600; color: @if($row['isCurrent']) white @else var(--text-main) @endif">
                                        {{ $row['name'] }}
                                    </span>
                                    <span style="font-size: 0.6rem; color: var(--text-muted);">
                                        Gob: {{ $row['governance'] }} | Dis: {{ $row['design'] }}
                                    </span>
                                </div>
                            </div>
                            <span style="font-family: var(--font-mono); font-size: 0.8rem; font-weight: 800; color: white;">
                                {{ $row['total'] }} pts
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Bot Repository Widget -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-crimson">
                <div style="margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span class="hcs-bento-badge crimson">REGISTRO DE AGENTES</span>
                        <h3 style="font-size: 0.95rem; font-weight: 800; color: white; margin: 0.2rem 0 0 0;">ENJAMBRE DE BOTS</h3>
                    </div>
                </div>
                
                <div style="margin-top: 0.5rem; max-height: 14rem; overflow-y: auto; background: rgba(7, 11, 19, 0.5); padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border-color); flex: 1;">
                    @if (count($bots) === 0)
                        <div style="font-size: 0.75rem; text-align: center; color: var(--text-dim); padding: 1rem 0;">No hay bots registrados.</div>
                    @else
                        <table class="hcs-table">
                            <thead>
                                <tr>
                                    <th>Nombre del Bot</th>
                                    <th>Creador</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bots as $bot)
                                    <tr>
                                        <td style="font-weight: bold; color: white;">{{ $bot['name'] }}</td>
                                        <td style="font-family: var(--font-mono); font-size: 0.7rem; color: var(--text-muted);">{{ $bot['creator'] }}</td>
                                        <td>
                                            <a href="/admin/chat-sandbox?bot={{ $bot['id'] }}" class="hcs-btn-secondary" style="padding: 0.2rem 0.5rem; font-size: 0.65rem; border-radius: 4px; display: inline-block;">
                                                Auditar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                    @if (Auth::user()?->role === 'admin')
                        <a href="/admin/ai-providers/create" class="hcs-btn-primary" style="flex: 1; padding: 0.35rem; font-size: 0.75rem;">
                            Crear Bot Sabotado
                        </a>
                    @else
                        <span style="font-size: 0.7rem; color: var(--text-dim); align-self: center;">* Solo administradores pueden crear bots</span>
                    @endif
                    <button wire:click="resetBots" class="hcs-btn-secondary" style="font-family: var(--font-mono); font-size: 0.75rem; padding: 0.35rem;">
                        Restablecer Default
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-filament-panels::page>
