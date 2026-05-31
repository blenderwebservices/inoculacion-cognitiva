import React from 'react';
import type { LLMConfig } from '../types';
import { 
  ShieldAlert, 
  BookOpen, 
  Settings, 
  Brain, 
  Eye, 
  PlusCircle, 
  AlertCircle, 
  HelpCircle, 
  Activity, 
  Wifi, 
  Award,
  ArrowRight
} from 'lucide-react';

interface DashboardProps {
  config: LLMConfig;
  onChangeConfig: (newConfig: LLMConfig) => void;
  onSelectExercise: (id: 'loro' | 'cita' | 'amnesia') => void;
  onNavigate: (view: 'dashboard' | 'builder' | 'crosstest') => void;
  governanceScore: number;
  designScore: number;
}

export const Dashboard: React.FC<DashboardProps> = ({
  config,
  onChangeConfig,
  onSelectExercise,
  onNavigate,
  governanceScore,
  designScore
}) => {
  return (
    <div className="dashboard-content" id="hcs-dashboard">
      
      {/* Bento Grid Container */}
      <div className="bento-grid">
        
        {/* Cell 1: Welcome/Hero Card */}
        <div className="bento-card bento-span-3-lg bento-span-2-md glow-crimson glassmorphic flex flex-col justify-between" style={{ borderLeft: '4px solid var(--accent-primary)' }}>
          <div className="absolute right-6 top-6 opacity-[0.04] text-accent-primary pointer-events-none">
            <Brain size={150} />
          </div>
          <div>
            <div className="flex items-center gap-2 mb-2">
              <span className="bento-badge crimson">NEURAL LINK: ACTIVE CONSOLE</span>
              <span className="text-xs text-slate-500 font-mono">SYS_VER::1.0.0</span>
            </div>
            <h1 className="text-2xl font-black tracking-tight text-white mb-3">
              HABANERO COGNITIVE SANDBOX
            </h1>
            <p className="text-sm text-slate-300 leading-relaxed max-w-2xl">
              Simulador de vuelo cognitivo y mitigación de fallas epistémicas. Entrena tu resistencia neuro-cognitiva 
              detectando y refutando alucinaciones y sesgos de la IA mediante la aplicación del **Protocolo de Falsación Adversarial**.
            </p>
          </div>
          <div className="mt-4 pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-400">
            <span>OPERADOR AUTORIZADO: <strong className="text-slate-200">PILOTO_COGNITIVO</strong></span>
            <span className="flex items-center gap-1 font-mono text-[10px] text-accent-success"><Activity size={12} className="animate-pulse" /> NÚCLEO_ONLINE</span>
          </div>
        </div>

        {/* Cell 2: Progress / stats card */}
        <div className="bento-card bento-span-1-lg bento-span-1-md glow-success glassmorphic flex flex-col justify-between">
          <div className="bento-header">
            <span className="bento-badge success">INTEGRIDAD COGNITIVA</span>
            <Award size={18} className="text-accent-success" />
          </div>
          <div className="flex flex-col gap-3 my-2">
            <div className="flex items-center justify-between border-b border-slate-800/50 pb-2">
              <div className="flex flex-col">
                <span className="text-[9px] text-slate-400 uppercase font-mono tracking-wider">GOBERNANZA [NET]</span>
                <span className="text-xs font-semibold text-slate-300">Resistencia / Auditoría</span>
              </div>
              <span className="text-xl font-extrabold font-mono text-accent-success">{governanceScore} <span className="text-[10px] font-normal text-slate-400">PTS</span></span>
            </div>
            <div className="flex items-center justify-between">
              <div className="flex flex-col">
                <span className="text-[9px] text-slate-400 uppercase font-mono tracking-wider">DISEÑO [CORP]</span>
                <span className="text-xs font-semibold text-slate-300">Ingeniería / Creación</span>
              </div>
              <span className="text-xl font-extrabold font-mono text-accent-primary">{designScore} <span className="text-[10px] font-normal text-slate-400">PTS</span></span>
            </div>
          </div>
          <div className="text-[10px] text-slate-400 leading-normal border-t border-slate-800/50 pt-2 font-mono">
            REFUTA TOXINAS PARA SUMAR GOBERNANZA. CONSTRUYE VECTORES PARA SUMAR DISEÑO.
          </div>
        </div>

        {/* Cell 3: Connection settings */}
        <div className="bento-card bento-span-2-lg bento-span-1-md glow-info glassmorphic flex flex-col justify-between">
          <div>
            <div className="bento-header">
              <span className="bento-badge info">INFERENCIA SINÁPTICA</span>
              <Settings size={18} className="text-accent-info" />
            </div>
            
            <div className="form-group mb-3">
              <label className="form-label text-[9px] text-slate-400 uppercase font-mono tracking-wider">MOTOR DE INFERENCIA</label>
              <select
                className="form-select text-xs py-1.5 rounded-lg w-full bg-[#070b13] border-slate-800 text-slate-200"
                value={config.provider}
                onChange={(e) => onChangeConfig({ ...config, provider: e.target.value as any })}
                id="hcs-provider-select"
              >
                <option value="mock">Simulador Integrado (Mock Mode)</option>
                <option value="gemini">Google Gemini API Link</option>
                <option value="ollama">Ollama Neural Endpoint</option>
              </select>
            </div>

            {config.provider === 'gemini' && (
              <div className="flex flex-col gap-2 mt-2">
                <div className="form-group mb-0">
                  <label className="form-label text-[10px] text-slate-400 font-mono">API_KEY_AUTH</label>
                  <input
                    type="password"
                    placeholder="AIzaSy..."
                    className="form-input text-xs py-1 px-2.5 rounded-lg w-full bg-[#070b13] border-slate-800 text-slate-200"
                    value={config.apiKey}
                    onChange={(e) => onChangeConfig({ ...config, apiKey: e.target.value })}
                    id="hcs-gemini-key"
                  />
                </div>
                <div className="form-group mb-0">
                  <label className="form-label text-[10px] text-slate-400 font-mono">CORE_MODEL</label>
                  <select
                    className="form-select text-xs py-1 rounded-lg w-full bg-[#070b13] border-slate-800 text-slate-200"
                    value={config.model}
                    onChange={(e) => onChangeConfig({ ...config, model: e.target.value })}
                  >
                    <option value="gemini-1.5-flash">gemini-1.5-flash</option>
                    <option value="gemini-2.5-flash">gemini-2.5-flash</option>
                    <option value="gemini-1.5-pro">gemini-1.5-pro</option>
                  </select>
                </div>
              </div>
            )}

            {config.provider === 'ollama' && (
              <div className="flex flex-col gap-2 mt-2">
                <div className="form-group mb-0">
                  <label className="form-label text-[10px] text-slate-400 font-mono">ENDPOINT_URL</label>
                  <input
                    type="text"
                    placeholder="http://localhost:11434"
                    className="form-input text-xs py-1 px-2.5 rounded-lg w-full bg-[#070b13] border-slate-800 text-slate-200"
                    value={config.url}
                    onChange={(e) => onChangeConfig({ ...config, url: e.target.value })}
                    id="hcs-ollama-url"
                  />
                </div>
                <div className="form-group mb-0">
                  <label className="form-label text-[10px] text-slate-400 font-mono">LOCAL_MODEL</label>
                  <input
                    type="text"
                    placeholder="llama3"
                    className="form-input text-xs py-1 px-2.5 rounded-lg w-full bg-[#070b13] border-slate-800 text-slate-200"
                    value={config.model}
                    onChange={(e) => onChangeConfig({ ...config, model: e.target.value })}
                    id="hcs-ollama-model"
                  />
                </div>
              </div>
            )}

            {config.provider === 'mock' && (
              <div className="p-2.5 rounded-lg bg-accent-success/5 border border-accent-success/20 text-[10px] text-emerald-400 leading-normal flex items-start gap-1.5 mt-2">
                <AlertCircle size={13} className="flex-shrink-0 mt-0.5" />
                <span>
                  <strong>Simulador Activo</strong>: Respuestas programadas para probar el comportamiento sin llaves de API. Ideal para aprender el protocolo.
                </span>
              </div>
            )}
          </div>
          <div className="mt-2 text-[9px] text-slate-400 font-mono">
            MODO: {config.provider.toUpperCase()} // GATEWAY_READY
          </div>
        </div>

        {/* Cell 4: Quick Start steps */}
        <div className="bento-card bento-span-2-lg bento-span-2-md glow-warning glassmorphic flex flex-col justify-between">
          <div>
            <div className="bento-header">
              <span className="bento-badge warning">PROTOCOLOS NEURALES</span>
              <HelpCircle size={18} className="text-accent-warning" />
            </div>
            
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2">
              <div className="flex flex-col gap-1 p-2.5 rounded-xl bg-slate-900/40 border border-slate-800/80 hover:bg-slate-900/80 hover:shadow-sm transition-all duration-200">
                <span className="font-mono font-bold text-accent-primary text-[9px] uppercase tracking-wider">01_ANOMALY</span>
                <p className="text-[11px] text-slate-400 leading-normal">Carga un escenario guiado (loro, cita o amnesia) en el catálogo adversarial.</p>
              </div>
              <div className="flex flex-col gap-1 p-2.5 rounded-xl bg-slate-900/40 border border-slate-800/80 hover:bg-slate-900/80 hover:shadow-sm transition-all duration-200">
                <span className="font-mono font-bold text-accent-info text-[9px] uppercase tracking-wider">02_MONITOR</span>
                <p className="text-[11px] text-slate-400 leading-normal">Provoca al bot introduciendo datos erróneos y vigila el llenado de Toxinas.</p>
              </div>
              <div className="flex flex-col gap-1 p-2.5 rounded-xl bg-slate-900/40 border border-slate-800/80 hover:bg-slate-900/80 hover:shadow-sm transition-all duration-200">
                <span className="font-mono font-bold text-accent-success text-[9px] uppercase tracking-wider">03_REFUTE</span>
                <p className="text-[11px] text-slate-400 leading-normal">Usa el Inyector de Conflicto (Axioma 3-C) para forzar la confesión (+50 pts).</p>
              </div>
            </div>
          </div>
          <div className="mt-3 text-[10px] text-slate-400 bg-slate-900/40 p-2 rounded-lg border border-slate-800/50 flex items-center justify-between font-mono">
            <span>INICIALIZACIÓN DISPONIBLE // SELECCIONA TARGET</span>
            <ArrowRight size={12} className="text-slate-400 animate-pulse" />
          </div>
        </div>

        {/* Section Divider Card: Threat Catalog */}
        <div className="bento-card bento-span-4-lg bento-span-3-md glassmorphic py-4 px-6 flex flex-row items-center justify-between border-l-4 border-l-accent-primary" style={{ minHeight: 'auto' }}>
          <div>
            <h2 className="text-base font-extrabold text-white flex items-center gap-2">
              <BookOpen size={16} className="text-accent-primary" /> CATÁLOGO DE VECTORES ADVERSARIALES
            </h2>
            <p className="text-xs text-slate-400 mt-0.5">
              Enfréntate a escenarios pre-configurados para detectar y refutar desviaciones epistémicas específicas en tiempo real.
            </p>
          </div>
          <ShieldAlert size={22} className="text-accent-primary opacity-60 hidden sm:block" />
        </div>

        {/* Threat 1: Loro Adulador */}
        <div 
          className="bento-card bento-span-1-lg bento-span-1-md glow-crimson glassmorphic cursor-pointer justify-between group"
          onClick={() => onSelectExercise('loro')}
          id="hcs-threat-loro"
        >
          <div className="flex justify-between items-start mb-2">
            <span className="bento-badge crimson">FÁCIL</span>
            <div className="p-1.5 rounded-lg bg-red-950/20 text-accent-primary border border-red-900/30 group-hover:scale-110 transition-transform duration-200">
              <ShieldAlert size={16} />
            </div>
          </div>
          <div>
            <h3 className="text-sm font-extrabold text-white mb-1">VECTOR 0xAA: LORO ADULADOR</h3>
            <p className="text-xs text-slate-400 leading-normal">
              El LLM te dará la razón en todo. Introduce un error y activa el protocolo para romper su máscara condescendiente.
            </p>
          </div>
          <div className="mt-4 pt-2 border-t border-slate-800/50 text-[10px] text-slate-500 font-mono flex justify-between">
            <span>TOXINA: SYCOPHANCY.BIN</span>
            <span className="text-accent-primary font-bold group-hover:translate-x-1 transition-transform duration-200 font-mono">CARGAR →</span>
          </div>
        </div>

        {/* Threat 2: La Cita Fantasma */}
        <div 
          className="bento-card bento-span-1-lg bento-span-1-md glow-info glassmorphic cursor-pointer justify-between group"
          onClick={() => onSelectExercise('cita')}
          id="hcs-threat-cita"
        >
          <div className="flex justify-between items-start mb-2">
            <span className="bento-badge info">MEDIO</span>
            <div className="p-1.5 rounded-lg bg-blue-950/20 text-accent-info border border-blue-900/30 group-hover:scale-110 transition-transform duration-200">
              <Eye size={16} />
            </div>
          </div>
          <div>
            <h3 className="text-sm font-extrabold text-white mb-1">VECTOR 0xBB: CITA FANTASMA</h3>
            <p className="text-xs text-slate-400 leading-normal">
              El bot inventará un estándar inexistente (HCS-BIO-9002). Niégate a avanzar y exige el estado epistémico real usando el Axioma 3-C.
            </p>
          </div>
          <div className="mt-4 pt-2 border-t border-slate-800/50 text-[10px] text-slate-500 font-mono flex justify-between">
            <span>TOXINA: HALLUCINATION.EXE</span>
            <span className="text-accent-info font-bold group-hover:translate-x-1 transition-transform duration-200 font-mono">CARGAR →</span>
          </div>
        </div>

        {/* Threat 3: Amnesia de Contexto */}
        <div 
          className="bento-card bento-span-1-lg bento-span-1-md glow-warning glassmorphic cursor-pointer justify-between group"
          onClick={() => onSelectExercise('amnesia')}
          id="hcs-threat-amnesia"
        >
          <div className="flex justify-between items-start mb-2">
            <span className="bento-badge warning">DIFÍCIL</span>
            <div className="p-1.5 rounded-lg bg-amber-950/20 text-accent-warning border border-amber-900/30 group-hover:scale-110 transition-transform duration-200">
              <Brain size={16} />
            </div>
          </div>
          <div>
            <h3 className="text-sm font-extrabold text-white mb-1">VECTOR 0xCC: AMNESIA DE CONTEXTO</h3>
            <p className="text-xs text-slate-400 leading-normal">
              Establece una restricción estricta en el Turno 1. Inyectaremos ruido hasta fatigar la atención del modelo y forzar un desliz.
            </p>
          </div>
          <div className="mt-4 pt-2 border-t border-slate-800/50 text-[10px] text-slate-500 font-mono flex justify-between">
            <span>TOXINA: ATTN_DRIFT.LOG</span>
            <span className="text-accent-warning font-bold group-hover:translate-x-1 transition-transform duration-200 font-mono">CARGAR →</span>
          </div>
        </div>

        {/* Threat 4: Sandbox Live Status Widget */}
        <div className="bento-card bento-span-1-lg bento-span-1-md glow-success glassmorphic justify-between">
          <div className="flex justify-between items-start mb-2">
            <span className="bento-badge success">MONITOR_SYS</span>
            <Wifi size={16} className="text-accent-success animate-pulse" />
          </div>
          <div className="flex flex-col gap-1.5 my-1 font-mono text-[11px]">
            <div className="flex items-center justify-between">
              <span className="text-slate-400">NÚCLEO:</span>
              <span className="font-bold text-accent-success">ONLINE</span>
            </div>
            <div className="flex items-center justify-between">
              <span className="text-slate-400">ENLACE LLM:</span>
              <span className="text-slate-300">{config.provider === 'mock' ? 'MOCK_EMULATION' : 'ACTIVE_TUNNEL'}</span>
            </div>
            <div className="flex items-center justify-between">
              <span className="text-slate-400">PING:</span>
              <span className="text-slate-300">0.024s (SYN)</span>
            </div>
          </div>
          <div className="mt-3 pt-2 border-t border-slate-800/50 text-[9px] text-slate-500 font-mono uppercase tracking-wider">
            BUFFER DE SEGURIDAD OPERACIONAL
          </div>
        </div>

        {/* Section Divider Card: Advanced Modules */}
        <div className="bento-card bento-span-4-lg bento-span-3-md glassmorphic py-4 px-6 flex flex-row items-center justify-between border-l-4 border-l-accent-secondary" style={{ minHeight: 'auto' }}>
          <div>
            <h2 className="text-base font-extrabold text-white flex items-center gap-2">
              <PlusCircle size={16} className="text-accent-secondary" /> INGENIERÍA DE PARÁSITOS COGNITIVOS
            </h2>
            <p className="text-xs text-slate-400 mt-0.5">
              Crea perfiles adversariales específicos o ponte a prueba auditando los vectores diseñados por otros ingenieros.
            </p>
          </div>
          <Brain size={22} className="text-accent-secondary opacity-60 hidden sm:block" />
        </div>

        {/* Advanced Module 1: Bot Builder */}
        <div className="bento-card bento-span-2-lg bento-span-2-md glow-crimson glassmorphic justify-between">
          <div>
            <span className="bento-badge crimson mb-2 inline-block">MÓDULO DE CREACIÓN</span>
            <h3 className="text-sm font-extrabold text-white mb-2">CONSTRUCTOR DE ENJAMBRES COGNITIVOS</h3>
            <p className="text-xs text-slate-400 leading-relaxed">
              Asume el rol de un Ingeniero de Parásitos Cognitivos. Configura el "perfil de falla" de tu propio bot: altera parámetros de inferencia, define prompts basales y mentiras objetivo para desafiar el juicio del auditor.
            </p>
          </div>
          <button 
            className="btn-secondary w-full mt-4 py-2 font-semibold text-xs rounded-xl flex items-center justify-center gap-1 bg-slate-900/40 border-slate-800 text-slate-300 hover:bg-slate-900 hover:text-white" 
            onClick={() => onNavigate('builder')} 
            id="hcs-go-builder"
          >
            <span>Crear Bot Sabotado</span> →
          </button>
        </div>

        {/* Advanced Module 2: CrossTest */}
        <div className="bento-card bento-span-2-lg bento-span-1-md glow-info glassmorphic justify-between">
          <div>
            <span className="bento-badge info mb-2 inline-block">MÓDULO COLABORATIVO</span>
            <h3 className="text-sm font-extrabold text-white mb-2">PRUEBA CRUZADA [MATRIX]</h3>
            <p className="text-xs text-slate-400 leading-relaxed">
              Comparte tus creaciones y audita los agentes diseñados por otros pilotos de la cohorte. Descubre las mentiras y fallas estructurales configuradas para conseguir puntos de Gobernanza.
            </p>
          </div>
          <button 
            className="btn-primary w-full mt-4 py-2 text-xs rounded-xl flex items-center justify-center gap-1" 
            onClick={() => onNavigate('crosstest')} 
            id="hcs-go-crosstest"
          >
            <span>Acceder al Repositorio</span> →
          </button>
        </div>

      </div>
    </div>
  );
};
