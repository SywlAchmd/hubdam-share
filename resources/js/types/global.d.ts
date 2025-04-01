import { PageProps as InertiaPageProps } from "@inertiajs/core";
import { AxiosInstance } from "axios";
import { route as ziggyRoute } from "ziggy-js";
import { PageProps as AppPageProps } from "./";

type ZiggyRoute = {
  uri: string;
  methods: string[];
  parameters?: string[];
  bindings?: Record<string, string>;
  wheres?: Record<string, string>;
};

declare global {
  interface Window {
    axios: AxiosInstance;
    Ziggy?: {
      routes: Record<string, ZiggyRoute>;
    };
  }

  /* eslint-disable no-var */
  var route: typeof ziggyRoute;
}

declare module "@inertiajs/core" {
  interface PageProps extends InertiaPageProps, AppPageProps {}
}
