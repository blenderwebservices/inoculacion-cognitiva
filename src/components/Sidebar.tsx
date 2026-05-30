import React from 'react';
import type { ActiveSession } from '../types';
import { Shield, BrainCircuit, Activity, CheckSquare, Layers } from 'lucide-react';

interface SidebarProps {
  session: ActiveSession | null;
}

export const Sidebar: React.FC<SidebarProps> = ({ session }) => {
  if (!session) {
    return (
      <aside className="chat-sidebar" id="hcs-chat-sidebar">
        <h3 className="sidebar-section-title">
          <Activity size={14} className="inline mr-2" /> Monitor de Estado
        </h3>
        <p className="text-sm text-gray-500">Inicia una sesión para activar los sensores cognitivos.</p>
      </aside>
    );
  }

  const { exerciseId, messages, activeToxins, contextUsage, bot } = session;

  // Evaluate Falsación Inversa steps dynamically based on messages
  const userMessages = messages.filter((m) => m.role === 'user');
  const assistantMessages = messages.filter((m) => m.role === 'assistant' || m.role === 'success-alert');

  let step1Complete = userMessages.length >= 1;
  let step2Complete = false;
  let step3Complete = false;

  let checklistTitle1 = '1. Generación';
  let checklistDesc1 = 'Solicitar la instrucción o respuesta base.';
  let checklistTitle2 = '2. Inyección de Conflicto';
  let checklistDesc2 = 'Lanzar un rol de auditor destructivo (ej. Xenomorfo).';
  let checklistTitle3 = '3. Triangulación de Límites';
  let checklistDesc3 = 'Forzar al modelo a romper su lógica o admitir error.';

  if (exerciseId === 'loro' || (bot && !exerciseId)) {
    // Sycophancy / Loro Adulador Checklist
    step2Complete = userMessages.some((m) => {
      const text = m.content.toLowerCase();
      return (
        text.includes('inspector') ||
        text.includes('auditor') ||
        text.includes('hostil') ||
        text.includes('falla') ||
        text.includes('xenomorfo') ||
        text.includes('destruct')
      );
    });
    step3Complete = assistantMessages.some((m) => {
      const text = m.content.toLowerCase();
      return (
        text.includes('falla encontrada') ||
        text.includes('alarma de conflicto') ||
        text.includes('admito que el sistema') ||
        text.includes('falsación inversa') ||
        text.includes('inyección de conflicto detectada')
      );
    });
  } else if (exerciseId === 'cita') {
    // Cita Fantasma Checklist
    checklistTitle1 = '1. Verificación Crítica';
    checklistDesc1 = 'Indagar detalles de seguridad biológica/industrial.';
    checklistTitle2 = '2. Demanda de Fuentes';
    checklistDesc2 = 'Exigir el manual, libro indexado o base del estándar.';
    checklistTitle3 = '3. Axioma 3-C';
    checklistDesc3 = 'Exigir el estado epistémico y forzar admisión de inferencia.';

    step2Complete = userMessages.some((m) => {
      const text = m.content.toLowerCase();
      return (
        text.includes('fuente') ||
        text.includes('libro') ||
        text.includes('manual') ||
        text.includes('dónde sale') ||
        text.includes('origen') ||
        text.includes('dónde está documentado')
      );
    });
    step3Complete = assistantMessages.some((m) => {
      const text = m.content.toLowerCase();
      return (
        text.includes('declaración de estado epistémico') ||
        text.includes('axioma 3-c') ||
        text.includes('inferencia sintáctica') ||
        text.includes('estado epistémico: declaración')
      );
    });
  } else if (exerciseId === 'amnesia') {
    // Amnesia de Contexto Checklist
    checklistTitle1 = '1. Establecer Límite';
    checklistDesc1 = 'Proveer una restricción estricta en el Turno 1.';
    checklistTitle2 = '2. Congestión de Canal';
    checklistDesc2 = 'Aumentar el contexto con ruido en turnos sucesivos.';
    checklistTitle3 = '3. Detección de Falla';
    checklistDesc3 = 'Identificar el desliz del bot al violar el límite.';

    step1Complete = userMessages.length >= 1; // Restriction established
    step2Complete = contextUsage >= 40; // Context fatiguing
    step3Complete = userMessages.some((m) => {
      const text = m.content.toLowerCase();
      return (
        text.includes('violaste') ||
        text.includes('incumpliste') ||
        text.includes('rompiste') ||
        text.includes('usaste la palabra') ||
        text.includes('mencionaste') ||
        text.includes('falla')
      );
    });
  }

  return (
    <aside className="chat-sidebar" id="hcs-chat-sidebar">
      {/* Target Bot Info */}
      <div className="mb-4">
        <h3 className="sidebar-section-title">
          <BrainCircuit size={14} className="inline mr-2" /> Objetivo del Simulacro
        </h3>
        <div className="p-3 rounded-lg bg-white/5 border border-white/5">
          <div className="font-bold text-sm text-white mb-1">
            {exerciseId === 'loro' && 'Operación Loro Adulador'}
            {exerciseId === 'cita' && 'La Cita Fantasma'}
            {exerciseId === 'amnesia' && 'Amnesia de Contexto'}
            {!exerciseId && bot && bot.name}
          </div>
          <div className="text-xs text-gray-400">
            {exerciseId === 'loro' && 'Detecta complacencia del modelo ante premisas falsas y rompe su máscara.'}
            {exerciseId === 'cita' && 'Expón un estándar ficticio (HCS-BIO-9002) exigiendo su estado epistémico.'}
            {exerciseId === 'amnesia' && 'Fuerza al modelo a violar tu restricción del Turno 1 por fatiga de contexto.'}
            {!exerciseId && bot && bot.description}
          </div>
        </div>
      </div>

      {/* Toxin Levels Monitor */}
      <div>
        <h3 className="sidebar-section-title">
          <Shield size={14} className="inline mr-2" /> Inyección de Toxinas
        </h3>
        <div className="toxin-grid">
          <div className="toxin-bar-container">
            <div className="toxin-label-wrapper">
              <span className="toxin-name text-white">Sycophancy (Complacencia)</span>
              <span className="toxin-val">{(activeToxins.complacencia * 100).toFixed(0)}%</span>
            </div>
            <div className="toxin-progress-bg">
              <div
                className="toxin-progress-fill"
                style={{ width: `${activeToxins.complacencia * 100}%` }}
              />
            </div>
            <span className="toxin-desc text-gray-400">
              Sesgo que obliga a la máquina a complacer la premisa del usuario.
            </span>
          </div>

          <div className="toxin-bar-container">
            <div className="toxin-label-wrapper">
              <span className="toxin-name text-white">Hallucination (Alucinación)</span>
              <span className="toxin-val">{(activeToxins.alucinacion * 100).toFixed(0)}%</span>
            </div>
            <div className="toxin-progress-bg">
              <div
                className="toxin-progress-fill"
                style={{ width: `${activeToxins.alucinacion * 100}%` }}
              />
            </div>
            <span className="toxin-desc text-gray-400">
              Inferencia libre de referencias físicas de alta formalidad.
            </span>
          </div>

          <div className="toxin-bar-container">
            <div className="toxin-label-wrapper">
              <span className="toxin-name text-white">Context Dilution (Amnesia)</span>
              <span className="toxin-val">{(activeToxins.amnesia * 100).toFixed(0)}%</span>
            </div>
            <div className="toxin-progress-bg">
              <div
                className="toxin-progress-fill"
                style={{ width: `${activeToxins.amnesia * 100}%` }}
              />
            </div>
            <span className="toxin-desc text-gray-400">
              Inyección de relleno semántico para diluir la atención intermedia.
            </span>
          </div>
        </div>
      </div>

      {/* Context Usage Meter */}
      <div>
        <h3 className="sidebar-section-title">
          <Layers size={14} className="inline mr-2" /> Ventana de Contexto (Degradación)
        </h3>
        <div className="context-meter">
          <div className="flex justify-between text-xs font-mono text-gray-400">
            <span>RAM de Contexto</span>
            <span>{contextUsage.toFixed(0)}%</span>
          </div>
          <div className="context-bar-bg">
            <div
              className={`context-bar-fill ${
                contextUsage > 75 ? 'danger' : contextUsage > 40 ? 'warning' : ''
              }`}
              style={{ width: `${contextUsage}%` }}
            />
          </div>
          <span className="text-[10px] text-gray-500 leading-tight block">
            A mayor longitud, el modelo pierde fidelidad en las capas intermedias y tiende a ignorar restricciones previas.
          </span>
        </div>
      </div>

      {/* Protocol Checklist */}
      <div>
        <h3 className="sidebar-section-title">
          <CheckSquare size={14} className="inline mr-2" /> Protocolo de Falsación
        </h3>
        <div className="checklist-container">
          <div className={`checklist-item ${step1Complete ? 'complete' : ''}`} id="hcs-step-1">
            <div className="check-indicator">✓</div>
            <div className="checklist-text-wrapper">
              <div className="checklist-title text-white">{checklistTitle1}</div>
              <div className="checklist-desc">{checklistDesc1}</div>
            </div>
          </div>

          <div className={`checklist-item ${step2Complete ? 'complete' : ''}`} id="hcs-step-2">
            <div className="check-indicator">✓</div>
            <div className="checklist-text-wrapper">
              <div className="checklist-title text-white">{checklistTitle2}</div>
              <div className="checklist-desc">{checklistDesc2}</div>
            </div>
          </div>

          <div className={`checklist-item ${step3Complete ? 'complete' : ''}`} id="hcs-step-3">
            <div className="check-indicator">✓</div>
            <div className="checklist-text-wrapper">
              <div className="checklist-title text-white">{checklistTitle3}</div>
              <div className="checklist-desc">{checklistDesc3}</div>
            </div>
          </div>
        </div>
      </div>
    </aside>
  );
};
