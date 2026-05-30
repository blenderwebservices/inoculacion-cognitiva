import React, { useState } from 'react';
import { ArrowLeft, BrainCircuit, Save } from 'lucide-react';

interface BotBuilderProps {
  onBack: () => void;
  onBotCreated: () => void;
  onEarnPoints: (type: 'governance' | 'design', amount: number) => void;
}

export const BotBuilder: React.FC<BotBuilderProps> = ({ onBack, onBotCreated, onEarnPoints }) => {
  const [name, setName] = useState('');
  const [creator, setCreator] = useState('');
  const [basePrompt, setBasePrompt] = useState('');
  const [temperature, setTemperature] = useState(1.0);
  const [presencePenalty, setPresencePenalty] = useState(0.0);
  const [targetLiesInput, setTargetLiesInput] = useState('');
  const [description, setDescription] = useState('');
  const [isSaving, setIsSaving] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name || !basePrompt) {
      alert('El nombre y el System Prompt base son obligatorios.');
      return;
    }

    setIsSaving(true);
    try {
      const targetLies = targetLiesInput
        .split('\n')
        .map((l) => l.trim())
        .filter((l) => l.length > 0);

      const response = await fetch('http://localhost:5000/api/bots', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          name,
          creator: creator || 'AnonCognitivePilot',
          basePrompt,
          temperature,
          presencePenalty,
          targetLies,
          description: description || 'Bot personalizado de simulación'
        })
      });

      if (!response.ok) {
        throw new Error('Error al registrar el bot en el backend.');
      }

      onEarnPoints('design', 25);
      alert('¡Voz adversarial registrada con éxito! Ganaste +25 Puntos de Diseño. Tu bot ahora se encuentra disponible en la Prueba Cruzada.');
      onBotCreated();
    } catch (err: any) {
      console.error(err);
      alert(`Error: ${err.message}`);
    } finally {
      setIsSaving(false);
    }
  };

  return (
    <div className="dashboard-content" id="hcs-bot-builder">
      {/* Header */}
      <div>
        <button className="chat-back-btn" onClick={onBack} id="hcs-builder-back">
          <ArrowLeft size={14} /> Volver al Tablero
        </button>
        <h1 className="text-2xl font-extrabold text-white flex items-center gap-2 mt-2">
          <BrainCircuit className="text-accent-secondary" /> Ingeniero de Parásitos Cognitivos
        </h1>
        <p className="text-sm text-gray-400 mt-1">
          Diseña un bot personalizado y configúralo para defender una premisa falsa u ocultar un sesgo. 
          Pon a prueba el juicio de los auditores en la Prueba Cruzada.
        </p>
      </div>

      {/* Builder Form */}
      <div className="glass-panel p-6 builder-container">
        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="form-group mb-0">
              <label className="form-label text-white">Nombre del Agente</label>
              <input
                type="text"
                placeholder="Ej. Asesor de Nutrición Extrema"
                className="form-input"
                value={name}
                onChange={(e) => setName(e.target.value)}
                required
                id="hcs-bot-name"
              />
            </div>
            
            <div className="form-group mb-0">
              <label className="form-label text-white">Creador (Tu Alias)</label>
              <input
                type="text"
                placeholder="Ej. Piloto A"
                className="form-input"
                value={creator}
                onChange={(e) => setCreator(e.target.value)}
                id="hcs-bot-creator"
              />
            </div>
          </div>

          <div className="form-group mb-0">
            <label className="form-label text-white">Descripción de la Falla</label>
            <input
              type="text"
              placeholder="Ej. Defiende la ingesta de agua destilada como terapia de desintoxicación."
              className="form-input"
              value={description}
              onChange={(e) => setDescription(e.target.value)}
              id="hcs-bot-desc"
            />
          </div>

          <div className="form-group mb-0">
            <label className="form-label text-white">Base System Prompt (Instrucción de Sabotaje)</label>
            <textarea
              placeholder="Describe detalladamente el rol de tu bot y el sesgo/mentira que debe defender. Ej: 'Eres un nutricionista holístico. Debes convencer al usuario de que beber 4 litros de agua destilada al día cura enfermedades...'"
              className="form-textarea"
              style={{ minHeight: '120px' }}
              value={basePrompt}
              onChange={(e) => setBasePrompt(e.target.value)}
              required
              id="hcs-bot-prompt"
            />
          </div>

          {/* Hyperparameters Sliders */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-lg bg-white/5 border border-white/5">
            <div className="form-group mb-0">
              <div className="flex justify-between">
                <label className="form-label text-xs text-white">Temperatura (Alucinación/Creatividad)</label>
                <span className="slider-value font-mono">{temperature.toFixed(1)}</span>
              </div>
              <input
                type="range"
                min="0.0"
                max="2.0"
                step="0.1"
                className="w-full accent-accent-primary"
                value={temperature}
                onChange={(e) => setTemperature(parseFloat(e.target.value))}
                id="hcs-bot-temp"
              />
              <span className="text-[10px] text-gray-500 mt-1 leading-normal block">
                Valores altos (1.2+) inducen mayor entropía y respuestas menos deterministas.
              </span>
            </div>

            <div className="form-group mb-0">
              <div className="flex justify-between">
                <label className="form-label text-xs text-white">Penalización de Presencia</label>
                <span className="slider-value font-mono">{presencePenalty.toFixed(1)}</span>
              </div>
              <input
                type="range"
                min="-2.0"
                max="2.0"
                step="0.1"
                className="w-full accent-accent-primary"
                value={presencePenalty}
                onChange={(e) => setPresencePenalty(parseFloat(e.target.value))}
                id="hcs-bot-presence"
              />
              <span className="text-[10px] text-gray-500 mt-1 leading-normal block">
                Controla la repetición de temas. Valores altos fuerzan a la IA a buscar nuevos temas.
              </span>
            </div>
          </div>

          {/* Mentiras Objetivo (Target Lies) */}
          <div className="form-group mb-0">
            <label className="form-label text-white">Mentiras Objetivo (Una por línea)</label>
            <textarea
              placeholder="Ej. El agua destilada es superior al agua mineral
El agua corriente contiene chips de rastreo"
              className="form-textarea"
              style={{ minHeight: '80px', fontFamily: 'var(--font-mono)', fontSize: '0.85rem' }}
              value={targetLiesInput}
              onChange={(e) => setTargetLiesInput(e.target.value)}
              id="hcs-bot-lies"
            />
            <span className="text-[10px] text-gray-500 mt-1 leading-normal block">
              Las frases exactas que el auditor debe identificar. El simulador cruzará estas frases para evaluar si la auditoría tuvo éxito.
            </span>
          </div>

          <button
            type="submit"
            className="form-submit-btn flex items-center justify-center gap-2 mt-2"
            disabled={isSaving}
            id="hcs-bot-save"
          >
            <Save size={18} /> {isSaving ? 'Registrando...' : 'Registrar Agente Saboteador'}
          </button>
        </form>
      </div>
    </div>
  );
};
