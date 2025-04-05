import { useState } from "react";

export default function useLoadingSubmit() {
  const [loading, setLoading] = useState(false);

  const getOptionsWithLoading = (options?: Record<string, any>) => ({
    ...options,
    onStart: () => {
      setLoading(true);
      options?.onStart?.();
    },
    onFinish: () => {
      setLoading(false);
      options?.onFinish?.();
    },
  });

  return { loading, getOptionsWithLoading };
}
