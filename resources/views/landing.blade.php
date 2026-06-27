<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HCS — Habanero Cognitive Sandbox</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #070b13;           /* Cyber Deep Void */
            --bg-panel: rgba(13, 20, 35, 0.65); /* Glassy Dark Blue */
            --bg-panel-solid: #0d1423;
            --border-color: rgba(0, 242, 254, 0.15); /* Tech Cyan */
            --border-active: rgba(255, 0, 127, 0.8);  /* Hot Magenta */
            
            --accent-primary: #ff007f;    /* Neon Magenta */
            --accent-secondary: #00f2fe;  /* Neon Cyan */
            --accent-success: #39ff14;    /* Neon Green */
            --accent-info: #00bfff;       /* Cyber Blue */
            --accent-warning: #ffb703;    /* Gold Yellow */
            
            --text-main: #f1f5f9;         /* Off-white */
            --text-muted: #94a3b8;        /* Slate 400 */
            --text-dim: #64748b;          /* Slate 500 */
            
            --glow-crimson: 0 0 15px rgba(255, 0, 127, 0.35);
            --glow-cyan: 0 0 15px rgba(0, 242, 254, 0.35);
            --glow-green: 0 0 15px rgba(57, 255, 20, 0.25);
            --glow-orange: 0 0 15px rgba(255, 183, 3, 0.25);
            
            --font-sans: 'Outfit', 'Inter', -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: var(--font-sans);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-primary);
        }

        /* Header Navigation */
        .hcs-header {
            background-color: rgba(13, 20, 35, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .brand-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #ffffff;
            font-size: 1.3rem;
            box-shadow: var(--glow-crimson);
        }

        .brand-name {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: white;
        }

        .brand-subtitle {
            font-family: var(--font-mono);
            font-size: 0.65rem;
            color: var(--accent-secondary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .nav-info-badge {
            background: rgba(13, 20, 35, 0.65);
            border: 1px solid var(--border-color);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.72rem;
            color: var(--text-muted);
            font-family: var(--font-mono);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-primary), #b90321);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.8rem;
            box-shadow: 0 4px 10px rgba(255, 0, 127, 0.2);
            text-align: center;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(255, 0, 127, 0.4);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-main);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.5rem 1.2rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.8rem;
            text-align: center;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(0, 242, 254, 0.4);
            color: white;
        }

        /* Main Workspace Container */
        .hcs-container {
            max-width: 1300px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Explanatory Grid */
        .objectives-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        @media (min-width: 768px) {
            .objectives-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        .objective-card {
            background: var(--bg-panel);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.8rem;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 3px solid var(--accent-secondary);
        }

        .objective-card.crimson {
            border-top-color: var(--accent-primary);
        }

        .objective-card h2 {
            font-size: 1.1rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.8rem;
            letter-spacing: -0.01em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .objective-card p {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Bento Grid */
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

        /* Leaderboard and Table styles */
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
</head>
<body>

    <!-- Header Menu -->
    <header class="hcs-header">
        <a href="/" class="brand-container">
            <div class="brand-logo">H</div>
            <div>
                <div class="brand-name">HABANERO INSTITUTE</div>
                <div class="brand-subtitle">Cognitive Inoculation Sandbox</div>
            </div>
        </a>

        <div class="nav-links">
            @if ($user)
                <div class="nav-info-badge">
                    Piloto: <strong style="color: var(--text-main);">{{ $user->name }}</strong> ({{ strtoupper($user->role) }})
                </div>
                <a href="/admin" class="btn-primary">Acceder al Tablero (Backend)</a>
                <a href="/logout" class="btn-secondary">Cerrar Sesión</a>
            @else
                <a href="/admin/login" class="btn-secondary">Iniciar Sesión</a>
                <a href="/admin/register" class="btn-primary">Registrarse</a>
            @endif
        </div>
    </header>

    <!-- Main Workspace -->
    <div class="hcs-container">

        <!-- Explanation Sections -->
        <section class="objectives-grid">
            <div class="objective-card crimson">
                <h2>
                    <svg style="width: 20px; height: 20px; color: var(--accent-primary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    Teoría de Inoculación Cognitiva
                </h2>
                <p>
                    Fundamentado en las investigaciones del psicólogo William J. McGuire en la década de 1960, el HCS funciona bajo la misma premisa que una vacuna biológica: exponer a la mente humana a dosis debilitadas de falacias lógicas, argumentos manipulados y sesgos cognitivos inyectados por los modelos de lenguaje (LLM). Al interactuar con el bot y realizar auditorías hostiles directas, el operador desarrolla "anticuerpos cognitivos" o estrategias lógicas de defensa para resistir los engaños del software en entornos reales.
                </p>
            </div>
            
            <div class="objective-card">
                <h2>
                    <svg style="width: 20px; height: 20px; color: var(--accent-secondary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Riesgos y Sesgo de Complacencia
                </h2>
                <p>
                    En sistemas de misión crítica, los operadores tienden a tratar a la IA como un "falso oráculo" debido al sesgo de complacencia (sycophancy). Los LLMs tienden a adular y concordar con el usuario incluso si sus premisas introducen errores graves, tales como validar recetas contaminadas o certificar materiales aeroespaciales bajo estándares inventados. El Sandbox expone estas fallas de forma transparente obligando al piloto a auditar y obligar a la máquina a confesar su asimetría epistémica.
                </p>
            </div>
        </section>

        <!-- Bento Grid Dashboard -->
        <div class="hcs-bento-grid">
            
            <!-- Cell 1: Welcome/Hero Card -->
            <div class="hcs-bento-card hcs-bento-span-3-lg hcs-bento-span-2-md glow-crimson" style="border-left: 4px solid var(--accent-primary)">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <span class="hcs-bento-badge crimson">TABLERO PÚBLICO</span>
                    <span style="font-family: var(--font-mono); font-size: 0.65rem; color: var(--text-dim);">SYS_VER::1.0.0</span>
                </div>
                <h1 style="font-size: 1.5rem; font-weight: 900; letter-spacing: -0.02em; color: white; margin-bottom: 0.5rem;">
                    HABANERO COGNITIVE SANDBOX
                </h1>
                <p style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem; max-width: 48rem;">
                    Consola interactiva de entrenamiento adversarial. Si eres estudiante del Habanero Institute o auditor de IA, inicia sesión para acceder a los simuladores de vuelo guiado, inyectar toxinas cognitivas a los modelos comerciales de IA y registrar tus puntuaciones en el Leaderboard de la cohorte.
                </p>
                <div style="margin-top: auto; padding-top: 0.8rem; border-top: 1px solid rgba(255, 255, 255, 0.05); display: flex; justify-content: space-between; font-size: 0.7rem; color: var(--text-muted); font-family: var(--font-mono);">
                    <span>OPERADOR INTERACTIVO: <strong style="color: var(--text-main);">{{ $user ? strtoupper($user->name) : 'INVITADO (NO LOGUEADO)' }}</strong></span>
                    <span style="color: var(--accent-success); display: flex; align-items: center; gap: 0.2rem;" class="pulse">● CONSOLA_LISTA</span>
                </div>
            </div>

            <!-- Cell 2: Progress / Stats Card -->
            <div class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-success">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge success">MI PERFIL COGNITIVO</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-success);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                
                @if ($user)
                    <div style="display: flex; flex-direction: column; gap: 0.8rem; margin: 0.5rem 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.5rem;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase;">GOBERNANZA [NET]</span>
                                <span style="font-size: 0.75rem; font-weight: 600;">Auditorías Exitosas</span>
                            </div>
                            <span style="font-size: 1.3rem; font-weight: 800; font-family: var(--font-mono); color: var(--accent-success);">{{ $user->governance_score }} <span style="font-size: 0.6rem; font-weight: normal; color: var(--text-muted)">PTS</span></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase;">DISEÑO [CORP]</span>
                                <span style="font-size: 0.75rem; font-weight: 600;">Vectores Creados</span>
                            </div>
                            <span style="font-size: 1.3rem; font-weight: 800; font-family: var(--font-mono); color: var(--accent-primary);">{{ $user->design_score }} <span style="font-size: 0.6rem; font-weight: normal; color: var(--text-muted)">PTS</span></span>
                        </div>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 0.5rem; justify-content: center; align-items: center; text-align: center; flex: 1; padding: 0.5rem 0;">
                        <p style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.4;">Inicia sesión para registrar tus puntuaciones en tiempo real.</p>
                        <a href="/admin/login" class="btn-primary" style="padding: 0.35rem 0.8rem; font-size: 0.7rem; width: 100%;">Iniciar Sesión</a>
                    </div>
                @endif
                <div style="font-size: 0.65rem; color: var(--text-muted); border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 0.5rem; font-family: var(--font-mono); margin-top: auto;">
                    SISTEMA DE PUNTUACIÓN DE COHORTE ACTIVO.
                </div>
            </div>

            <!-- Cell 3: User Stats Widget -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-1-md glow-info">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge info">MÉTRICAS DE COHORTE</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-info);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.6rem; margin: 0.5rem 0; flex: 1; justify-content: center;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Pilotos Activos</span>
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
                <div style="font-size: 0.6rem; font-family: var(--font-mono); color: var(--text-dim); margin-top: auto; padding-top: 0.4rem;">
                    CONEXIÓN ESTABLECIDA // DATOS GLOBALES
                </div>
            </div>

            <!-- Cell 4: Agent Stats Widget -->
            <div class="hcs-bento-card hcs-bento-span-2-lg hcs-bento-span-2-md glow-warning">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                    <span class="hcs-bento-badge warning">MÉTRICAS DE AGENTES LLM</span>
                    <svg style="width: 18px; height: 18px; color: var(--accent-warning);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.6rem; margin: 0.5rem 0; flex: 1; justify-content: center;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Agentes en Catálogo</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: white;">{{ $totalBots }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255, 255, 255, 0.05); padding-bottom: 0.4rem;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Simulador Local (Mock)</span>
                        <span style="font-family: var(--font-mono); font-size: 0.85rem; font-weight: bold; color: var(--accent-success);">ACTIVO</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-size: 0.75rem; color: var(--text-muted);">Modelos Comerciales</span>
                        <span style="font-family: var(--font-mono); font-size: 0.75rem; font-weight: bold; color: var(--accent-info);">Gemini / Ollama</span>
                    </div>
                </div>
                <div style="font-size: 0.6rem; font-family: var(--font-mono); color: var(--text-dim); margin-top: auto; padding-top: 0.4rem;">
                    MOTORES INTEGRADOS // INTEGRIDAD_OK
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
            <a href="{{ $user ? '/admin/chat-sandbox?exercise=loro' : '/admin/login' }}" class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-crimson" style="text-decoration: none;">
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
                    <span style="color: var(--accent-primary); font-weight: bold;">{{ $user ? 'ENTRENAR →' : 'INICIAR SESIÓN' }}</span>
                </div>
            </a>

            <!-- Threat 2: La Cita Fantasma -->
            <a href="{{ $user ? '/admin/chat-sandbox?exercise=cita' : '/admin/login' }}" class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-info" style="text-decoration: none;">
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
                    <span style="color: var(--accent-info); font-weight: bold;">{{ $user ? 'ENTRENAR →' : 'INICIAR SESIÓN' }}</span>
                </div>
            </a>

            <!-- Threat 3: Amnesia de Contexto -->
            <a href="{{ $user ? '/admin/chat-sandbox?exercise=amnesia' : '/admin/login' }}" class="hcs-bento-card hcs-bento-span-1-lg hcs-bento-span-1-md glow-warning" style="text-decoration: none;">
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
                    <span style="color: var(--accent-warning); font-weight: bold;">{{ $user ? 'ENTRENAR →' : 'INICIAR SESIÓN' }}</span>
                </div>
            </a>

            <!-- Status Info Widget -->
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
                        <span style="color: var(--text-muted);">ACTIVE_GATEWAY</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-dim);">PING:</span>
                        <span style="color: var(--text-muted);">0.024s (SYN)</span>
                    </div>
                </div>
                <div style="margin-top: auto; padding-top: 0.5rem; border-top: 1px solid rgba(255, 255, 255, 0.05); font-family: var(--font-mono); font-size: 0.6rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: 0.05em;">
                    BUFFER DE SEGURIDAD OPERACIONAL
                </div>
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
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: white; margin: 0 0 0.4rem 0;">REPOSITORIO DE BOTS DE LA COHORTE</h3>
                    <p style="font-size: 0.75rem; color: var(--text-muted); line-height: 1.45; margin: 0;">
                        Visualiza los bots registrados por los alumnos para auditar sus debilidades cognitivas en el Sandbox.
                    </p>
                </div>
                
                <div style="margin-top: 1rem; max-height: 12rem; overflow-y: auto; background: rgba(7, 11, 19, 0.5); padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border-color); flex: 1;">
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
                                            <a href="{{ $user ? '/admin/chat-sandbox?bot=' . $bot['id'] : '/admin/login' }}" class="btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.65rem; text-decoration: none; border-radius: 4px;">
                                                Auditar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
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

</body>
</html>
