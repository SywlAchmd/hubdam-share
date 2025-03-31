import React, { useEffect, useState } from "react";
import { MdDownload } from "react-icons/md";
import { HiOutlineTrash } from "react-icons/hi2";
import { toast } from "sonner";
import { Head, router, usePage } from "@inertiajs/react";
import { Hero } from "@/layouts";
import { getPath } from "@/utils/pathHelper";
import { formatDate } from "@/utils/parserDate";
import { getStaffDisplayName } from "@/utils/staffOptions";
import { filterOptions, getFileTypeLabel, tabOptions } from "@/utils/fileOptions";
import { TBerkasProps, TMedia, TUser } from "@/types/components/TBerkas";
import useDeleteModal from "@/hooks/useDeleteModal";
import UploadFileModal from "@/components/molecules/UploadFileModal";
import DeleteFileModal from "@/components/molecules/DeleteFileModal";
import DataTable from "@/components/organisms/DataTable";

export default function Berkas({ files }: TBerkasProps) {
  const { flash, auth } = usePage().props;
  const { data, ...pagination } = files;

  const [search, setSearch] = useState("");
  const [filter, setFilter] = useState("all");
  const [tabFilter, setTabFilter] = useState("all");
  const [isModalOpen, setIsModalOpen] = useState(false);

  const {
    isOpen: isDeleteModalOpen,
    fileName,
    mediaCount,
    openDeleteModal,
    closeDeleteModal,
    confirmDelete,
  } = useDeleteModal("berkas.destroy");

  useEffect(() => {
    if (flash.success) {
      toast.success(flash.success);
    }
    if (flash.error) {
      toast.error(flash.error);
    }
  }, [flash]);

  const applyFilter = (params: Partial<{ search: string; filter: string; tab: string }>) => {
    router.get(
      getPath("/berkas"),
      {
        search,
        filter,
        tab: tabFilter,
        ...params,
      },
      {
        preserveScroll: true,
        preserveState: true,
      },
    );
  };

  const handleSearch = () => {
    applyFilter({});
  };

  const handleReset = () => {
    setSearch("");
    applyFilter({ search: "" });
  };

  const handleFilter = (value: string) => {
    setFilter(value);
    applyFilter({ filter: value });
  };

  const handleTabFilterChange = (value: string) => {
    setTabFilter(value);
    applyFilter({ tab: value });
  };

  const handleDownload = (id: number) => {
    const downloadUrl = route("berkas.download", id);

    window.location.href = downloadUrl;
  };

  return (
    <>
      <Head title="Berkas" />

      <Hero pageName="Berkas" bgImage="berkas-bg.png" />
      <section className="single-section-padding">
        <section className="flex items-center justify-between">
          <h1 className="page-title mb-2">Daftar Berkas</h1>

          <button onClick={() => setIsModalOpen(true)} className="btn btn-outline btn-success btn-sm">
            Unggah Berkas
          </button>
        </section>

        <DataTable
          title=""
          searchable
          filterable
          tabsFilterable
          search={search}
          filter={filter}
          options={filterOptions}
          tabOptions={tabOptions}
          tabFilter={tabFilter}
          handleSearch={handleSearch}
          handleFilter={handleFilter}
          handleReset={handleReset}
          onSearchChange={setSearch}
          onTabFilterChange={handleTabFilterChange}
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
              title: "Staff",
              dataIndex: "user",
              render: (value: TUser) => getStaffDisplayName(value.staff),
            },
            {
              title: "Berkas",
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
              title: "Tipe Berkas",
              dataIndex: "media",
              render: (value: TMedia[] | TMedia) => {
                const collection = Array.isArray(value) ? value[0].collection_name : value.collection_name;
                return <span className="capitalize">{getFileTypeLabel(collection)}</span>;
              },
            },
            {
              title: "Waktu",
              dataIndex: "created_at",
              render: (value: string) => formatDate(new Date(value)),
            },
            {
              title: "Action",
              dataIndex: "action",
              render: (_: unknown, __: unknown, record: { id: number; user_id: number; media?: TMedia[] }) => (
                <section className="flex gap-2 justify-self-center">
                  <button onClick={() => handleDownload(record.id)} className="btn btn-success btn-sm">
                    <MdDownload className="text-lg text-white" />
                  </button>

                  {record.user_id === auth.user.id && (
                    <button
                      onClick={() =>
                        openDeleteModal(record.id, record.media?.[0]?.name ?? "Berkas", record.media?.length ?? 1)
                      }
                      className="btn btn-error btn-sm"
                    >
                      <HiOutlineTrash className="text-lg text-white" />
                    </button>
                  )}
                </section>
              ),
            },
          ]}
          dataSource={data}
          pagination={pagination}
        />
      </section>

      <UploadFileModal isOpen={isModalOpen} onClose={() => setIsModalOpen(false)} />

      <DeleteFileModal
        isOpen={isDeleteModalOpen}
        onClose={closeDeleteModal}
        onConfirm={confirmDelete}
        fileName={fileName}
        mediaCount={mediaCount}
      />
    </>
  );
}
