import "./bootstrap";
import "../css/app.css";

import { createInertiaApp } from "@inertiajs/react";
import { createRoot, hydrateRoot } from "react-dom/client";
import { Layout } from "./layouts";
import { Toaster } from "sonner";

interface PageModule {
  default: React.FC & { layout?: (page: React.ReactNode) => React.ReactNode };
}

const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => {
    const pages = import.meta.glob<PageModule>("./pages/**/*.tsx", { eager: true });
    let page = pages[`./pages/${name}.tsx`];

    page.default.layout = page.default.layout || ((page: React.ReactNode) => <Layout children={page} />);

    return page;
  },
  setup({ el, App, props }) {
    const content = (
      <>
        <App {...props} />
        <Toaster
          richColors
          position="top-right"
          toastOptions={{ className: "toast-sonner" }}
          closeButton
          duration={2000}
        />
      </>
    );

    if (import.meta.env.SSR) {
      hydrateRoot(el, content);
    } else {
      createRoot(el).render(content);
    }
  },
});
// .then(() => {
//   document.getElementById('app')?.removeAttribute('data-page');
// });;
