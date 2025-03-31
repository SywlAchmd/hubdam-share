import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import { Hero } from "@/layouts";
import { TStaffProps } from "@/types/components/TStaff";
import CardName from "@/components/pages/CardName";
import InputSearch from "@/components/molecules/InputSearch";
import Pagination from "@/components/molecules/Pagination";

export default function Staff({ staff, type }: TStaffProps) {
  const { data, ...pagination } = staff;

  const [search, setSearch] = useState("");

  const handleSearch = () => {
    router.get(
      window.location.pathname,
      { search },
      {
        preserveScroll: true,
        preserveState: true,
      },
    );
  };

  const handleReset = () => {
    setSearch("");
    router.get(window.location.pathname, {}, { preserveScroll: true, preserveState: true });
  };

  return (
    <>
      <Head title="Divisi" />
      <Hero pageName={type} bgImage="divisi-bg.png" uppercase={true} />
      <section className="single-section-padding grid min-h-[80vh] gap-5">
        <section className="flex items-center justify-end">
          <InputSearch value={search} placeholder="Cari Nama Staff" onChange={setSearch} onSearch={handleSearch} onReset={handleReset} />
        </section>

        <section className="grid grid-cols-3 place-items-center gap-10 smdlg:grid-cols-2">
          {data.length === 0 ? (
            <p className="col-span-3 text-center text-gray-500">Tidak ada data staff yang ditemukan.</p>
          ) : (
            data.map((data, index) => <CardName key={index} name={data.name} staff={data.staff} image={data.image} />)
          )}
        </section>

        <section className="flex justify-end">
          <Pagination pagination={pagination} />
        </section>
      </section>
    </>
  );
}
