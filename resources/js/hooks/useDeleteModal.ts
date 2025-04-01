import { useState } from "react";
import { router } from "@inertiajs/react";

export default function useDeleteModal(routeName: string, onSuccess?: () => void) {
  const [state, setState] = useState({
    id: null as number | null,
    name: "",
    mediaCount: 1,
    open: false,
  });

  const [loading, setLoading] = useState(false);

  const open = (id: number, name: string, mediaCount: number = 1) => {
    setState({ id, name, mediaCount, open: true });
  };

  const close = () => {
    setState({ id: null, name: "", mediaCount: 1, open: false });
    setLoading(false);
  };

  const confirm = () => {
    if (!state.id) return;

    setLoading(true);

    router.delete(route(routeName, state.id), {
      preserveScroll: true,
      onSuccess: () => {
        close();
        onSuccess?.();
      },
      onError: () => {
        setLoading(false);
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
    isDeleting: loading,
  };
}
