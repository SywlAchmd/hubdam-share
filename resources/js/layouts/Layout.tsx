import Navbar from "./Navbar";
import Footer from "./Footer";
import { PropsWithChildren } from "react";
import { usePage } from "@inertiajs/react";

export default function Layout({ children }: PropsWithChildren) {
  const { auth } = usePage().props;

  return (
    <section className="font-poppins">
      {auth.user && <Navbar />}
      <main className="">{children}</main>
      {auth.user && <Footer />}
    </section>
  );
}
