import React, { lazy, Suspense } from "react";

interface ClientOnlyProps {
  loader: () => Promise<{ default: React.ComponentType<any> }>;
  fallback?: React.ReactNode;
  props?: Record<string, any>;
}

export const ClientOnly = ({ loader, fallback = null, props = {} }: ClientOnlyProps) => {
  const [ready, setReady] = React.useState(false);
  const Component = React.useMemo(() => lazy(loader), [loader]);

  React.useEffect(() => {
    setReady(true);
  }, []);

  return ready ? (
    <Suspense fallback={fallback}>
      <Component {...props} />
    </Suspense>
  ) : (
    <>{fallback}</>
  );
};
