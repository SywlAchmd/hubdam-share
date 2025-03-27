import { TNavLinks } from "@/types/layouts/TNavLinks";

export const navLinksId: TNavLinks = [
  {
    id: "beranda",
    path: "/hubdamshare",
    isOpen: null,
    children: [],
  },
  {
    id: "berkas",
    path: "/hubdamshare/berkas",
    isOpen: null,
    children: [],
  },
  {
    id: "divisi",
    path: [
      "/hubdamshare/divisi/staf-pers",
      "/hubdamshare/divisi/staf-sikomlek",
      "/hubdamshare/divisi/staf-pernika",
      "/hubdamshare/divisi/staf-konbekharstal",
      "/hubdamshare/divisi/staf-benghubdam",
      "/hubdamshare/divisi/staf-gudmathub",
      "/hubdamshare/divisi/staf-urlog",
      "/hubdamshare/divisi/staf-urlat",
      "/hubdamshare/divisi/staf-urpam",
      "/hubdamshare/divisi/staf-renproggar",
      "/hubdamshare/divisi/staf-denhubdam",
    ],
    isOpen: false,
    children: [
      {
        id: "staf pers",
        path: "/hubdamshare/divisi/staf-pers",
      },
      {
        id: "staf sikomlek",
        path: "/hubdamshare/divisi/staf-sikomlek",
      },
      {
        id: "staf pernika",
        path: "/hubdamshare/divisi/staf-pernika",
      },
      {
        id: "staf konbekharstal",
        path: "/hubdamshare/divisi/staf-konbekharstal",
      },
      {
        id: "staf benghubdam",
        path: "/hubdamshare/divisi/staf-benghubdam",
      },
      {
        id: "staf gudmathub",
        path: "/hubdamshare/divisi/staf-gudmathub",
      },
      {
        id: "staf urlog",
        path: "/hubdamshare/divisi/staf-urlog",
      },
      {
        id: "staf urlat",
        path: "/hubdamshare/divisi/staf-urlat",
      },
      {
        id: "staf urpam",
        path: "/hubdamshare/divisi/staf-urpam",
      },
      {
        id: "staf renproggar",
        path: "/hubdamshare/divisi/staf-renproggar",
      },
      {
        id: "staf denhubdam",
        path: "/hubdamshare/divisi/staf-denhubdam",
      },
    ],
  },
];

