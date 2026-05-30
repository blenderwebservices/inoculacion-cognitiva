import React, { useState } from 'react';
import { ShieldAlert, LogIn, User, Lock } from 'lucide-react';

interface LoginProps {
  onLoginSuccess: (user: { name: string; email: string; role: 'admin' | 'user' }) => void;
}

export const Login: React.FC<LoginProps> = ({ onLoginSuccess }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!email || !password) return;

    setIsLoading(true);
    setError(null);

    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
      });

      if (!response.ok) {
        const data = await response.json();
        throw new Error(data.error || 'Credenciales incorrectas');
      }

      const user = await response.json();
      onLoginSuccess(user);
    } catch (err: any) {
      console.error(err);
      setError(err.message);
    } finally {
      setIsLoading(false);
    }
  };

  const handleQuickLogin = (role: 'admin' | 'user') => {
    setEmail(role === 'admin' ? 'admin@habanero.com' : 'user@habanero.com');
    setPassword('password');
    // We let the state set and trigger login in a brief timeout
    setTimeout(() => {
      const form = document.getElementById('hcs-login-form') as HTMLFormElement;
      form?.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
    }, 50);
  };

  return (
    <div className="flex items-center justify-center min-h-[80vh] px-4" id="hcs-login-view">
      <div className="glass-panel p-8 w-full max-w-md flex flex-col gap-6" style={{ borderTop: '4px solid var(--accent-primary)' }}>
        
        {/* Brand Banner */}
        <div className="flex flex-col items-center gap-2 text-center">
          <div className="w-12 h-12 bg-gradient-to-br from-accent-primary to-accent-secondary rounded-xl flex items-center justify-center font-extrabold text-2xl text-white shadow-lg">
            H
          </div>
          <h1 className="text-xl font-bold text-slate-800 tracking-wider mt-2">HABANERO COGNITIVE SANDBOX</h1>
          <p className="text-xs text-slate-500">Entrenamiento Adversarial de Inoculación</p>
        </div>

        {error && (
          <div className="p-3 rounded bg-red-50 border border-red-200 text-xs text-red-700 leading-normal flex items-start gap-2">
            <ShieldAlert size={14} className="flex-shrink-0 mt-0.5" />
            <span>{error}</span>
          </div>
        )}

        <form onSubmit={handleSubmit} id="hcs-login-form" className="flex flex-col gap-4">
          
          <div className="form-group mb-0">
            <label className="form-label text-xs text-slate-600">Correo Electrónico</label>
            <div className="relative">
              <span className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <User size={16} />
              </span>
              <input
                type="email"
                placeholder="email@habanero.com"
                className="form-input w-full pl-10"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
                id="login-email"
              />
            </div>
          </div>

          <div className="form-group mb-0">
            <label className="form-label text-xs text-slate-600">Contraseña</label>
            <div className="relative">
              <span className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <Lock size={16} />
              </span>
              <input
                type="password"
                placeholder="••••••••"
                className="form-input w-full pl-10"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                id="login-password"
              />
            </div>
          </div>

          <button
            type="submit"
            className="form-submit-btn flex items-center justify-center gap-2 py-2.5 mt-2"
            disabled={isLoading}
            id="login-btn"
          >
            <LogIn size={18} /> {isLoading ? 'Autenticando...' : 'Iniciar Sesión'}
          </button>
        </form>

        {/* Quick Logins */}
        <div className="border-t border-slate-100 pt-4 flex flex-col gap-2">
          <span className="text-[10px] text-slate-500 text-center font-mono uppercase tracking-wider block">Acceso Rápido (Seeded Pilots)</span>
          <div className="flex gap-2">
            <button 
              className="btn-secondary flex-1 py-1.5 text-xs font-semibold text-emerald-700 border-emerald-200 hover:bg-emerald-50"
              onClick={() => handleQuickLogin('user')}
            >
              Piloto (User)
            </button>
            <button 
              className="btn-secondary flex-1 py-1.5 text-xs font-semibold text-rose-700 border-rose-200 hover:bg-rose-50"
              onClick={() => handleQuickLogin('admin')}
            >
              Administrador (Admin)
            </button>
          </div>
        </div>

      </div>
    </div>
  );
};
