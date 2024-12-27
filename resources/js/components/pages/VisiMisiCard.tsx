import { TVisiMisi } from "@/types/components/TVisiMisi";
import React from "react";
import { MarkdownParser } from "../ui";

export default function VisiMisiCard({ text }: TVisiMisi) {
  return (
    <section className="w-full rounded-2xl bg-white p-8 text-justify text-lg drop-shadow">
      <MarkdownParser content={text} />
    </section>
  );
}
