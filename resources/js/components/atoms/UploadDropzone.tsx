import React from "react";
import { useDropzone } from "react-dropzone";
import { getAcceptedFileTypes } from "@/utils/fileValidate";

interface UploadDropzoneProps {
  selectedFileType?: string;
  isFileInputDisabled: boolean;
  onDrop: (acceptedFiles: File[]) => void;
}

export default function UploadDropzone({ selectedFileType, isFileInputDisabled, onDrop }: UploadDropzoneProps) {
  const { getRootProps, getInputProps } = useDropzone({
    onDrop,
    accept: selectedFileType ? getAcceptedFileTypes(selectedFileType) : undefined,
    disabled: isFileInputDisabled,
  });

  return (
    <div
      {...getRootProps()}
      className={`cursor-pointer rounded-lg border-2 border-dashed py-14 ${
        isFileInputDisabled ? "cursor-not-allowed border-solid border-gray-400 bg-gray-100" : "bg-white"
      }`}
    >
      <input {...getInputProps()} />
      {isFileInputDisabled ? (
        <p className="text-center text-gray-400">Pilih tipe file terlebih dahulu sebelum mengupload.</p>
      ) : (
        <p className="text-center text-gray-700">Drag dan drop file di sini, atau klik untuk memilih file.</p>
      )}
    </div>
  );
}
