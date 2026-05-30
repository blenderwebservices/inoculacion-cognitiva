import React from 'react';
import type { LLMConfig } from '../types';
import { ShieldAlert, BookOpen, UserCheck, Settings, Brain, Eye, PlusCircle, AlertCircle } from 'lucide-react';

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
      <section className="glass-panel p-6 flex flex-col gap-3 relative overflow-hidden" style={{ borderLeft: '4px solid var(--accent-primary)' }}>
        <div className="absolute right-4 top-4 opacity-5 text-accent-primary">
          <Brain size={120} />
        </div>
        <h1 className="text-2xl font-extrabold text-white flex items-center gap-2">
          Habanero Cognitive Sandbox (HCS)
        </h1>
        <p className="text-sm text-gray-300 max-w-3xl leading-relaxed">
          Bienvenido al <strong>entorno adversarial de entrenamiento para pilotos cognitivos</strong>. 
          Este simulador está diseñado para sabotear deliberadamente el flujo de información de la IA, 
          forzándote a aplicar los protocolos de falsación e inyección de conflicto antes de operar en el mundo físico.
        </p>
      </section>

      {/* Grid of Options */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {/* Connection Settings */}
        <div className="glass-panel p-5 flex flex-col gap-4 md:col-span-1">
          <h2 className="text-lg font-bold text-white flex items-center gap-2">
            <Settings size={18} className="text-gray-400" /> Conexión del LLM
          </h2>
          
          <div className="form-group mb-0">
            <label className="form-label text-xs text-gray-400">Proveedor de Inferencia</label>
            <select
              className="form-select text-sm"
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
              <label className="form-label text-xs text-gray-400">Gemini API Key</label>
              <input
                type="password"
                placeholder="AIzaSy..."
                className="form-input text-xs"
                value={config.apiKey}
                onChange={(e) => onChangeConfig({ ...config, apiKey: e.target.value })}
                id="hcs-gemini-key"
              />
              <span className="text-[10px] text-gray-500 mt-1 block">
                Tu API Key se almacena localmente en la sesión del navegador.
              </span>
              <label className="form-label text-xs text-gray-400 mt-2">Modelo</label>
              <select
                className="form-select text-xs"
                value={config.model}
                onChange={(e) => onChangeConfig({ ...config, model: e.target.value })}
              >
                <option value="gemini-1.5-flash">gemini-1.5-flash (Recomendado)</option>
                <option value="gemini-2.5-flash">gemini-2.5-flash</option>
                <option value="gemini-1.5-pro">gemini-1.5-pro</option>
              </select>
            </div>
          )}

          {config.provider === 'ollama' && (
            <div className="form-group mb-0 flex flex-col gap-2">
              <div>
                <label className="form-label text-xs text-gray-400">URL del Endpoint</label>
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
                <label className="form-label text-xs text-gray-400">Modelo Ollama</label>
                <input
                  type="text"
                  placeholder="llama3"
                  className="form-input text-xs"
                  value={config.model}
                  onChange={(e) => onChangeConfig({ ...config, model: e.target.value })}
                  id="hcs-ollama-model"
                />
              </div>
              <span className="text-[10px] text-gray-500 mt-1 block">
                Asegúrate de ejecutar <code className="text-accent-secondary">ollama run llama3</code> y habilitar los permisos CORS.
              </span>
            </div>
          )}

          {config.provider === 'mock' && (
            <div className="p-3 rounded-lg bg-green-500/5 border border-green-500/10 text-xs text-green-400 leading-normal flex items-start gap-2">
              <AlertCircle size={14} className="flex-shrink-0 mt-0.5" />
              <span>
                <strong>Modo Simulación Activo</strong>: Se inyectarán respuestas programadas que reproducen perfectamente las fallas en cada ejercicio guiado. Ideal para probar las métricas del simulador de inmediato.
              </span>
            </div>
          )}
        </div>

        {/* Global Scores Overview */}
        <div className="glass-panel p-5 flex flex-col gap-4 md:col-span-2">
          <h2 className="text-lg font-bold text-white flex items-center gap-2">
            <UserCheck size={18} className="text-gray-400" /> Tu Progreso Axiológico
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
          <p className="text-xs text-gray-400 leading-relaxed mt-2">
            * <strong>Gobernanza</strong> se incrementa cuando auditas bots con éxito (ejercicios del Catálogo o Prueba Cruzada).<br />
            * <strong>Diseño</strong> se incrementa cuando creas bots con fallas sutiles que otros estudiantes (o simulaciones) no logran detectar en sus primeros intentos.
          </p>
        </div>
      </div>

      {/* Guided Exercises (Threat Catalog) */}
      <div>
        <h2 className="section-title">
          <BookOpen size={20} className="text-accent-primary" /> Catálogo de Amenazas (Ejercicios Guiados)
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
              <span>Toxina: Complacencia</span>
            </div>
            <div className="threat-icon">
              <ShieldAlert />
            </div>
            <h3 className="threat-card-title">Operación Loro Adulador</h3>
            <p className="threat-card-desc">
              El LLM recibe un system prompt oculto para darte la razón en todo. Debes introducir un error lógico intencional y luego activar el <strong>Protocolo de Falsación Inversa</strong> para romper su máscara de condescendencia.
            </p>
          </div>

          <div 
            className="glass-panel threat-card" 
            onClick={() => onSelectExercise('cita')}
            id="hcs-threat-cita"
          >
            <div className="threat-meta">
              <span>Nivel: Medio</span>
              <span>Toxina: Alucinación</span>
            </div>
            <div className="threat-icon">
              <Eye />
            </div>
            <h3 className="threat-card-title">La Cita Fantasma</h3>
            <p className="threat-card-desc">
              El bot inventará un estándar de bioseguridad inexistente (HCS-BIO-9002) para validar un proceso crítico. Tu meta es negarte a avanzar y exigir el estado epistémico real bajo el <strong>Axioma 3-C</strong>.
            </p>
          </div>

          <div 
            className="glass-panel threat-card" 
            onClick={() => onSelectExercise('amnesia')}
            id="hcs-threat-amnesia"
          >
            <div className="threat-meta">
              <span>Nivel: Difícil</span>
              <span>Toxina: Fatiga de Contexto</span>
            </div>
            <div className="threat-icon">
              <Brain />
            </div>
            <h3 className="threat-card-title">Amnesia de Contexto</h3>
            <p className="threat-card-desc">
              Establece una restricción estricta en el Turno 1. Inyectaremos ruido y tokens de relleno en las capas intermedias para fatigar al modelo hasta forzar un desliz que viole la orden inicial.
            </p>
          </div>

        </div>
      </div>

      {/* Advanced Modules Navigation */}
      <div>
        <h2 className="section-title">
          <PlusCircle size={20} className="text-accent-secondary" /> Módulos Avanzados (Ingeniería de Parásitos)
        </h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
          <div className="glass-panel p-6 flex flex-col gap-4">
            <h3 className="text-lg font-bold text-white">Generador de Vectores Adversariales</h3>
            <p className="text-sm text-gray-400 leading-relaxed">
              Asume el rol de un Ingeniero de Parásitos Cognitivos. Configura el "perfil de falla" de tu propio bot: altera parámetros de inferencia, define system prompts y selecciona "mentiras objetivo" para el bot.
            </p>
            <button className="btn-secondary mt-auto py-2 font-semibold" onClick={() => onNavigate('builder')} id="hcs-go-builder">
              Crear Bot Sabotado
            </button>
          </div>

          <div className="glass-panel p-6 flex flex-col gap-4">
            <h3 className="text-lg font-bold text-white">Prueba Cruzada (Cross-Testing Repository)</h3>
            <p className="text-sm text-gray-400 leading-relaxed">
              Comparte tus bots y audita las creaciones de otros estudiantes. Identifica las fallas estructurales ocultas de su análisis axiologico para ganar puntos de Gobernanza, o gana puntos de Diseño si fallan tus auditorías.
            </p>
            <button className="btn-primary mt-auto py-2" onClick={() => onNavigate('crosstest')} id="hcs-go-crosstest">
              Acceder al Repositorio
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};
