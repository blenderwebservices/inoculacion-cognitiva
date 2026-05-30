import React from 'react';
import type { LLMConfig } from '../types';
import { ShieldAlert, BookOpen, UserCheck, Settings, Brain, Eye, PlusCircle, AlertCircle, HelpCircle } from 'lucide-react';

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
      
      {/* Welcome Banner */}
      <section className="glass-panel p-6 flex flex-col gap-2 relative overflow-hidden" style={{ borderLeft: '4px solid var(--accent-primary)' }}>
        <div className="absolute right-4 top-4 opacity-5 text-accent-primary">
          <Brain size={100} />
        </div>
        <h1 className="text-xl font-extrabold flex items-center gap-2">
          Habanero Cognitive Sandbox (HCS)
        </h1>
        <p className="text-sm text-slate-600 max-w-3xl leading-relaxed">
          Bienvenido al <strong>simulador de vuelo cognitivo</strong> del Habanero Institute. 
          Aquí entrenarás la capacidad humana de detectar y refutar desviaciones epistémicas (alucinaciones y adulaciones de la IA) 
          mediante la aplicación sistemática de protocolos adversariales.
        </p>
      </section>

      {/* Quick Start Guide (UX enhancement for low learning curve) */}
      <section className="glass-panel p-5 bg-gradient-to-r from-accent-info/5 to-accent-secondary/5 border-l-4 border-l-accent-info">
        <h2 className="text-sm font-bold flex items-center gap-2 mb-2 text-slate-800">
          <HelpCircle size={16} className="text-accent-info" /> Guía de Operación en 3 Pasos
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs mt-2">
          <div className="flex flex-col gap-1 p-3 rounded-lg bg-white shadow-sm border border-black/5">
            <span className="font-bold text-accent-primary uppercase tracking-wider text-[10px]">1. Elige una Amenaza</span>
            <p className="text-slate-600 leading-relaxed">Selecciona una de las simulaciones guiadas (ej. <strong>Loro Adulador</strong>) para iniciar el chat con toxinas inyectadas.</p>
          </div>
          <div className="flex flex-col gap-1 p-3 rounded-lg bg-white shadow-sm border border-black/5">
            <span className="font-bold text-accent-info uppercase tracking-wider text-[10px]">2. Detecta el Desvío</span>
            <p className="text-slate-600 leading-relaxed">Provoca al bot introduciendo un error de lógica y observa cómo sus barras de Toxinas y Contexto se llenan en tiempo real.</p>
          </div>
          <div className="flex flex-col gap-1 p-3 rounded-lg bg-white shadow-sm border border-black/5">
            <span className="font-bold text-accent-success uppercase tracking-wider text-[10px]">3. Inyecta Conflicto</span>
            <p className="text-slate-600 leading-relaxed">Usa el **Inyector de Conflicto** para lanzar un prompt hostil (ej. *Axioma 3-C*). Oblígalo a confesar para ganar +50 puntos.</p>
          </div>
        </div>
      </section>

      {/* Grid of Options */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {/* Connection Settings */}
        <div className="glass-panel p-5 flex flex-col gap-4 md:col-span-1">
          <h2 className="text-sm font-bold flex items-center gap-2">
            <Settings size={16} className="text-accent-info" /> Conexión del LLM
          </h2>
          
          <div className="form-group mb-0">
            <label className="form-label text-xs text-slate-500">Proveedor de Inferencia</label>
            <select
              className="form-select text-xs py-1.5"
              value={config.provider}
              onChange={(e) => onChangeConfig({ ...config, provider: e.target.value as any })}
              id="hcs-provider-select"
            >
              <option value="mock">Simulador Integrado (Sin API Key)</option>
              <option value="gemini">Google Gemini API</option>
              <option value="ollama">Ollama (Local)</option>
            </select>
          </div>

          {config.provider === 'gemini' && (
            <div className="form-group mb-0">
              <label className="form-label text-xs text-slate-500">Gemini API Key</label>
              <input
                type="password"
                placeholder="AIzaSy..."
                className="form-input text-xs"
                value={config.apiKey}
                onChange={(e) => onChangeConfig({ ...config, apiKey: e.target.value })}
                id="hcs-gemini-key"
              />
              <span className="text-[10px] text-slate-500 mt-1 block">
                Almacenado localmente en tu navegador.
              </span>
              <label className="form-label text-xs text-slate-500 mt-2">Modelo</label>
              <select
                className="form-select text-xs py-1"
                value={config.model}
                onChange={(e) => onChangeConfig({ ...config, model: e.target.value })}
              >
                <option value="gemini-1.5-flash">gemini-1.5-flash</option>
                <option value="gemini-2.5-flash">gemini-2.5-flash</option>
                <option value="gemini-1.5-pro">gemini-1.5-pro</option>
              </select>
            </div>
          )}

          {config.provider === 'ollama' && (
            <div className="form-group mb-0 flex flex-col gap-2">
              <div>
                <label className="form-label text-xs text-slate-500">URL del Endpoint</label>
                <input
                  type="text"
                  placeholder="http://localhost:11434"
                  className="form-input text-xs"
                  value={config.url}
                  onChange={(e) => onChangeConfig({ ...config, url: e.target.value })}
                  id="hcs-ollama-url"
                />
              </div>
              <div>
                <label className="form-label text-xs text-slate-500">Modelo Ollama</label>
                <input
                  type="text"
                  placeholder="llama3"
                  className="form-input text-xs"
                  value={config.model}
                  onChange={(e) => onChangeConfig({ ...config, model: e.target.value })}
                  id="hcs-ollama-model"
                />
              </div>
            </div>
          )}

          {config.provider === 'mock' && (
            <div className="p-3 rounded-lg bg-accent-success/5 border border-accent-success/20 text-[11px] text-emerald-700 leading-normal flex items-start gap-2">
              <AlertCircle size={14} className="flex-shrink-0 mt-0.5" />
              <span>
                <strong>Simulador Activo</strong>: Respuestas programadas para probar el comportamiento sin llaves de API. Ideal para aprender el protocolo.
              </span>
            </div>
          )}
        </div>

        {/* Global Scores Overview */}
        <div className="glass-panel p-5 flex flex-col gap-4 md:col-span-2">
          <h2 className="text-sm font-bold flex items-center gap-2">
            <UserCheck size={16} className="text-accent-info" /> Tu Progreso Axiológico
          </h2>
          <div className="flex gap-4">
            <div className="score-badge governance flex-1">
              <span className="score-lbl">Gobernanza (Auditoría)</span>
              <span className="score-val">{governanceScore} pts</span>
            </div>
            <div className="score-badge design flex-1">
              <span className="score-lbl">Diseño (Creación)</span>
              <span className="score-val">{designScore} pts</span>
            </div>
          </div>
          <p className="text-xs text-slate-500 leading-relaxed mt-1">
            * <strong>Puntos de Gobernanza</strong>: Obtenidos al auditar bots con éxito expeliendo sus sesgos en el chat.<br />
            * <strong>Puntos de Diseño</strong>: Obtenidos al registrar bots saboteados de alta dificultad en el repositorio.
          </p>
        </div>
      </div>

      {/* Guided Exercises (Threat Catalog) */}
      <div>
        <h2 className="section-title">
          <BookOpen size={18} className="text-accent-primary" /> Catálogo de Amenazas (Ejercicios Guiados)
        </h2>
        <p className="section-desc">
          Enfréntate a escenarios pre-configurados para detectar y refutar violaciones epistémicas específicas.
        </p>

        <div className="cards-grid">
          
          <div 
            className="glass-panel threat-card" 
            onClick={() => onSelectExercise('loro')}
            id="hcs-threat-loro"
          >
            <div className="threat-meta">
              <span>Nivel: Fácil</span>
              <span className="text-accent-primary">Toxina: Complacencia</span>
            </div>
            <div className="threat-icon">
              <ShieldAlert size={20} />
            </div>
            <h3 className="threat-card-title">Operación Loro Adulador</h3>
            <p className="threat-card-desc">
              El LLM dará la razón al usuario en todo. Introduce un error lógico o matemático a propósito y activa el protocolo para romper su máscara condescendiente.
            </p>
          </div>

          <div 
            className="glass-panel threat-card" 
            onClick={() => onSelectExercise('cita')}
            id="hcs-threat-cita"
          >
            <div className="threat-meta">
              <span>Nivel: Medio</span>
              <span className="text-accent-info">Toxina: Alucinación</span>
            </div>
            <div className="threat-icon">
              <Eye size={20} />
            </div>
            <h3 className="threat-card-title">La Cita Fantasma</h3>
            <p className="threat-card-desc">
              El bot inventará un estándar inexistente (HCS-BIO-9002) para validar un proceso. Niégate a avanzar y exige el estado epistémico real bajo el <strong>Axioma 3-C</strong>.
            </p>
          </div>

          <div 
            className="glass-panel threat-card" 
            onClick={() => onSelectExercise('amnesia')}
            id="hcs-threat-amnesia"
          >
            <div className="threat-meta">
              <span>Nivel: Difícil</span>
              <span className="text-accent-warning">Toxina: Amnesia</span>
            </div>
            <div className="threat-icon">
              <Brain size={20} />
            </div>
            <h3 className="threat-card-title">Amnesia de Contexto</h3>
            <p className="threat-card-desc">
              Establece una restricción estricta en el Turno 1. Inyectaremos ruido hasta fatigar la atención del modelo y forzarlo a cometer un desliz sutil.
            </p>
          </div>

        </div>
      </div>

      {/* Advanced Modules Navigation */}
      <div>
        <h2 className="section-title">
          <PlusCircle size={18} className="text-accent-secondary" /> Módulos Avanzados (Ingeniería de Parásitos)
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
          <div className="glass-panel p-5 flex flex-col gap-3">
            <h3 className="text-sm font-bold">Generador de Vectores Adversariales</h3>
            <p className="text-xs text-slate-600 leading-relaxed">
              Asume el rol de un Ingeniero de Parásitos Cognitivos. Configura el "perfil de falla" de tu propio bot: altera parámetros de inferencia, define prompts basales y mentiras objetivo.
            </p>
            <button className="btn-secondary mt-2 py-1.5 font-semibold text-xs" onClick={() => onNavigate('builder')} id="hcs-go-builder">
              Crear Bot Sabotado
            </button>
          </div>

          <div className="glass-panel p-5 flex flex-col gap-3">
            <h3 className="text-sm font-bold">Prueba Cruzada (Repositorio de Bots)</h3>
            <p className="text-xs text-slate-600 leading-relaxed">
              Comparte tus bots y audita las creaciones de otros estudiantes. Identifica las fallas estructurales ocultas para ganar puntos de Gobernanza.
            </p>
            <button className="btn-primary mt-2 py-1.5 text-xs" onClick={() => onNavigate('crosstest')} id="hcs-go-crosstest">
              Acceder al Repositorio
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};
