import React, { InputHTMLAttributes } from "react";
import InputLabel from "../atoms/InputLabel";
import TextInput from "../atoms/TextInput";
import InputError from "../atoms/InputError";

interface FormInputProps extends InputHTMLAttributes<HTMLInputElement> {
  label: string;
  error?: string;
}

export default function FormInput({
  label,
  value,
  onChange,
  onBlur,
  error,
  placeholder,
  disabled = false,
  type = "text",
}: FormInputProps) {
  return (
    <section>
      <InputLabel value={label} />
      <TextInput
        value={value}
        onChange={onChange}
        onBlur={onBlur}
        placeholder={placeholder}
        type={type}
        disabled={disabled}
        className="w-full rounded-lg border-2 border-solid border-light-gray focus:border-forest-green focus:ring-forest-green disabled:border-slate-200 disabled:bg-slate-50 disabled:text-slate-500 disabled:shadow-none"
      />
      <InputError message={error} className="mt-1" />
    </section>
  );
}
