export const MARKDOWN_PARSER_COMPONENTS_CUSTOMIZATION = {
  p: ({ node, ...props }: any) => <p style={{ wordBreak: "break-word" }} {...props} />,
  a: ({ node, ...props }: any) => <a style={{ wordBreak: "break-word" }} {...props} />,
  li: ({ node, ...props }: any) => <li style={{ padding: "0 10px"}} {...props} />,
};