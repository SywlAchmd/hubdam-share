import React, { useEffect, useState } from "react";
import { Head, router, usePage } from "@inertiajs/react";
import DataTable from "@/components/organisms/DataTable";
import { TBerkasProps, TMedia, TUser } from "@/types/components/TBerkas";
import { formatDate } from "@/utils/parserDate";
import { HiOutlineTrash } from "react-icons/hi2";
import { toast } from "sonner";
import { Hero } from "@/layouts";
import { filterOptions } from "@/utils/fileOptions";
import UploadFileModal from "@/components/molecules/UploadFileModal";
import { MdDownload } from "react-icons/md";

export default function Berkas({ files }: TBerkasProps) {
  const { flash } = usePage().props;
  const { data, ...pagination } = files;

  const [search, setSearch] = useState("");
  const [filter, setFilter] = useState("all");
  const [isModalOpen, setIsModalOpen] = useState(false);

  useEffect(() => {
    if (flash.success) {
      toast.success(flash.success);
    }
    if (flash.error) {
      toast.error(flash.error);
    }
  }, [flash]);

  const handleSearch = () => {
    router.get(
      "/berkas",
      { search, filter },
      {
        preserveScroll: true,
        preserveState: true,
      },
    );
  };

  const handleReset = () => {
    setSearch("");
    router.get("/berkas", { filter }, { preserveScroll: true, preserveState: true });
  };

  const handleFilter = (value: string) => {
    setFilter(value);
    router.get(
      "/berkas",
      { search, filter: value },
      {
        preserveScroll: true,
        preserveState: true,
      },
    );
  };

  const handleDownload = (id: number) => {
    const downloadUrl = route("berkas.download", id);

    window.location.href = downloadUrl;
  };

  const handleDelete = (id: number) => {
    const confirmed = confirm("Anda yakin ingin menghapus data ini?");
    if (!confirmed) return;

    router.delete(route("berkas.destroy", id), {
      preserveScroll: true,
    });
  };

  return (
    <>
      <Head title="Berkas" />

      <Hero pageName="Berkas" bgImage="berkas-bg.png" />
      <section className="single-section-padding">
        <section className="flex items-center justify-between">
          <h1 className="page-title mb-2">Semua File</h1>

          <button onClick={() => setIsModalOpen(true)} className="btn btn-outline btn-success btn-sm">
            Upload File
          </button>
        </section>

        <DataTable
          title="Browse Files"
          searchable
          filterable
          search={search}
          filter={filter}
          options={filterOptions}
          handleSearch={handleSearch}
          handleFilter={handleFilter}
          handleReset={handleReset}
          onSearchChange={setSearch}
          columns={[
            {
              title: "No",
              dataIndex: "no",
              render: (_: any, index: number) => <div className="text-center">{pagination.from + index}</div>,
            },
            {
              title: "Nama",
              dataIndex: "user",
              render: (value: TUser) => value.name,
            },
            {
              title: "Email",
              dataIndex: "user",
              render: (value: TUser) => value.email,
            },
            {
              title: "File",
              dataIndex: "media",
              render: (value: TMedia[] | TMedia) =>
                Array.isArray(value) ? (
                  <ul>
                    {value.map((media, index) => (
                      <li key={index}>
                        <a
                          href={media.original_url}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="text-blue-500 underline"
                        >
                          {media.name}
                        </a>
                      </li>
                    ))}
                  </ul>
                ) : (
                  <a
                    href={value.original_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="text-blue-500 underline"
                  >
                    {value.name}
                  </a>
                ),
            },
            {
              title: "Tipe File",
              dataIndex: "media",
              render: (value: TMedia[] | TMedia) => (
                <span className="capitalize">
                  {Array.isArray(value) ? value[0].collection_name : value.collection_name}
                </span>
              ),
            },
            {
              title: "Waktu",
              dataIndex: "created_at",
              render: (value: string) => formatDate(new Date(value)),
            },
            {
              title: "Action",
              dataIndex: "action",
              render: (_: unknown, __: unknown, record: { id: number }) => (
                <section className="flex gap-2">
                  <button onClick={() => handleDownload(record.id)} className="btn btn-success btn-sm">
                    <MdDownload className="text-lg text-white" />
                  </button>

                  <button onClick={() => handleDelete(record.id)} className="btn btn-error btn-sm">
                    <HiOutlineTrash className="text-lg text-white" />
                  </button>
                </section>
              ),
            },
          ]}
          dataSource={data}
          pagination={pagination}
        />
      </section>

      <UploadFileModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />
    </>
  );
}
