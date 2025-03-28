import { BASE_PATH } from "@/constants/basePath";

/**
 * Build a full path with base path prefix.
 *
 * @param path - Relative route path. e.g. /lorem
 * @returns Full path with base prefix. e.g. /sub/lorem
 */
export const getPath = (path: string): string => {
  return `${BASE_PATH}${path.startsWith("/") ? path.slice(1) : path}`;
};

/**
 * Build a full asset URL from /public/assets.
 *
 * @param assetPath - Path to the asset file. e.g. /images/logo.png
 * @returns Full asset URL. e.g. /sub/assets/images/logo.png
 */
export const getAssetUrl = (assetPath: string): string => {
  return getPath("/assets/" + assetPath.replace(/^\/+/, ""));
};

/**
 * Build a full storage file URL from /storage.
 *
 * @param fileName - Storage file name or path. e.g. /avatars/users1.png
 * @returns Full storage file URL. e.g. /sub/storage/avatars/users1.png
 */
export const getStorageUrl = (fileName: string): string => {
  return getPath("/storage/" + fileName.replace(/^\/+/, ""));
};
