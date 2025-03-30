import { Link } from "@inertiajs/react";
import React from "react";
import { PaginationProps } from "@/types/components/TPagination";

export default function Pagination({ pagination }: { pagination: PaginationProps }) {
  const currentPage = Number(pagination.links.find((link) => link.active)?.label || 1);
  const lastPage = Number(pagination.links[pagination.links.length - 2]?.label || 1);

  const renderPages = () => {
    const pages: (number | string)[] = [];

    if (lastPage <= 7) {
      for (let i = 1; i <= lastPage; i++) {
        pages.push(i);
      }
    } else {
      if (currentPage <= 4) {
        pages.push(1, 2, 3, 4, 5, '...', lastPage);
      } else if (currentPage >= lastPage - 3) {
        pages.push(1, '...', lastPage - 4, lastPage - 3, lastPage - 2, lastPage - 1, lastPage);
      } else {
        pages.push(1, '...', currentPage - 1, currentPage, currentPage + 1, '...', lastPage);
      }
    }

    return pages;
  };

  const prevLink = pagination.links.find((l) => l.label.toLowerCase().includes("previous"));
  const nextLink = pagination.links.find((l) => l.label.toLowerCase().includes("next"));

  return (
    <div className="join-forest-green join">
      {/* Previous Button */}
      <Link
        href={prevLink?.url || "#"}
        className={`btn join-item btn-sm ${!prevLink?.url ? "btn-disabled" : ""}`}
        preserveScroll
      >
        {"<"}
      </Link>

      {/* Page Numbers */}
      {renderPages().map((page, index) => {
        if (page === "...") {
          return (
            <span key={`pagination-ellipsis-${index}`} className="btn btn-disabled join-item btn-sm">
              ...
            </span>
          );
        }

        const link = pagination.links.find((l) => l.label == page.toString());

        return (
          <Link
            href={link?.url || "#"}
            key={`pagination-link-${index}`}
            className={`btn join-item btn-sm ${link?.active ? "btn-active" : ""} ${!link?.url ? "btn-disabled" : ""}`}
            preserveScroll
            dangerouslySetInnerHTML={{
              __html: link?.label || page.toString(),
            }}
          />
        );
      })}

      {/* Next Button */}
      <Link
        href={nextLink?.url || "#"}
        className={`btn join-item btn-sm ${!nextLink?.url ? "btn-disabled" : ""}`}
        preserveScroll
      >
        {">"}
      </Link>
    </div>
  );
}
