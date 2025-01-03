import CardName from "@/components/pages/CardName";
import { Hero } from "@/layouts";
import { TStaffProps } from "@/types/components/TStaff";
import { Head, Link, usePage } from "@inertiajs/react";

export default function Staff({staff, type} : TStaffProps) {
  const { data, ...pagination } = staff;

  return (
    <>
      <Head title="Divisi" />
      <Hero pageName={type} />
      <section className="single-section-padding grid min-h-[80vh]">
        <section className="grid grid-cols-3 place-items-center gap-10 smdlg:grid-cols-2">
          {data.length === 0 ? (
            <p className="col-span-3 text-center text-gray-500">Tidak ada data staff yang ditemukan.</p>
          ) : (
            data.map((data, index) => <CardName key={index} name={data.name} staff={data.staff} image={data.image} />)
          )}
        </section>

        <section className="flex justify-end">
          <div className="join join-forest-green">
            {pagination.links.map((link, index) => (
              <Link
                href={link.url ? link.url : ""}
                key={`pagination-link-${index}`}
                className={`join-item btn btn-sm ${link.active ? "btn-active" : ""} ${!link.url ? "btn-disabled" : ""}`}
                dangerouslySetInnerHTML={{ __html: link.label }}
                disabled={!link.url}
              ></Link>
            ))}
          </div>
        </section>
      </section>
    </>
  );
}
