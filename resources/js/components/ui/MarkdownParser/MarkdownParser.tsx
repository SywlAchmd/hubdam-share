import React from "react";
import ReactMarkdown from "react-markdown";
import { MARKDOWN_PARSER_COMPONENTS_CUSTOMIZATION } from "@/constants/components/MarkdownParserConstants";

const MARKDOWN_CLASSNAME_HELPER = `
prose max-w-none
prose-a:no-underline prose-a:text-primary-300 hover:prose-a:underline
prose-p:mt-0 prose-p:mb-1
prose-li:mt-0 prose-li:mb-1
prose-ul:mt-0 prose-ul:mb-2
prose-ol:mt-0 prose-ol:mb-2
`;

export default function MarkdownParser({ content }: { content: string }) {
  return (
    <section className={MARKDOWN_CLASSNAME_HELPER}>
      <ReactMarkdown components={MARKDOWN_PARSER_COMPONENTS_CUSTOMIZATION}>{content}</ReactMarkdown>
    </section>
  );
}
