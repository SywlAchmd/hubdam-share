import { Config } from "ziggy-js";

export interface User {
  id?: number;
  name?: string;
  username?: string;
  email?: string;
  staff?: string;
  image?: string | File | null;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  baseUrl: string;
  appName: string;
  auth: {
    user: User;
  };
  flash: {
    success?: string;
    error?: string;
  };
  ziggy: Config & { location: string };
};
