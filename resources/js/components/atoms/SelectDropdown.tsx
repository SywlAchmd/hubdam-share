import React from "react";

type FilterDropdownProps = {
  name?: string;
  options: { label: string; value: string }[];
  onChange: (value: string) => void;
  value?: string;
  className?: string;
};

export default function SelectDropdown({ name, options, onChange, value, className }: FilterDropdownProps) {
  return (
    <select
      name={name}
      value={value}
      onChange={(e) => onChange(e.target.value)}
      className={`block w-full rounded-lg border px-3 py-1.5 text-black focus:outline-none ${className}`}
    >
      {options.map((option, index) => (
        <option key={index} value={option.value}>
          {option.label}
        </option>
      ))}
    </select>
  );
}
