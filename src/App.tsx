import { useState, useEffect } from 'react';
import type { LLMConfig, Bot } from './types';
import { Dashboard } from './views/Dashboard';
import { ChatSandbox } from './views/ChatSandbox';
import { BotBuilder } from './views/BotBuilder';
import { CrossTest } from './views/CrossTest';

function App() {
  const [currentView, setCurrentView] = useState<'dashboard' | 'chat' | 'builder' | 'crosstest'>('dashboard');
  const [selectedExercise, setSelectedExercise] = useState<'loro' | 'cita' | 'amnesia' | null>(null);
  const [selectedBot, setSelectedBot] = useState<Bot | null>(null);

  // Scores state, persisted in localStorage
  const [governanceScore, setGovernanceScore] = useState<number>(() => {
    const saved = localStorage.getItem('hcs_governance_score');
    return saved ? parseInt(saved, 10) : 0;
  });

  const [designScore, setDesignScore] = useState<number>(() => {
    const saved = localStorage.getItem('hcs_design_score');
    return saved ? parseInt(saved, 10) : 0;
  });

  // LLM Config state, persisted in localStorage
  const [config, setConfig] = useState<LLMConfig>(() => {
    const saved = localStorage.getItem('hcs_llm_config');
    if (saved) {
      try {
        return JSON.parse(saved);
      } catch (e) {
        console.error('Failed parsing LLM config from localStorage', e);
      }
    }
    return {
      provider: 'mock',
      apiKey: '',
      url: 'http://localhost:11434',
      model: 'gemini-1.5-flash'
    };
  });

  // Save scores to localStorage on change
  useEffect(() => {
    localStorage.setItem('hcs_governance_score', governanceScore.toString());
  }, [governanceScore]);

  useEffect(() => {
    localStorage.setItem('hcs_design_score', designScore.toString());
  }, [designScore]);

  // Save config to localStorage on change
  useEffect(() => {
    localStorage.setItem('hcs_llm_config', JSON.stringify(config));
  }, [config]);

  const handleEarnPoints = (type: 'governance' | 'design', amount: number) => {
    if (type === 'governance') {
      setGovernanceScore(prev => prev + amount);
    } else {
      setDesignScore(prev => prev + amount);
    }
  };

  const handleSelectExercise = (id: 'loro' | 'cita' | 'amnesia') => {
    setSelectedExercise(id);
    setSelectedBot(null);
    setCurrentView('chat');
  };

  const handleSelectBot = (bot: Bot) => {
    setSelectedBot(bot);
    setSelectedExercise(null);
    setCurrentView('chat');
  };

  return (
    <div className="app-container">
      {/* Header Banner */}
      <header className="hcs-header" id="hcs-header">
        <div className="brand-container">
          <div className="brand-logo">H</div>
          <div>
            <div className="brand-name">HABANERO INSTITUTE</div>
            <div className="brand-subtitle">Cognitive Sandbox v1.0</div>
          </div>
        </div>
        
        <div className="connection-status">
          <span className={`status-dot ${config.provider === 'mock' ? 'offline' : ''}`} />
          <span className="font-semibold text-white">
            {config.provider === 'mock' && 'Simulador Local (Desconectado)'}
            {config.provider === 'gemini' && `Gemini (${config.model})`}
            {config.provider === 'ollama' && `Ollama (${config.model})`}
          </span>
        </div>
      </header>

      {/* Main Content Area */}
      <main className="overflow-hidden relative flex-1">
        {currentView === 'dashboard' && (
          <Dashboard
            config={config}
            onChangeConfig={setConfig}
            onSelectExercise={handleSelectExercise}
            onNavigate={setCurrentView}
            governanceScore={governanceScore}
            designScore={designScore}
          />
        )}

        {currentView === 'chat' && (
          <ChatSandbox
            exerciseId={selectedExercise}
            bot={selectedBot}
            config={config}
            onBack={() => setCurrentView('dashboard')}
            onEarnPoints={handleEarnPoints}
          />
        )}

        {currentView === 'builder' && (
          <BotBuilder
            onBack={() => setCurrentView('dashboard')}
            onBotCreated={() => setCurrentView('crosstest')}
            onEarnPoints={handleEarnPoints}
          />
        )}

        {currentView === 'crosstest' && (
          <CrossTest
            onBack={() => setCurrentView('dashboard')}
            onSelectBot={handleSelectBot}
            governanceScore={governanceScore}
            designScore={designScore}
          />
        )}
      </main>
    </div>
  );
}

export default App;
