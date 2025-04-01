import React, { useState } from "react";
import { useForm, usePage } from "@inertiajs/react";
import PrimaryButton from "@/components/atoms/PrimaryButton";
import SelectDropdown from "@/components/atoms/SelectDropdown";
import { fileTypeOptions } from "@/utils/fileOptions";
import { getAcceptedFileTypes } from "@/utils/fileValidate";
import { HiOutlineX } from "react-icons/hi";
import { ClientOnly } from "../ssr/ClientOnly";

interface UploadFileModalProps {
  isOpen: boolean;
  onClose: () => void;
  onStart?: () => void;
  onFinish?: () => void;
}

export default function UploadFileModal({ isOpen, onClose, onStart, onFinish }: UploadFileModalProps) {
  const { auth } = usePage().props;

  const [selectedFileType, setSelectedFileType] = useState("");
  const [isFileInputDisabled, setIsFileInputDisabled] = useState(true);
  const [files, setFiles] = useState<File[]>([]);

  const { setData, post, processing } = useForm<{
    user_id: number | undefined;
    files: File[];
  }>({
    user_id: auth.user.id,
    files: [],
  });

  const handleFileTypeChange = (value: string) => {
    setSelectedFileType(value);

    if (value) {
      setIsFileInputDisabled(false);
    } else {
      setIsFileInputDisabled(true);
    }

    setFiles([]);
  };

  const onDrop = (acceptedFiles: File[]) => {
    if (files.length + acceptedFiles.length > 5) {
      alert("You can only upload a maximum of 5 files.");
      return;
    }

    const acceptedTypes = getAcceptedFileTypes(selectedFileType);
    const acceptedMimeTypes = Object.keys(acceptedTypes);

    const validFiles: File[] = [];
    const invalidFiles: File[] = [];

    acceptedFiles.forEach((file) => {
      if (acceptedMimeTypes.includes(file.type)) {
        validFiles.push(file);
      } else {
        invalidFiles.push(file);
      }
    });

    if (invalidFiles.length > 0) {
      const invalidFileNames = invalidFiles.map((file) => file.name).join(", ");
      alert(`The following files are not allowed: ${invalidFileNames}`);
    }

    setFiles((prevFiles) => [...prevFiles, ...validFiles]);
    setData("files", [...files, ...validFiles]);
  };

  const handleDeleteFile = (fileIndex: number) => {
    const updatedFiles = files.filter((_, index) => index !== fileIndex);
    setFiles(updatedFiles);
    setData("files", updatedFiles);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    onStart?.();

    post(route("berkas.store"), {
      preserveScroll: true,
      onSuccess: () => {
        setSelectedFileType("");
        setFiles([]);
        onFinish?.();
        onClose();
      },
      onError: () => {
        onFinish?.();
      },
    });
  };

  const handleClose = () => {
    setSelectedFileType("");
    setIsFileInputDisabled(true);
    setFiles([]);
    setData("files", []);
    onClose();
  };

  if (!isOpen) return null;

  return (
    <dialog className="modal modal-open px-2">
      <div className="modal-box bg-white">
        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
          <section className="flex items-center justify-between border-b-2 border-solid border-gray-300 pb-3 text-black">
            <h3 className="text-lg font-bold">Unggah Berkas</h3>
            <HiOutlineX size={25} className="cursor-pointer" onClick={handleClose} />
          </section>

          <section className="mb-1">
            <label htmlFor="file-type" className="block text-sm font-medium text-gray-700">
              Pilih Tipe Berkas<span className="text-red-500">*</span>
            </label>

            <SelectDropdown
              name="file-type"
              value={selectedFileType}
              onChange={handleFileTypeChange}
              options={fileTypeOptions}
            />
          </section>

          <ClientOnly
            loader={() => import("@/components/atoms/UploadDropzone")}
            fallback={<div>Memuat area unggahan...</div>}
            props={{
              selectedFileType,
              isFileInputDisabled,
              onDrop,
            }}
          />

          {files.length > 0 && (
            <div className="mt-4">
              <h3 className="mb-2 text-sm font-medium text-gray-700">Berkas yang sudah diunggah:</h3>
              <ul className="space-y-2">
                {files.map((file, index) => (
                  <li key={index} className="flex items-center justify-between rounded-lg bg-gray-200 px-4 py-2">
                    <span className="text-gray-700">{file.name}</span>
                    <button
                      type="button"
                      onClick={() => handleDeleteFile(index)}
                      className="text-sm text-red-500 hover:text-red-700"
                    >
                      Hapus
                    </button>
                  </li>
                ))}
              </ul>
            </div>
          )}

          <section className="modal-action">
            <button className="btn btn-outline" type="button" onClick={handleClose}>
              Batal
            </button>

            <PrimaryButton className="text-sm" type="submit" disabled={processing}>
              Unggah
            </PrimaryButton>
          </section>
        </form>
      </div>
    </dialog>
  );
}
