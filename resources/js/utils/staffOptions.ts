export function getStaffOptions(): Record<string, string> {
  return {
    pers: "Staf Tuud/Pers",
    sikomlek: "Staf Sikomlek",
    pernika: "Staf Pernika",
    konbekharstal: "Staf Konbekharstal",
    benghubdam: "Staf Benghubdam",
    gudmathub: "Staf Gudmathub",
    urlog: "Staf Urlog",
    urlat: "Staf Urlat",
    urpam: "Staf Urpam",
    renproggar: "Staf Renproggar",
    denhubdam: "Staf Denhubdam",
  };
}

export function getStaffDisplayName(staffKey: string): string {
  const options = getStaffOptions();
  return options[staffKey] || "";
}
