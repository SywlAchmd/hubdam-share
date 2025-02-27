import React, { useState } from "react";
import Cropper from "react-easy-crop";
import { getCroppedImg } from "@/utils/cropImage";

interface CropperModalProps {
  imageSrc: string;
  isOpen: boolean;
  onClose: () => void;
  onCropComplete: (croppedImage: string) => void;
}

export const CropperModal: React.FC<CropperModalProps> = ({ imageSrc, isOpen, onClose, onCropComplete }) => {
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
      <form method="dialog" className="modal-box w-11/12 max-w-2xl">
        <h3 className="mb-4 text-lg font-bold">Crop Image</h3>

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
            className="range range-primary"
          />
        </div>

        <div className="modal-action mt-4 flex justify-between">
          <button type="button" className="btn btn-outline" onClick={onClose}>
            Cancel
          </button>
          <button
            type="button"
            className="btn bg-forest-green text-white hover:bg-forest-green-dark"
            onClick={handleCropComplete}
          >
            Crop
          </button>
        </div>
      </form>
    </dialog>
  );
};
