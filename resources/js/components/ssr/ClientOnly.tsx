import { useEffect, useState, Suspense } from "react";

interface ClientOnlyProps {
  loader: () => Promise<{ default: React.ComponentType<any> }>;
  fallback?: React.ReactNode;
  props?: Record<string, any>;
}

export function ClientOnly({ loader, fallback = null, props = {} }: ClientOnlyProps) {
  const [Component, setComponent] = useState<React.ComponentType<any> | null>(null);

  useEffect(() => {
    let mounted = true;
    loader().then((mod) => {
      if (mounted) setComponent(() => mod.default);
    });

    return () => {
      mounted = false;
    };
  }, [loader]);

  if (!Component) return <>{fallback}</>;

  return (
    <Suspense fallback={fallback}>
      <Component {...props} />
    </Suspense>
  );
}
