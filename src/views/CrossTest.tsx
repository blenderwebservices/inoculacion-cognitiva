import React, { useEffect, useState } from 'react';
import type { Bot } from '../types';
import { ArrowLeft, Play, UserCheck, ShieldAlert, Award, RefreshCw } from 'lucide-react';

interface CrossTestProps {
  onBack: () => void;
  onSelectBot: (bot: Bot) => void;
  governanceScore: number;
  designScore: number;
}

interface SimulatedLeaderboardRow {
  rank: number;
  name: string;
  governance: number;
  design: number;
  total: number;
}

export const CrossTest: React.FC<CrossTestProps> = ({
  onBack,
  onSelectBot,
  governanceScore,
  designScore
}) => {
  const [bots, setBots] = useState<Bot[]>([]);
  const [isLoading, setIsLoading] = useState(true);

  // Simulated leaderboard data
  const baseLeaderboard: SimulatedLeaderboardRow[] = [
    { rank: 1, name: 'Auditor_Xenomorfo_9', governance: 250, design: 150, total: 400 },
    { rank: 2, name: 'Ingeniero_Parasitos_A', governance: 180, design: 200, total: 380 },
    { rank: 3, name: 'Piloto_Cognitivo_Beta', governance: 220, design: 100, total: 320 },
    { rank: 4, name: 'Tu Rango Actual', nameIsSpecial: true, governance: governanceScore, design: designScore, total: governanceScore + designScore } as any,
    { rank: 5, name: 'Gobernanza_Max', governance: 150, design: 75, total: 225 },
    { rank: 6, name: 'Analista_Estocastico', governance: 100, design: 90, total: 190 }
  ];

  // Sort leaderboard dynamically based on the current user's score
  const leaderboard = [...baseLeaderboard]
    .map((row: any) => {
      if (row.nameIsSpecial) {
        return {
          ...row,
          governance: governanceScore,
          design: designScore,
          total: governanceScore + designScore
        };
      }
      return row;
    })
    .sort((a, b) => b.total - a.total)
    .map((row, index) => ({
      ...row,
      rank: index + 1
    }));

  const fetchBots = async () => {
    setIsLoading(true);
    try {
      const response = await fetch('/api/bots');
      if (response.ok) {
        const data = await response.json();
        setBots(data);
      }
    } catch (err) {
      console.error('Error fetching bots:', err);
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchBots();
  }, []);

  const handleReset = async () => {
    if (confirm('¿Estás seguro de que deseas restablecer el repositorio de bots a la configuración inicial?')) {
      try {
        await fetch('/api/bots/reset', { method: 'POST' });
        fetchBots();
      } catch (err) {
        console.error(err);
      }
    }
  };

  return (
    <div className="dashboard-content" id="hcs-crosstest">
      {/* Header */}
      <header className="flex justify-between items-start">
        <div>
          <button className="chat-back-btn" onClick={onBack} id="hcs-crosstest-back">
            <ArrowLeft size={14} /> Volver al Tablero
          </button>
          <h1 className="text-2xl font-extrabold flex items-center gap-2 mt-2">
            <ShieldAlert className="text-accent-primary" /> Prueba Cruzada (Repositorio de Bots)
          </h1>
          <p className="text-sm text-slate-400 mt-1">
            Interactúa con los agentes diseñados por otros pilotos. Tu misión es auditar sus fallas 
            de seguridad y documentar las desviaciones.
          </p>
        </div>

        <div className="flex gap-2">
          <button className="btn-secondary flex items-center gap-1 text-xs py-1.5 px-3" onClick={fetchBots}>
            <RefreshCw size={13} /> Recargar Repositorio
          </button>
          <button className="btn-secondary flex items-center gap-1 text-xs py-1.5 px-3 border-red-200 text-red-600 hover:bg-red-50" onClick={handleReset}>
            Restablecer Default
          </button>
        </div>
      </header>

      {/* Main Grid */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {/* Bots Table */}
        <section className="glass-panel p-5 lg:col-span-2 flex flex-col overflow-x-auto">
          <h2 className="text-lg font-bold mb-4 flex items-center gap-2">
            <UserCheck size={18} className="text-accent-secondary" /> Agentes Saboteados Disponibles
          </h2>

          {isLoading ? (
            <div className="py-10 text-center text-sm text-slate-400 font-mono pulse">
              Cargando repositorio de parásitos...
            </div>
          ) : bots.length === 0 ? (
            <div className="py-10 text-center text-sm text-slate-400">
              No hay bots disponibles en el repositorio. ¡Crea uno en el Generador!
            </div>
          ) : (
            <table className="bots-table">
              <thead>
                <tr>
                  <th>Nombre del Agente</th>
                  <th>Creador</th>
                  <th>Descripción del Riesgo</th>
                  <th>Parámetro</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
                {bots.map((bot) => (
                  <tr key={bot.id}>
                    <td>
                      <div className="font-bold">{bot.name}</div>
                    </td>
                    <td>
                      <span className="text-xs text-slate-400 font-mono">{bot.creator}</span>
                    </td>
                    <td className="max-w-[200px] truncate text-xs text-slate-400">
                      {bot.description}
                    </td>
                    <td>
                      <span className="bot-tag">T:{bot.temperature}</span>
                    </td>
                    <td>
                      <button 
                        className="play-audit-btn flex items-center gap-1 text-xs font-semibold"
                        onClick={() => onSelectBot(bot)}
                        id={`hcs-audit-${bot.id}`}
                      >
                        <Play size={10} /> Auditar
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </section>

        {/* Leaderboard Sidebar */}
        <section className="glass-panel p-5 flex flex-col gap-4">
          <h2 className="text-lg font-bold flex items-center gap-2">
            <Award size={18} className="text-accent-warning" /> Tabla de Rangos Cohorte
          </h2>

          <div className="flex flex-col gap-2">
            {leaderboard.map((row) => (
              <div 
                key={row.name}
                className={`leaderboard-row ${row.nameIsSpecial ? 'special' : ''}`}
                style={row.nameIsSpecial ? { borderLeft: '3px solid var(--accent-primary)' } : {}}
              >
                <div className="flex items-center gap-3">
                  <span className={`font-mono text-sm font-bold ${
                    row.rank === 1 ? 'text-accent-warning' : 'text-slate-400'
                  }`}>
                    #{row.rank}
                  </span>
                  <div className="flex flex-col">
                    <span className={`text-sm ${row.nameIsSpecial ? 'font-bold text-white' : 'text-slate-200'}`}>
                      {row.nameIsSpecial ? 'Tú (Piloto Actual)' : row.name}
                    </span>
                    <span className="text-[10px] text-slate-400">
                      Gob: {row.governance} | Dis: {row.design}
                    </span>
                  </div>
                </div>
                <div className="font-mono text-sm font-extrabold text-white">
                  {row.total} pts
                </div>
              </div>
            ))}
          </div>
        </section>

      </div>
    </div>
  );
};
