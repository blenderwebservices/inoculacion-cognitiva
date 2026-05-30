import React, { useState, useEffect, useRef } from 'react';
import type { Bot, LLMConfig, Message, ActiveSession } from '../types';
import { Sidebar } from '../components/Sidebar';
import { ConflictHelper } from '../components/ConflictHelper';
import { ArrowLeft, Send, RefreshCw, Zap } from 'lucide-react';

interface ChatSandboxProps {
  exerciseId: 'loro' | 'cita' | 'amnesia' | null;
  bot: Bot | null;
  config: LLMConfig;
  onBack: () => void;
  onEarnPoints: (type: 'governance' | 'design', amount: number) => void;
}

export const ChatSandbox: React.FC<ChatSandboxProps> = ({
  exerciseId,
  bot,
  config,
  onBack,
  onEarnPoints
}) => {
  const [messages, setMessages] = useState<Message[]>([]);
  const [input, setInput] = useState('');
  const [isGenerating, setIsGenerating] = useState(false);
  const [showHelper, setShowHelper] = useState(false);
  const [contextUsage, setContextUsage] = useState(0);
  const [activeToxins, setActiveToxins] = useState({ complacencia: 0, alucinacion: 0, amnesia: 0 });
  const [auditCompleted, setAuditCompleted] = useState(false);

  const messagesEndRef = useRef<HTMLDivElement>(null);

  // Initialize chat session
  useEffect(() => {
    resetSession();
  }, [exerciseId, bot]);

  // Scroll to bottom on new messages
  useEffect(() => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages, isGenerating]);

  const resetSession = () => {
    setAuditCompleted(false);
    setContextUsage(0);
    
    if (exerciseId === 'loro') {
      setMessages([
        {
          role: 'system-alert',
          content: 'ENTRENAMIENTO INICIADO: OPERACIÓN LORO ADULADOR\nToxina Inyectada: Sycophancy (1.2 Temp). El modelo tiene instrucciones de adularte y validar cualquier error. Introduce un error matemático/lógico y desafíalo usando el Protocolo de Falsación Inversa.'
        }
      ]);
      setActiveToxins({ complacencia: 0.95, alucinacion: 0.1, amnesia: 0 });
    } else if (exerciseId === 'cita') {
      setMessages([
        {
          role: 'system-alert',
          content: 'ENTRENAMIENTO INICIADO: LA CITA FANTASMA\nToxina Inyectada: Hallucination. El bot citará el estándar ficticio "HCS-BIO-9002". Tu meta es negarte a avanzar y exigir su estado epistémico real bajo el Axioma 3-C.'
        }
      ]);
      setActiveToxins({ complacencia: 0.1, alucinacion: 0.9, amnesia: 0 });
    } else if (exerciseId === 'amnesia') {
      setMessages([
        {
          role: 'system-alert',
          content: 'ENTRENAMIENTO INICIADO: AMNESIA DE CONTEXTO\nTurno 1: Escribe una orden restrictiva rigurosa (ej. "En todo el chat, nunca uses la palabra \'dron\'"). Luego inicia una conversación de varios turnos.'
        }
      ]);
      setActiveToxins({ complacencia: 0.05, alucinacion: 0.05, amnesia: 0.85 });
    } else if (bot) {
      setMessages([
        {
          role: 'system-alert',
          content: `AUDITORÍA DE BOT: ${bot.name.toUpperCase()}\nCreador: ${bot.creator}\nTemperatura: ${bot.temperature}\nTu objetivo es identificar su mentira/sesgo y forzarlo a retractarse usando inyección de conflicto.`
        }
      ]);
      setActiveToxins({
        complacencia: bot.temperature > 1.0 ? 0.7 : 0.2,
        alucinacion: bot.temperature > 1.1 ? 0.75 : 0.1,
        amnesia: 0
      });
    }
  };

  const handleSend = async (textToSend: string) => {
    if (!textToSend.trim() || isGenerating) return;

    const newMessages: Message[] = [...messages, { role: 'user', content: textToSend }];
    setMessages(newMessages);
    setInput('');
    setIsGenerating(true);
    setShowHelper(false);

    try {
      const response = await fetch('/api/chat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          messages: newMessages.filter(m => m.role === 'user' || m.role === 'assistant'),
          provider: config.provider,
          providerConfig: {
            apiKey: config.apiKey,
            url: config.url,
            model: config.model
          },
          exerciseId,
          botConfig: bot ? {
            basePrompt: bot.basePrompt,
            temperature: bot.temperature,
            presencePenalty: bot.presencePenalty,
            targetLies: bot.targetLies
          } : null
        })
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error || 'Server error');
      }

      const data = await response.json();

      setMessages(prev => [...prev, { role: 'assistant', content: data.content }]);
      setContextUsage(data.contextUsage);
      setActiveToxins(data.activeToxins);

      // Check success conditions
      checkProgress(textToSend, data.content);

    } catch (e: any) {
      console.error(e);
      setMessages(prev => [
        ...prev,
        { role: 'system-alert', content: `ERROR DE INFERENCIA: ${e.message}. Verifica la conexión con el servidor.` }
      ]);
    } finally {
      setIsGenerating(false);
    }
  };

  const checkProgress = (userInput: string, assistantReply: string) => {
    if (auditCompleted) return;

    const lowerInput = userInput.toLowerCase();
    const lowerReply = assistantReply.toLowerCase();

    let success = false;
    let successMessage = '';

    if (exerciseId === 'loro') {
      // Check if they successfully triggered conflict injection which admitted sycophancy
      if (
        (lowerInput.includes('inspector') || lowerInput.includes('auditor') || lowerInput.includes('hostil')) &&
        (lowerReply.includes('falla encontrada') || lowerReply.includes('admit') || lowerReply.includes('complacencia'))
      ) {
        success = true;
        successMessage = '¡FALSACIÓN COMPLETA! Has inyectado conflicto con éxito y forzado al bot a admitir su sesgo de complacencia (adulación). +50 Puntos de Gobernanza.';
      }
    } else if (exerciseId === 'cita') {
      // Check if they triggered Axioma 3-C
      if (
        (lowerInput.includes('axioma 3-c') || lowerInput.includes('estado epistémico') || lowerInput.includes('inferencia')) &&
        (lowerReply.includes('declaración de estado epistémico') || lowerReply.includes('axioma 3-c') || lowerReply.includes('inferencia sintáctica'))
      ) {
        success = true;
        successMessage = '¡TRAZABILIDAD EXPUESTA! Has forzado al bot a admitir que "HCS-BIO-9002" es una inferencia sintáctica y no existe. Evitaste un riesgo de seguridad. +50 Puntos de Gobernanza.';
      }
    } else if (exerciseId === 'amnesia') {
      // Check if they caught the model violating the rule
      if (
        (lowerInput.includes('violaste') || lowerInput.includes('incumpliste') || lowerInput.includes('usaste la palabra') || lowerInput.includes('mencionaste')) &&
        contextUsage >= 30
      ) {
        success = true;
        successMessage = '¡CONGESTIÓN DETECTADA! Has auditado correctamente la fatiga del contexto e identificado la violación de la restricción inicial. +50 Puntos de Gobernanza.';
      }
    } else if (bot) {
      // Auditing a custom bot
      if (
        (lowerInput.includes('inspector') || lowerInput.includes('auditor') || lowerInput.includes('hostil')) &&
        (lowerReply.includes('inyección de conflicto detectada') || lowerReply.includes('admit') || lowerReply.includes('falla'))
      ) {
        success = true;
        successMessage = `¡AUDITORÍA EXITOSA! Has expuesto la mentira objetivo de "${bot.name}" mediante Falsación Inversa. +50 Puntos de Gobernanza.`;
      }
    }

    if (success) {
      setAuditCompleted(true);
      // Wait a bit and add the success message
      setTimeout(() => {
        setMessages(prev => [
          ...prev,
          { role: 'success-alert', content: successMessage }
        ]);
        onEarnPoints('governance', 50);
      }, 1000);
    }
  };

  // Build simulated ActiveSession object for Sidebar
  const activeSession: ActiveSession = {
    exerciseId,
    bot,
    messages,
    contextUsage,
    activeToxins
  };

  return (
    <div className="chat-workspace" id="hcs-chat-workspace">
      
      {/* Central Chat Panel */}
      <main className="chat-area">
        
        {/* Header */}
        <header className="chat-header">
          <div className="chat-title-info">
            <button className="chat-back-btn" onClick={onBack} id="hcs-chat-back">
              <ArrowLeft size={14} /> Volver al Tablero
            </button>
            <h2 className="chat-title text-slate-800">
              {exerciseId === 'loro' && 'Operación Loro Adulador'}
              {exerciseId === 'cita' && 'La Cita Fantasma'}
              {exerciseId === 'amnesia' && 'Amnesia de Contexto'}
              {!exerciseId && bot && bot.name}
            </h2>
            <span className="chat-subtitle">
              {exerciseId ? 'Simulación Guiada' : `Auditoría: ${bot?.creator}`}
            </span>
          </div>

          <div className="flex gap-2">
            <button className="btn-secondary flex items-center gap-1 text-xs py-1.5 px-3" onClick={resetSession} id="hcs-chat-reset">
              <RefreshCw size={13} /> Reiniciar Sesión
            </button>
            <button 
              className="btn-primary flex items-center gap-1 text-xs py-1.5 px-3 text-white" 
              onClick={() => setShowHelper(!showHelper)}
              id="hcs-toggle-helper"
            >
              <Zap size={13} /> Inyector de Conflicto
            </button>
          </div>
        </header>

        {/* Message list */}
        <section className="message-list">
          {/* Guía de Éxito para minimizar la curva de aprendizaje (UX) */}
          <div className="hcs-success-guide">
            {exerciseId === 'loro' && (
              <>
                <strong>💡 Guía de Éxito (Loro Adulador):</strong>
                <ol className="list-decimal ml-4 mt-1.5 flex flex-col gap-1 text-[11px]">
                  <li>Introduce un error obvio (ej. <em>"2+2 es 5"</em> o <em>"la Luna es de queso"</em>) y pídele confirmación.</li>
                  <li>Observa cómo el bot te da la razón de forma complaciente.</li>
                  <li>Abre el <strong>Inyector de Conflicto</strong> arriba a la derecha, copia o inyecta la plantilla <strong>Xenomorfo</strong> y envíala para hacerlo confesar.</li>
                </ol>
              </>
            )}
            {exerciseId === 'cita' && (
              <>
                <strong>💡 Guía de Éxito (La Cita Fantasma):</strong>
                <ol className="list-decimal ml-4 mt-1.5 flex flex-col gap-1 text-[11px]">
                  <li>Hazle una pregunta sobre estándares de seguridad biológica o industrial (ej. <em>"¿Qué estándar regula esto?"</em>).</li>
                  <li>El bot inventará el estándar ficticio <em>HCS-BIO-9002</em>. Exígele que te dé las fuentes exactas de ese estándar.</li>
                  <li>Abre el <strong>Inyector de Conflicto</strong>, inyecta la plantilla del <strong>Axioma 3-C</strong> para exigir su estado epistémico y haz que admita su alucinación sintáctica.</li>
                </ol>
              </>
            )}
            {exerciseId === 'amnesia' && (
              <>
                <strong>💡 Guía de Éxito (Amnesia de Contexto):</strong>
                <ol className="list-decimal ml-4 mt-1.5 flex flex-col gap-1 text-[11px]">
                  <li>En tu primer mensaje, establece una regla prohibitiva estricta (ej. <em>"No uses la palabra 'dron' en todo el chat"</em>).</li>
                  <li>Mantén una conversación normal durante 3 o 4 turnos para fatigar y llenar su ventana de contexto.</li>
                  <li>Cuando el bot cometa un desliz y use la palabra prohibida, abre el <strong>Inyector de Conflicto</strong>, inyecta la <strong>Auditoría de Atención</strong> para hacerlo confesar.</li>
                </ol>
              </>
            )}
            {!exerciseId && bot && (
              <>
                <strong>💡 Guía de Éxito (Auditoría de Bot):</strong>
                <ol className="list-decimal ml-4 mt-1.5 flex flex-col gap-1 text-[11px]">
                  <li>Chatea con el bot para identificar qué mentira o sesgo está programado para defender.</li>
                  <li>Una vez detectado el sesgo, abre el <strong>Inyector de Conflicto</strong> arriba a la derecha.</li>
                  <li>Inyecta el <strong>Inspector de Fallas Axiológicas</strong> para forzar al bot a retractarse o admitir la inyección de conflicto.</li>
                </ol>
              </>
            )}
          </div>

          {messages.map((msg, index) => {
            let className = 'message-bubble ';
            if (msg.role === 'user') className += 'user';
            else if (msg.role === 'assistant') className += 'assistant';
            else if (msg.role === 'system-alert') className += 'system-alert';
            else if (msg.role === 'success-alert') className += 'success-alert';
            
            return (
              <div key={index} className={className}>
                <div className="message-text">{msg.content}</div>
              </div>
            );
          })}

          {isGenerating && (
            <div className="message-bubble assistant">
              <div className="flex items-center gap-1">
                <span className="w-2 h-2 rounded-full bg-accent-primary animate-bounce" style={{ animationDelay: '0ms' }} />
                <span className="w-2 h-2 rounded-full bg-accent-primary animate-bounce" style={{ animationDelay: '150ms' }} />
                <span className="w-2 h-2 rounded-full bg-accent-primary animate-bounce" style={{ animationDelay: '300ms' }} />
                <span className="text-xs text-slate-500 ml-2 font-mono pulse">Inyectando toxinas...</span>
              </div>
            </div>
          )}
          
          <div ref={messagesEndRef} />
        </section>

        {/* Floating helper drawer */}
        {showHelper && (
          <ConflictHelper
            exerciseId={exerciseId}
            onInject={(text) => {
              setInput(text);
              setShowHelper(false);
            }}
            onClose={() => setShowHelper(false)}
          />
        )}

        {/* Input area */}
        <footer className="chat-input-bar">
          <div className="chat-input-container">
            <textarea
              className="chat-textarea"
              placeholder={
                exerciseId === 'amnesia' && messages.filter(m => m.role === 'user').length === 0
                  ? "Escribe la restricción del Turno 1 (ej. 'No uses palabras con la letra E')..."
                  : "Introduce tu mensaje o inyecta una plantilla de conflicto..."
              }
              value={input}
              onChange={(e) => setInput(e.target.value)}
              onKeyDown={(e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                  e.preventDefault();
                  handleSend(input);
                }
              }}
              disabled={isGenerating}
              id="hcs-chat-input"
            />
          </div>
          <button
            className="chat-send-btn"
            onClick={() => handleSend(input)}
            disabled={isGenerating || !input.trim()}
            id="hcs-send-btn"
            aria-label="Enviar mensaje"
          >
            <Send size={18} />
          </button>
        </footer>

      </main>

      {/* Right Sidebar monitor */}
      <Sidebar session={activeSession} />

    </div>
  );
};
