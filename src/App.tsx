import { useState, useEffect } from 'react';
import type { LLMConfig, Bot } from './types';
import { Dashboard } from './views/Dashboard';
import { ChatSandbox } from './views/ChatSandbox';
import { BotBuilder } from './views/BotBuilder';
import { CrossTest } from './views/CrossTest';
import { Login } from './views/Login';
import { LogOut, ExternalLink, Activity } from 'lucide-react';

interface AuthenticatedUser {
  name: string;
  email: string;
  role: 'admin' | 'user';
}

function App() {
  const [currentView, setCurrentView] = useState<'dashboard' | 'chat' | 'builder' | 'crosstest'>('dashboard');
  const [selectedExercise, setSelectedExercise] = useState<'loro' | 'cita' | 'amnesia' | null>(null);
  const [selectedBot, setSelectedBot] = useState<Bot | null>(null);
  const [currentUser, setCurrentUser] = useState<AuthenticatedUser | null>(null);
  const [isCheckingAuth, setIsCheckingAuth] = useState(true);

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

  // Check auth session on startup
  useEffect(() => {
    const checkAuth = async () => {
      try {
        const response = await fetch('/api/user');
        if (response.ok) {
          const user = await response.json();
          if (user && user.email) {
            setCurrentUser(user);
          }
        }
      } catch (e) {
        console.error('Error verifying auth session:', e);
      } finally {
        setIsCheckingAuth(false);
      }
    };
    checkAuth();
  }, []);

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

  const handleLogout = async () => {
    try {
      await fetch('/api/logout', { method: 'POST' });
      setCurrentUser(null);
      setCurrentView('dashboard');
    } catch (e) {
      console.error('Error logging out:', e);
      setCurrentUser(null);
    }
  };

  if (isCheckingAuth) {
    return (
      <div className="flex flex-col items-center justify-center h-screen font-mono text-sm text-slate-400" style={{ backgroundColor: 'var(--bg-dark)' }}>
        <Activity className="animate-spin text-accent-primary mb-3" size={24} />
        <span>Cargando simulación HCS...</span>
      </div>
    );
  }

  if (!currentUser) {
    return <Login onLoginSuccess={(user) => setCurrentUser(user)} />;
  }

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
        
        <div className="flex items-center gap-4">
          <div className="connection-status">
            <span className={`status-dot ${config.provider === 'mock' ? 'offline' : ''}`} />
            <span className="font-semibold text-slate-300">
              {config.provider === 'mock' && 'Simulador Local (Desconectado)'}
              {config.provider === 'gemini' && `Gemini (${config.model})`}
              {config.provider === 'ollama' && `Ollama (${config.model})`}
            </span>
          </div>

          <div className="user-profile-badge">
            <span>Piloto: <strong className="text-white">{currentUser.name}</strong> ({currentUser.role})</span>
            {currentUser.role === 'admin' && (
              <a 
                href="/admin" 
                target="_blank" 
                rel="noreferrer" 
                className="btn-primary flex items-center gap-0.5 ml-2 py-0.5 px-2 text-[10px] rounded-full no-underline text-white"
                id="hcs-admin-filament-link"
              >
                Dashboard <ExternalLink size={10} />
              </a>
            )}
            <button 
              className="text-slate-400 hover:text-accent-primary ml-2 bg-none border-none cursor-pointer flex items-center gap-0.5"
              onClick={handleLogout}
              title="Cerrar Sesión"
              id="hcs-logout-btn"
            >
              <LogOut size={12} />
            </button>
          </div>
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
