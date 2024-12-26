import React from "react";
import Navbar from "./Navbar";
import { TLayoutProps } from "@/types/layouts/TLayout";

export default function Layout({ children }: TLayoutProps) {
  return (
    <section className="font-poppins">
      <header>
        <Navbar />
      </header>

      <main>{children}</main>
    </section>
  );
}
