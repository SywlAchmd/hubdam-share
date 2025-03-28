export const fileTypeOptions = [
  { value: "", label: "--Pilih tipe file yang ingin diupload--" },
  { value: "excel", label: "Excel" },
  { value: "word", label: "Word" },
  { value: "ppt", label: "PPT" },
  { value: "image", label: "Image" },
  { value: "pdf", label: "PDF" },
];

export const filterOptions = [
  { label: "Semua", value: "all" },
  { label: "PDF", value: "pdf" },
  { label: "Word", value: "word" },
  { label: "Excel", value: "excel" },
  { label: "Power Point", value: "ppt" },
  { label: "Gambar", value: "image" },
];

export const tabOptions = [
  { label: "Semua", value: "all" },
  { label: "Saya", value: "mine" },
  { label: "Staff Lain", value: "staff" },
];

export const fileTypeLabels: Record<string, string> = {
  pdf: "PDF",
  word: "Word",
  excel: "Excel",
  ppt: "Power Point",
  image: "Gambar",
};

export function getFileTypeLabel(collectionName: string): string {
  const type = collectionName.replace("file-", "");
  return fileTypeLabels[type] || type;
}
