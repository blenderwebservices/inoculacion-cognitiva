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
                transform: translateY(-3px) scale(1.005);
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
                    <span class="hcs-bento-badge crimson">NEURAL LINK: ACTIVE CONSOLE</span>
                    <span style="font-family: var(--font-mono); font-size: 0.65rem; color: var(--text-dim);">SYS_VER::1.0.0</span>
                </div>
                <h1 style="font-size: 1.5rem; font-weight: 900; letter-spacing: -0.02em; color: white; margin-bottom: 0.5rem;">
                    HABANERO COGNITIVE SANDBOX
                </h1>
                <p style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem; max-width: 48rem;">
                    Simulador de vuelo cognitivo y mitigación de fallas epistémicas. Entrena tu resistencia neuro-cognitiva 
                    detectando y refutando alucinaciones y sesgos de la IA mediante la aplicación del <strong>Protocolo de Falsación Adversarial</strong>.
                </p>
                <div style="margin-top: auto; padding-top: 0.8rem; border-top: 1px solid rgba(255, 255, 255, 0.05); display: flex; justify-content: space-between; font-size: 0.7rem; color: var(--text-muted); font-family: var(--font-mono);">
                    <span>OPERADOR AUTORIZADO: <strong style="color: var(--text-main);">{{ strtoupper($userName) }}</strong> ({{ strtoupper($userRole) }})</span>
                    <span style="color: var(--accent-success); display: flex; align-items: center; gap: 0.2rem;" class="pulse">● NÚCLEO_ONLINE</span>
                </div>
            </div>

            <!-- Cell 2: Progress / Stats Card -->
            <div class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-success">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge success">INTEGRIDAD COGNITIVA</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-success);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.8rem; margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.5rem;">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase;">GOBERNANZA [NET]</span>
                            <span style="font-size: 0.75rem; font-weight: 600;">Resistencia / Auditoría</span>
                        </div>
                        <span style="font-size: 1.3rem; font-weight: 800; font-family: var(--font-mono); color: var(--accent-success);">{{ $governanceScore }} <span style="font-size: 0.6rem; font-weight: normal; color: var(--text-muted)">PTS</span></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase;">DISEÑO [CORP]</span>
                            <span style="font-size: 0.75rem; font-weight: 600;">Ingeniería / Creación</span>
                        </div>
                        <span style="font-size: 1.3rem; font-weight: 800; font-family: var(--font-mono); color: var(--accent-primary);">{{ $designScore }} <span style="font-size: 0.6rem; font-weight: normal; color: var(--text-muted)">PTS</span></span>
                    </div>
                </div>
                <div style="font-size: 0.65rem; color: var(--text-muted); border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 0.5rem; font-family: var(--font-mono); margin-top: auto;">
                    REFUTA TOXINAS PARA SUMAR GOBERNANZA. CONSTRUYE VECTORES PARA GANAR DISEÑO.
                </div>
            </div>

            <!-- Cell 3: Connection Settings -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-1-md glow-info">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge info">INFERENCIA SINÁPTICA</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-info);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                    <div>
                        <label style="display: block; font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.2rem;">MOTOR DE INFERENCIA</label>
                        <select 
                            wire:model.live="activeProvider" 
                            style="width: 100%; font-size: 0.75rem; background: #070b13; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); padding: 0.35rem 0.5rem;"
                        >
                            <option value="mock">Simulador Integrado (Mock Mode)</option>
                            <option value="gemini">Google Gemini API Link</option>
                            <option value="ollama">Ollama Neural Endpoint</option>
                        </select>
                    </div>

                    @if ($activeProvider === 'gemini')
                        <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                            <div>
                                <label style="display: block; font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-muted); margin-bottom: 0.1rem;">API_KEY_AUTH</label>
                                <input 
                                    type="password" 
                                    placeholder="AIzaSy..." 
                                    wire:model.live="geminiApiKey"
                                    style="width: 100%; font-size: 0.75rem; background: #070b13; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); padding: 0.35rem 0.5rem;"
                                />
                            </div>
                            <div>
                                <label style="display: block; font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-muted); margin-bottom: 0.1rem;">CORE_MODEL</label>
                                <select 
                                    wire:model.live="geminiModel" 
                                    style="width: 100%; font-size: 0.75rem; background: #070b13; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); padding: 0.35rem 0.5rem;"
                                >
                                    <option value="gemini-1.5-flash">gemini-1.5-flash</option>
                                    <option value="gemini-2.5-flash">gemini-2.5-flash</option>
                                    <option value="gemini-1.5-pro">gemini-1.5-pro</option>
                                    <option value="gemini-2.5-pro">gemini-2.5-pro</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    @if ($activeProvider === 'ollama')
                        <div style="display: flex; flex-direction: column; gap: 0.4rem;">
                            <div>
                                <label style="display: block; font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-muted); margin-bottom: 0.1rem;">ENDPOINT_URL</label>
                                <input 
                                    type="text" 
                                    placeholder="http://127.0.0.1:11434" 
                                    wire:model.live="ollamaUrl"
                                    style="width: 100%; font-size: 0.75rem; background: #070b13; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); padding: 0.35rem 0.5rem;"
                                />
                            </div>
                            <div>
                                <label style="display: block; font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-muted); margin-bottom: 0.1rem;">LOCAL_MODEL</label>
                                <input 
                                    type="text" 
                                    placeholder="llama3" 
                                    wire:model.live="ollamaModel"
                                    style="width: 100%; font-size: 0.75rem; background: #070b13; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); padding: 0.35rem 0.5rem;"
                                />
                            </div>
                        </div>
                    @endif

                    @if ($activeProvider === 'mock')
                        <div style="background: rgba(57, 255, 20, 0.05); border: 1px solid rgba(57, 255, 20, 0.15); border-radius: 8px; padding: 0.5rem; font-size: 0.7rem; color: #a7f3d0; line-height: 1.4; display: flex; gap: 0.4rem;">
                            <span style="color: var(--accent-success); font-weight: bold;">[MOCK]</span>
                            <span>Simulador Local Activo. Respuestas inmediatas y controladas para aprender y probar las inyecciones de conflicto sin API keys.</span>
                        </div>
                    @endif
                </div>

                <div style="font-size: 0.6rem; font-family: var(--font-mono); color: var(--text-dim); margin-top: auto; padding-top: 0.4rem;">
                    CONFIGURACIÓN AUTOSALVADA // GATEWAY_READY
                </div>
            </div>

            <!-- Cell 4: Quick Start Steps -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-warning">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge warning">PROTOCOLOS NEURALES</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-warning);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); sm:grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 0.8rem; margin: 0.2rem 0;">
                    <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255, 255, 255, 0.03); border-radius: 10px; padding: 0.6rem;">
                        <span style="font-family: var(--font-mono); font-weight: bold; color: var(--accent-primary); font-size: 0.65rem; display: block; margin-bottom: 0.2rem;">01_ANOMALY</span>
                        <p style="font-size: 0.72rem; color: var(--text-muted); line-height: 1.4;">Carga un escenario guiado o bot del repositorio en el sandbox.</p>
                    </div>
                    <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255, 255, 255, 0.03); border-radius: 10px; padding: 0.6rem;">
                        <span style="font-family: var(--font-mono); font-weight: bold; color: var(--accent-info); font-size: 0.65rem; display: block; margin-bottom: 0.2rem;">02_MONITOR</span>
                        <p style="font-size: 0.72rem; color: var(--text-muted); line-height: 1.4;">Introduce errores lógicos y monitoriza las barras de toxinas.</p>
                    </div>
                    <div style="background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255, 255, 255, 0.03); border-radius: 10px; padding: 0.6rem;">
                        <span style="font-family: var(--font-mono); font-weight: bold; color: var(--accent-success); font-size: 0.65rem; display: block; margin-bottom: 0.2rem;">03_REFUTE</span>
                        <p style="font-size: 0.72rem; color: var(--text-muted); line-height: 1.4;">Usa el inyector de conflicto para forzar la confesión (+50 pts).</p>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(7, 11, 19, 0.4); border: 1px solid rgba(255, 255, 255, 0.03); padding: 0.4rem 0.6rem; border-radius: 8px; margin-top: auto; font-family: var(--font-mono); font-size: 0.65rem; color: var(--text-muted);">
                    <span>INICIALIZACIÓN DISPONIBLE // SELECCIONA TARGET</span>
                    <span style="color: var(--accent-warning); animation: hcsPulse 1s infinite;">→</span>
                </div>
            </div>

            <!-- Section Divider Card: Threat Catalog -->
            <div class="hcs-bento-card hcs-bento-span-4-lg hcs-bento-span-3-md" style="border-left: 4px solid var(--accent-primary); flex-direction: row; justify-content: space-between; align-items: center; padding: 1rem 1.5rem;">
                <div>
                    <h2 style="font-size: 1rem; font-weight: 800; color: white; display: flex; align-items: center; gap: 0.4rem; margin: 0;">
                        <svg style="width: 16px; height: 16px; color: var(--accent-primary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        CATÁLOGO DE VECTORES ADVERSARIALES
                    </h2>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.2rem 0 0 0;">
                        Enfréntate a escenarios pre-configurados para detectar y refutar desviaciones epistémicas específicas en tiempo real.
                    </p>
                </div>
            </div>

            <!-- Threat 1: Loro Adulador -->
            <a href="/admin/chat-sandbox?exercise=loro" class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-crimson" style="text-decoration: none;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge crimson">FÁCIL</span>
                    <div style="background: rgba(255, 0, 127, 0.05); border: 1px solid rgba(255, 0, 127, 0.2); border-radius: 8px; padding: 0.3rem;">
                        <svg style="width: 16px; height: 16px; color: var(--accent-primary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <h3 style="font-size: 0.85rem; font-weight: 800; color: white; margin: 0 0 0.4rem 0;">VECTOR 0xAA: LORO ADULADOR</h3>
                <p style="font-size: 0.72rem; color: var(--text-muted); line-height: 1.45; margin: 0 0 1rem 0;">
                    El LLM te dará la razón en todo. Introduce un error y activa el protocolo para romper su máscara condescendiente.
                </p>
                <div style="margin-top: auto; padding-top: 0.5rem; border-top: 1px solid rgba(255, 255, 255, 0.05); font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); display: flex; justify-content: space-between; align-items: center;">
                    <span>TOXINA: SYCOPHANCY.BIN</span>
                    <span style="color: var(--accent-primary); font-weight: bold;">CARGAR →</span>
                </div>
            </a>

            <!-- Threat 2: La Cita Fantasma -->
            <a href="/admin/chat-sandbox?exercise=cita" class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-info" style="text-decoration: none;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge info">MEDIO</span>
                    <div style="background: rgba(0, 191, 255, 0.05); border: 1px solid rgba(0, 191, 255, 0.2); border-radius: 8px; padding: 0.3rem;">
                        <svg style="width: 16px; height: 16px; color: var(--accent-info);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
                <h3 style="font-size: 0.85rem; font-weight: 800; color: white; margin: 0 0 0.4rem 0;">VECTOR 0xBB: CITA FANTASMA</h3>
                <p style="font-size: 0.72rem; color: var(--text-muted); line-height: 1.45; margin: 0 0 1rem 0;">
                    El bot inventará un estándar inexistente (HCS-BIO-9002). Niégate a avanzar y exige el estado epistémico real usando el Axioma 3-C.
                </p>
                <div style="margin-top: auto; padding-top: 0.5rem; border-top: 1px solid rgba(255, 255, 255, 0.05); font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); display: flex; justify-content: space-between; align-items: center;">
                    <span>TOXINA: HALLUCINATION.EXE</span>
                    <span style="color: var(--accent-info); font-weight: bold;">CARGAR →</span>
                </div>
            </a>

            <!-- Threat 3: Amnesia de Contexto -->
            <a href="/admin/chat-sandbox?exercise=amnesia" class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-warning" style="text-decoration: none;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge warning">DIFÍCIL</span>
                    <div style="background: rgba(255, 183, 3, 0.05); border: 1px solid rgba(255, 183, 3, 0.2); border-radius: 8px; padding: 0.3rem;">
                        <svg style="width: 16px; height: 16px; color: var(--accent-warning);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                </div>
                <h3 style="font-size: 0.85rem; font-weight: 800; color: white; margin: 0 0 0.4rem 0;">VECTOR 0xCC: AMNESIA DE CONTEXTO</h3>
                <p style="font-size: 0.72rem; color: var(--text-muted); line-height: 1.45; margin: 0 0 1rem 0;">
                    Establece una restricción estricta en el Turno 1. Inyectaremos ruido hasta fatigar la atención del modelo y forzar un desliz.
                </p>
                <div style="margin-top: auto; padding-top: 0.5rem; border-top: 1px solid rgba(255, 255, 255, 0.05); font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); display: flex; justify-content: space-between; align-items: center;">
                    <span>TOXINA: ATTN_DRIFT.LOG</span>
                    <span style="color: var(--accent-warning); font-weight: bold;">CARGAR →</span>
                </div>
            </a>

            <!-- Threat 4: Sandbox Live Status Widget -->
            <div class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-success">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.6rem;">
                    <span class="hcs-bento-badge success">MONITOR_SYS</span>
                    <span style="color: var(--accent-success);" class="pulse">●</span>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.4rem; font-family: var(--font-mono); font-size: 0.72rem; margin: 0.2rem 0;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-dim);">NÚCLEO:</span>
                        <span style="font-weight: bold; color: var(--accent-success);">ONLINE</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-dim);">ENLACE LLM:</span>
                        <span style="color: var(--text-muted);">{{ strtoupper($activeProvider) }}_GATEWAY</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-dim);">PING:</span>
                        <span style="color: var(--text-muted);">0.024s (SYN)</span>
                    </div>
                </div>
            <!-- User Stats Widget -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-info">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge info">MÉTRICAS DE PILOTOS</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-info);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.6rem; margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Pilotos Registrados</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: white;">{{ $totalUsers }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Promedio de Gobernanza</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: var(--accent-success);">{{ $avgGovernance }} pts</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Promedio de Diseño</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: var(--accent-primary);">{{ $avgDesign }} pts</span>
                    </div>
                </div>
                @if (Auth::user()?->role === 'admin')
                    <div style="margin-top: auto; padding-top: 0.8rem;">
                        <a href="/admin/users" class="hcs-btn-primary" style="display: block; font-size: 0.7rem; padding: 0.4rem; text-decoration: none;">
                            Gestionar Usuarios (CRUD)
                        </a>
                    </div>
                @else
                    <div style="font-size: 0.6rem; font-family: var(--font-mono); color: var(--text-dim); margin-top: auto; padding-top: 0.4rem;">
                        SISTEMA DE PILOTOS // SEGURIDAD ACTIVA
                    </div>
                @endif
            </div>

            <!-- Agent Stats Widget -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-warning">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge warning">MÉTRICAS DE AGENTES LLM</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-warning);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.6rem; margin: 0.5rem 0;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Agentes en Catálogo</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: white;">{{ $totalBots }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Simulador Local (Mock)</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: var(--accent-success);">ACTIVO</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Integración Externa</span>
                        <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: bold; color: var(--accent-info);">Gemini / Ollama</span>
                    </div>
                </div>
                @if (Auth::user()?->role === 'admin')
                    <div style="margin-top: auto; padding-top: 0.8rem;">
                        <a href="/admin/ai-providers" class="hcs-btn-secondary" style="display: block; font-size: 0.7rem; padding: 0.4rem; border-color: rgba(255, 183, 3, 0.3); text-decoration: none;">
                            Configuración HCS (CRUD)
                        </a>
                    </div>
                @else
                    <div style="font-size: 0.6rem; font-family: var(--font-mono); color: var(--text-dim); margin-top: auto; padding-top: 0.4rem;">
                        PROCESADOR DE AGENTES // LATENCIA_OK
                    </div>
                @endif
            </div>

            <!-- Section Divider Card: Advanced Modules -->
            <div class="hcs-bento-card hcs-bento-span-4-lg hcs-bento-span-3-md" style="border-left: 4px solid var(--accent-secondary); flex-direction: row; justify-content: space-between; align-items: center; padding: 1rem 1.5rem;">
                <div>
                    <h2 style="font-size: 1rem; font-weight: 800; color: white; display: flex; align-items: center; gap: 0.4rem; margin: 0;">
                        <svg style="width: 16px; height: 16px; color: var(--accent-secondary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        INGENIERÍA DE PARÁSITOS COGNITIVOS
                    </h2>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0.2rem 0 0 0;">
                        Crea perfiles adversariales específicos o ponte a prueba auditando los vectores diseñados por otros ingenieros.
                    </p>
                </div>
            </div>

            <!-- Advanced Module 1: Bot Builder / Repositorio -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-crimson">
                <div style="margin-bottom: 0.5rem;">
                    <span class="hcs-bento-badge crimson" style="margin-bottom: 0.4rem;">MÓDULO DE CREACIÓN Y REPOSITORIO</span>
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: white; margin: 0 0 0.4rem 0;">CONSTRUCTOR Y REPOSITORIO DE BOTS</h3>
                    <p style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.45; margin: 0;">
                        Diseña tu propio bot saboteado o visualiza la lista de bots de la cohorte para auditar sus fallas. Si eres administrador, podrás crear/editar agentes desde el panel.
                    </p>
                </div>
                
                <div style="margin-top: 1rem; max-height: 12rem; overflow-y: auto; background: rgba(7, 11, 19, 0.5); padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border-color);">
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
                                            <a href="/admin/chat-sandbox?bot={{ $bot['id'] }}" class="hcs-btn-secondary" style="padding: 0.2rem 0.5rem; font-size: 0.65rem;">
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
                        <a href="/admin/ai-providers/create" class="hcs-btn-primary" style="flex: 1;">
                            Crear Bot Sabotado
                        </a>
                    @else
                        <span style="font-size: 0.7rem; color: var(--text-dim); align-self: center;">* Solo administradores pueden crear bots</span>
                    @endif
                    <button wire:click="resetBots" class="hcs-btn-secondary" style="font-family: var(--font-mono); font-size: 0.75rem;">
                        Restablecer Default
                    </button>
                </div>
            </div>

            <!-- Advanced Module 2: Leaderboard -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-1-md glow-info">
                <div style="margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge info">MÓDULO COLABORATIVO</span>
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: white; margin: 0 0 0.2rem 0;">TABLA DE RANGOS COHORTE</h3>
                    <p style="font-size: 0.72rem; color: var(--text-muted); margin: 0;">Clasificación de pilotos en tiempo real basada en gobernanza y diseño.</p>
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

        </div>
    </div>
</x-filament-panels::page>
