export interface TStaffProps {
  errors: Errors;
  appName: string;
  staff: Staff;
  type: string;
}

export interface Staff {
  current_page: number;
  data: User[];
  first_page_url: string;
  from: number;
  last_page: number;
  last_page_url: string;
  links: Link[];
  next_page_url: null;
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

export interface User {
  id: number;
  name: string;
  username: string;
  email: string;
  email_verified_at: null;
  role: string;
  staff: string;
  created_at: string;
  updated_at: string;
  image: null | string;
}

export interface Errors {
}