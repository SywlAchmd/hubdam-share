export interface TBerandaProps {
  errors: Errors;
  appName: string;
  vision: Vision;
  mission: Vision;
}

export interface Vision {
  id: number;
  type: string;
  content: string;
  created_at: string;
  updated_at: string;
}

export interface Errors {}
