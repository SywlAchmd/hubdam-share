import { User } from "@/types";
import { getStaffDisplayName } from "@/utils/staffOptions";

export default function CardName({ name, staff, image }: User) {
  return (
    <section className="w-fit rounded-md bg-white p-2 shadow-xl">
      <img
        alt={name}
        src={image ? "/hubdamshare/storage/" + image : "/hubdamshare/assets/images/default_avatar.jpg"}
        className="aspect-square h-auto max-w-[250px] object-cover shadow-md smdlg:w-full"
      />

      <section className="py-4 text-center text-lg sm:text-xs mdlg:text-base">
        <p className="font-semibold text-forest-green">{name}</p>
        <p>{getStaffDisplayName(staff ?? "")}</p>
      </section>
    </section>
  );
}

