import { useState } from "react";
import { router } from "@inertiajs/react";

export default function useDeleteModal(routeName: string, onSuccess?: () => void) {
  const [state, setState] = useState<{
    id: number | null;
    name: string;
    mediaCount: number;
    open: boolean;
  }>({
    id: null,
    name: "",
    mediaCount: 1,
    open: false,
  });

  const open = (id: number, name: string, mediaCount: number = 1) => {
    setState({ id, name, mediaCount, open: true });
  };

  const close = () => {
    setState({ id: null, name: "", mediaCount: 1, open: false });
  };

  const confirm = () => {
    if (!state.id) return;

    router.delete(route(routeName, state.id), {
      preserveScroll: true,
      onSuccess: () => {
        close();
        onSuccess?.();
      },
    });
  };

  return {
    isOpen: state.open,
    fileName: state.name,
    mediaCount: state.mediaCount,
    openDeleteModal: open,
    closeDeleteModal: close,
    confirmDelete: confirm,
  };
}
