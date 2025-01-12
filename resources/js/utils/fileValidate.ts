export const getAcceptedFileTypes = (fileType: string): Record<string, string[]> => {
  switch (fileType) {
    case "excel":
      return {
        "application/vnd.ms-excel": [],
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": [],
      };
    case "word":
      return {
        "application/msword": [],
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document": [],
      };
    case "ppt":
      return {
        "application/vnd.ms-powerpoint": [],
        "application/vnd.openxmlformats-officedocument.presentationml.presentation": [],
      };
    case "image":
      return {
        "image/jpeg": [],
        "image/png": [],
      };
    case "pdf":
      return {
        "application/pdf": [],
      };
    default:
      return {};
  }
};

export const validateFiles = (files: File[]): boolean => {
  if (files.length > 5) {
    alert("You can only upload a maximum of 5 files.");
    return false;
  }
  return true;
};
