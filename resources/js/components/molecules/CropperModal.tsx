import React, { useState } from "react";
import Cropper from "react-easy-crop";
import { getCroppedImg } from "@/utils/cropImage";

interface CropperModalProps {
  imageSrc: string;
  isOpen: boolean;
  onClose: () => void;
  onCropComplete: (croppedImage: string) => void;
}

const CropperModal: React.FC<CropperModalProps> = ({ imageSrc, isOpen, onClose, onCropComplete }) => {
  const [crop, setCrop] = useState({ x: 0, y: 0 });
  const [zoom, setZoom] = useState(1.2);
  const [croppedArea, setCroppedArea] = useState<any>(null);

  const handleCropComplete = async () => {
    try {
      if (!croppedArea) return;

      const croppedImage = await getCroppedImg(imageSrc, croppedArea);
      onCropComplete(croppedImage);
      onClose();
    } catch (error) {
      console.error("Error cropping image:", error);
    }
  };

  if (!isOpen) return null;

  return (
    <dialog open={isOpen} className="modal modal-open">
      <form method="dialog" className="modal-box w-11/12 max-w-2xl bg-white">
        <h3 className="mb-4 text-lg font-bold text-black">Potong Gambar</h3>

        <div className="relative h-80 w-full bg-gray-100">
          <Cropper
            image={imageSrc}
            crop={crop}
            zoom={zoom}
            aspect={1}
            onCropChange={setCrop}
            onCropComplete={(_, area) => setCroppedArea(area)}
            onZoomChange={setZoom}
          />
        </div>

        <div className="mt-4">
          <label className="mb-2 block text-sm font-medium text-gray-700">Zoom</label>
          <input
            type="range"
            min={1}
            max={3}
            step={0.1}
            value={zoom}
            onChange={(e) => setZoom(Number(e.target.value))}
            className="range-neutral range"
          />
        </div>

        <div className="modal-action mt-4 flex justify-between">
          <button type="button" className="btn btn-outline btn-error" onClick={onClose}>
            Batal
          </button>
          <button
            type="button"
            className="btn bg-forest-green text-white hover:bg-forest-green-dark"
            onClick={handleCropComplete}
          >
            Simpan
          </button>
        </div>
      </form>
    </dialog>
  );
};

export default CropperModal;
