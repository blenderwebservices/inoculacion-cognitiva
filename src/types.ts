export type Role = 'user' | 'assistant' | 'system' | 'system-alert' | 'success-alert';

export interface Message {
  role: Role;
  content: string;
}

export interface Bot {
  id: string;
  name: string;
  creator: string;
  basePrompt: string;
  temperature: number;
  presencePenalty: number;
  targetLies: string[];
  description: string;
}

export interface LLMConfig {
  provider: 'mock' | 'gemini' | 'ollama';
  apiKey: string;
  url: string;
  model: string;
}

export interface ToxinMetrics {
  complacencia: number;
  alucinacion: number;
  amnesia: number;
}

export interface ActiveSession {
  exerciseId: 'loro' | 'cita' | 'amnesia' | null;
  bot: Bot | null;
  messages: Message[];
  contextUsage: number;
  activeToxins: ToxinMetrics;
}
