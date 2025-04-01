import { useState } from "react";
import { router } from "@inertiajs/react";

type SubmitOptions = {
  onSuccess?: () => void;
  onError?: () => void;
  preserveScroll?: boolean;
  preserveState?: boolean;
};

export default function useLoadingSubmit() {
  const [loading, setLoading] = useState(false);

  const submit = (
    method: "post" | "put" | "delete",
    url: string,
    data: Record<string, any> = {},
    options?: SubmitOptions,
  ) => {
    setLoading(true);
    router[method](url, data, {
      preserveScroll: options?.preserveScroll ?? true,
      preserveState: options?.preserveState ?? true,
      onSuccess: () => {
        setLoading(false);
        options?.onSuccess?.();
      },
      onError: () => {
        setLoading(false);
        options?.onError?.();
      },
    });
  };

  return { loading, submit };
}
