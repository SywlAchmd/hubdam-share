import { Area } from "react-easy-crop";

export const createImage = (url: string): Promise<HTMLImageElement> =>
  new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => resolve(img);
    img.onerror = reject;
    img.src = url;
  });

export const getCroppedCanvas = (image: HTMLImageElement, crop: Area): HTMLCanvasElement => {
  const canvas = document.createElement("canvas");
  const ctx = canvas.getContext("2d");

  const TARGET_SIZE = 500;
  canvas.width = TARGET_SIZE;
  canvas.height = TARGET_SIZE;

  ctx?.drawImage(image, crop.x, crop.y, crop.width, crop.height, 0, 0, canvas.width, canvas.height);

  return canvas;
};

export const getCroppedImg = async (imageSrc: string, crop: Area): Promise<string> => {
  const image = await createImage(imageSrc);
  const canvas = getCroppedCanvas(image, crop);
  return canvas.toDataURL("image/jpeg");
};
