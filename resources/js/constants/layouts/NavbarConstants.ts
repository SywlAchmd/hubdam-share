import { TNavLinks } from "@/types/layouts/TNavLinks";

export const navLinksId: TNavLinks = [
  {
    id: "beranda",
    path: "/",
    isOpen: null,
    children: [],
  },
  {
    id: "berkas",
    path: "/berkas",
    isOpen: null,
    children: [],
  },
  {
    id: "divisi",
    path: [
      "/divisi/staf-pers",
      "/divisi/staf-sikomlek",
      "/divisi/staf-pernika",
      "/divisi/staf-konbekharstal",
      "/divisi/staf-benghubdam",
      "/divisi/staf-gudmathub",
      "/divisi/staf-urlog",
      "/divisi/staf-urlat",
      "/divisi/staf-urpam",
      "/divisi/staf-renproggar",
      "/divisi/staf-denhubdam",
    ],
    isOpen: false,
    children: [
      {
        id: "staf pers",
        path: "/divisi/staf-pers",
      },
      {
        id: "staf sikomlek",
        path: "/divisi/staf-sikomlek",
      },
      {
        id: "staf pernika",
        path: "/divisi/staf-pernika",
      },
      {
        id: "staf konbekharstal",
        path: "/divisi/staf-konbekharstal",
      },
      {
        id: "staf benghubdam",
        path: "/divisi/staf-benghubdam",
      },
      {
        id: "staf gudmathub",
        path: "/divisi/staf-gudmathub",
      },
      {
        id: "staf urlog",
        path: "/divisi/staf-urlog",
      },
      {
        id: "staf urlat",
        path: "/divisi/staf-urlat",
      },
      {
        id: "staf urpam",
        path: "/divisi/staf-urpam",
      },
      {
        id: "staf renproggar",
        path: "/divisi/staf-renproggar",
      },
      {
        id: "staf denhubdam",
        path: "/divisi/staf-denhubdam",
      },
    ],
  },
];
