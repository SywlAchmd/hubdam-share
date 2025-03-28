import { TNavLinks } from "@/types/layouts/TNavLinks";
import { getPath } from "@/utils/pathHelper";

export const navLinksId: TNavLinks = [
  {
    id: "beranda",
    path: getPath("/"),
    isOpen: null,
    children: [],
  },
  {
    id: "berkas",
    path: getPath("/berkas"),
    isOpen: null,
    children: [],
  },
  {
    id: "divisi",
    path: [
      "staf-pers",
      "staf-sikomlek",
      "staf-pernika",
      "staf-konbekharstal",
      "staf-benghubdam",
      "staf-gudmathub",
      "staf-urlog",
      "staf-urlat",
      "staf-urpam",
      "staf-renproggar",
      "staf-denhubdam",
    ].map((slug) => getPath(`/divisi/${slug}`)),
    isOpen: false,
    children: [
      {
        id: "staf pers",
        path: getPath("/divisi/staf-pers"),
      },
      {
        id: "staf sikomlek",
        path: getPath("/divisi/staf-sikomlek"),
      },
      {
        id: "staf pernika",
        path: getPath("/divisi/staf-pernika"),
      },
      {
        id: "staf konbekharstal",
        path: getPath("/divisi/staf-konbekharstal"),
      },
      {
        id: "staf benghubdam",
        path: getPath("/divisi/staf-benghubdam"),
      },
      {
        id: "staf gudmathub",
        path: getPath("/divisi/staf-gudmathub"),
      },
      {
        id: "staf urlog",
        path: getPath("/divisi/staf-urlog"),
      },
      {
        id: "staf urlat",
        path: getPath("/divisi/staf-urlat"),
      },
      {
        id: "staf urpam",
        path: getPath("/divisi/staf-urpam"),
      },
      {
        id: "staf renproggar",
        path: getPath("/divisi/staf-renproggar"),
      },
      {
        id: "staf denhubdam",
        path: getPath("/divisi/staf-denhubdam"),
      },
    ],
  },
];
