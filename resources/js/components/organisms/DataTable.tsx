import React from "react";
import { PaginationProps } from "@/types/components/TPagination";
import { Field } from "@headlessui/react";
import SelectDropdown from "../atoms/SelectDropdown";
import InputSearch from "../molecules/InputSearch";
import FilterTabs from "../molecules/FilterTabs";
import Pagination from "../molecules/Pagination";

type DataTableProps = {
  dataSource: any[];
  columns: any[];
  pagination: PaginationProps;
  title: string;
  searchable?: boolean;
  filterable?: boolean;
  tabsFilterable?: boolean;
  options: { label: string; value: string }[];
  tabOptions: { label: string; value: string }[];
  search?: string;
  filter?: string;
  tabFilter?: string;
  handleSearch?: () => void;
  handleFilter?: (value: string) => void;
  handleReset?: () => void;
  onSearchChange?: (value: string) => void;
  onTabFilterChange?: (value: string) => void;
};

export default function DataTable({
  dataSource,
  columns,
  pagination,
  title,
  searchable = false,
  filterable = false,
  tabsFilterable = false,
  options,
  tabOptions,
  search,
  tabFilter,
  handleSearch,
  handleFilter,
  handleReset,
  onSearchChange,
  onTabFilterChange,
}: DataTableProps) {
  return (
    <>
      {/* Tab */}
      {tabsFilterable && onTabFilterChange && tabFilter && (
        <section className="flex justify-self-center p-3">
          <FilterTabs tabs={tabOptions} selectedFilter={tabFilter} onFilterChange={onTabFilterChange} />
        </section>
      )}

      <section className="space-y-3 rounded-lg bg-white p-4 shadow">
        <div className="flex flex-col gap-3 md:flex-row md:items-center">
          <section className="flex items-center justify-between">
            <p className="font-semibold text-black lg:w-2/3">{title}</p>

            {/* Dropdown */}
            {filterable && (
              <Field>
                <SelectDropdown
                  name="status"
                  options={options}
                  className="mx-2 w-48"
                  onChange={handleFilter || (() => {})}
                />
              </Field>
            )}
          </section>

          {/* Search Input */}
          {searchable && (
            <div className="ml-auto flex w-full items-center justify-end gap-2 lg:w-1/3">
              <InputSearch
                value={search || ""}
                onChange={onSearchChange || (() => {})}
                onSearch={handleSearch || (() => {})}
                onReset={handleReset || (() => {})}
                placeholder="Cari Nama atau Berkas"
              />
            </div>
          )}
        </div>

        {/* table */}
        <div className="overflow-x-auto">
          <table className="table">
            <thead>
              <tr>
                {columns.map((column) => (
                  <th key={column.dataIndex} className="relative align-middle text-black">
                    {column.title}
                  </th>
                ))}
              </tr>
            </thead>
            <tbody>
              {dataSource.length === 0 ? (
                <tr>
                  <td className="py-6 text-center" colSpan={columns.length}>
                    Tidak ada berkas yang tersedia...
                  </td>
                </tr>
              ) : (
                dataSource.map((data, index) => (
                  <tr key={`data-table-row-${index}`}>
                    {columns.map((column) => (
                      <td key={column.dataIndex} className="text-black">
                        {column.render ? (
                          (() => {
                            try {
                              return column.render(data[column.dataIndex], index, data);
                            } catch (e) {
                              return <span className="italic text-gray-400">Tidak diketahui</span>;
                            }
                          })()
                        ) : (
                          <>
                            {typeof data[column.dataIndex] === "object" || Array.isArray(data[column.dataIndex])
                              ? JSON.stringify(data[column.dataIndex])
                              : data[column.dataIndex]}
                          </>
                        )}
                      </td>
                    ))}
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>

        <div className="flex justify-end">
          <Pagination pagination={pagination} />
        </div>
      </section>
    </>
  );
}
