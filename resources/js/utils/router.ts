/**
 * Remove trailing slash (except for root '/')
 */
export const normalizePath = (path: string): string => (path.endsWith("/") && path !== "/" ? path.slice(0, -1) : path);

/**
 * Check if current path matches target path, ignoring trailing slash.
 *
 * @param current - Current pathname (usually from window.location.pathname)
 * @param target - Target path to compare with
 * @returns true if they match, false otherwise
 */
export const isActivePath = (current: string, target: string): boolean => {
  return normalizePath(current) === normalizePath(target);
};
