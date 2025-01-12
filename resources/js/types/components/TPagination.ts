export type PaginationLink = {
  url: string | null;
  active: boolean;
  label: string;
};

export type PaginationProps = {
  links: PaginationLink[];
};
