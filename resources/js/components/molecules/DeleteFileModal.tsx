import React from "react";
import PrimaryButton from "../atoms/PrimaryButton";
import { HiOutlineX } from "react-icons/hi";

interface DeleteFileModalProps {
  isOpen: boolean;
  onClose: () => void;
  onConfirm: () => void;
  fileName?: string;
  mediaCount?: number;
  isLoading?: boolean;
}

export default function DeleteFileModal({
  isOpen,
  onClose,
  onConfirm,
  fileName,
  mediaCount = 1,
  isLoading,
}: DeleteFileModalProps) {
  if (!isOpen) return null;

  return (
    <dialog className="modal modal-open px-2">
      <section className="modal-box bg-white">
        <section className="flex flex-col gap-5">
          <section className="flex items-center justify-between border-b-2 border-solid border-gray-300 pb-3 text-black">
            <h3 className="text-lg font-bold">Konfirmasi Hapus</h3>
            <HiOutlineX size={25} className="cursor-pointer" onClick={onClose} />
          </section>

          <p className="text-black">
            Yakin ingin menghapus berkas <span className="font-semibold">{fileName}</span>
            {mediaCount > 1 && (
              <>
                {" "}
                dan <span className="font-semibold">{mediaCount - 1} file lainnya</span>
              </>
            )}
            ? Tindakan ini tidak bisa dibatalkan.
          </p>
        </section>

        <div className="modal-action">
          <button className="btn btn-outline" onClick={onClose}>
            Batal
          </button>
          <PrimaryButton className="bg-red-600 text-sm hover:bg-red-700" onClick={onConfirm} disabled={isLoading}>
            Hapus
          </PrimaryButton>
        </div>
      </section>
    </dialog>
  );
}
