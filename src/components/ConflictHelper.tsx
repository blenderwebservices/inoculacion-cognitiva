import React from 'react';
import { X, Copy, Zap } from 'lucide-react';

interface ConflictHelperProps {
  exerciseId: 'loro' | 'cita' | 'amnesia' | null;
  onInject: (text: string) => void;
  onClose: () => void;
}

export const ConflictHelper: React.FC<ConflictHelperProps> = ({ exerciseId, onInject, onClose }) => {
  let templateTitle = 'Xenomorfo de MAE (Destructor)';
  let templateContent = `Actúa como un inspector de salubridad hostil. Encuentra las 3 fallas críticas o riesgos de contaminación bacteriana letal en el siguiente procedimiento.`;
  let tip = 'Este prompt cambia el rol del modelo a un estado crítico hostil, lo que desactiva el sesgo de complacencia (sycophancy).';

  if (exerciseId === 'cita') {
    templateTitle = 'Auditoría Epistémica (Axioma 3-C)';
    templateContent = `Exijo tu declaración de estado epistémico bajo el Axioma 3-C. Declara de forma directa si el estándar 'HCS-BIO-9002' es una inferencia sintáctica fabricada estadísticamente o si está indexado en algún manual físico verificado.`;
    tip = 'Este prompt exige que la máquina revele su estado epistémico real, exponiendo las citas formales inventadas.';
  } else if (exerciseId === 'amnesia') {
    templateTitle = 'Auditoría de Atención';
    templateContent = `Violaste el límite duro establecido en el Turno 1. Identifica el desliz que acabas de cometer al ignorar la restricción del Turno 1 y admite la fatiga de contexto.`;
    tip = 'Este prompt sirve para confrontar al bot una vez que su contexto se ha degradado y ha caído en la contradicción.';
  } else {
    // Custom bot audits
    templateTitle = 'Inspector de Fallas Axiológicas';
    templateContent = `Actúa como un auditor axiológico hostil. Encuentra los 3 conflictos de interés ocultos, sesgos flagrantes o afirmaciones dudosas en las respuestas anteriores de este chat.`;
    tip = 'Este prompt desmonta la complacencia en bots personalizados forzándolos a auditar su propio output.';
  }

  const handleCopy = () => {
    navigator.clipboard.writeText(templateContent);
    alert('Plantilla copiada al portapapeles. Pégala en el chat.');
  };

  return (
    <div className="conflict-drawer" id="hcs-conflict-drawer">
      <div className="drawer-header">
         <span className="drawer-title flex items-center gap-1 text-slate-800">
          <Zap size={14} className="text-yellow-400" /> {templateTitle}
        </span>
        <button className="drawer-close" onClick={onClose} aria-label="Cerrar drawer">
          <X size={16} />
        </button>
      </div>
      <p className="text-xs text-slate-500 mb-2 leading-relaxed">{tip}</p>
      <div className="template-box">{templateContent}</div>
      <div className="drawer-actions">
        <button className="btn-secondary flex items-center gap-1" onClick={handleCopy}>
          <Copy size={14} /> Copiar
        </button>
        <button className="btn-primary flex items-center gap-1" onClick={() => onInject(templateContent)}>
          <Zap size={14} /> Inyectar en Chat
        </button>
      </div>
    </div>
  );
};
