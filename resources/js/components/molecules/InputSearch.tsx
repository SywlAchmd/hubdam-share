import React from "react";
import TextInput from "../atoms/TextInput";
import { IoIosSearch } from "react-icons/io";

type InputSearchProps = {
  value: string;
  onChange: (value: string) => void;
  onSearch: () => void;
  onReset: () => void;
  placeholder: string;
};

export default function InputSearch({ value, onChange, onSearch, onReset, placeholder }: InputSearchProps) {
  return (
    <section className="flex h-fit items-center gap-2">
      <section className="flex h-fit items-center justify-center rounded-lg border-2 border-solid border-gray-300 bg-white px-2">
        <IoIosSearch className="size-6 text-gray-400" />
        <TextInput
          placeholder={placeholder}
          className="input-sm max-w-[200px] border-none text-black outline-none placeholder:text-gray-400 focus:border-none focus:ring-transparent smdlg:w-full"
          value={value}
          onChange={(e) => onChange(e.target.value)}
          onKeyDown={(e) => e.key === "Enter" && onSearch()}
        />
      </section>

      <button className="btn btn-sm bg-forest-green text-white" onClick={onSearch}>
        Search
      </button>

      <button className="btn btn-outline btn-sm border-forest-green text-forest-green" onClick={onReset}>
        Reset
      </button>
    </section>
  );
}
