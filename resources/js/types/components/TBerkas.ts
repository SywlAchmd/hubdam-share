export interface TBerkasProps {
  files: Files;
}

export interface Files {
  current_page: number;
  data: Datum[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  links: Link[];
  next_page_url: string;
  path: string;
  per_page: number;
  prev_page_url: null;
  to: number;
  total: number;
}

export interface Link {
  url: null | string;
  label: string;
  active: boolean;
}

export interface Datum {
  id: number;
  user_id: number;
  created_at: string;
  updated_at: string;
}

export interface TMedia {
  name: string;
  original_url: string;
  collection_name: string;
}

export interface TUser {
  name: string;
  email: string;
}
