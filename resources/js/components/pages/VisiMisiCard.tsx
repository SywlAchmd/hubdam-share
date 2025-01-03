import { MarkdownParser } from "../ui";

export default function VisiMisiCard({ text }: { text: string }) {
  return (
    <section className="w-full rounded-2xl bg-white p-8 text-justify text-lg drop-shadow">
      <MarkdownParser content={text} />
    </section>
  );
}
