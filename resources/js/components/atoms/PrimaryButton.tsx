import { ButtonHTMLAttributes } from "react";

export default function PrimaryButton({
  className = "",
  disabled,
  children,
  ...props
}: ButtonHTMLAttributes<HTMLButtonElement>) {
  return (
    <button
      {...props}
      className={
        `inline-flex items-center rounded-md border border-transparent bg-forest-green px-4 py-2 font-semibold tracking-widest text-white transition duration-150 ease-in-out hover:bg-forest-green-dark focus:bg-forest-green-dark focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 active:bg-forest-green-dark ${
          disabled && "opacity-25"
        } ` + className
      }
      disabled={disabled}
    >
      {children}
    </button>
  );
}
