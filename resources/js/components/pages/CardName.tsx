import { User } from "@/types";
import { getAssetUrl, getStorageUrl } from "@/utils/pathHelper";
import { getStaffDisplayName } from "@/utils/staffOptions";

export default function CardName({ name, staff, image }: User) {
  return (
    <section className="max-w-[250px] rounded-md p-2 shadow-xl">
      <img
        alt={name}
        src={typeof image === "string" ? getStorageUrl(image) : getAssetUrl("images/default_avatar.jpg")}
        className="aspect-square h-auto w-full object-cover shadow-md"
      />

      <section className="flex h-[120px] flex-col justify-center py-4 text-center text-lg sm:gap-1 sm:text-xs mdlg:text-base">
        <p className="font-semibold text-forest-green">{name}</p>
        <p>{getStaffDisplayName(staff ?? "")}</p>
      </section>
    </section>
  );
}
