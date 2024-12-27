import React from "react";
import Navbar from "./Navbar";
import Footer from "./Footer";
import { TLayoutProps } from "@/types/layouts/TLayout";

export default function Layout({ children }: TLayoutProps) {
  return (
    <section className="font-poppins">
      <Navbar />
      <main className="">{children}</main>
      <Footer />
    </section>
  );
}
