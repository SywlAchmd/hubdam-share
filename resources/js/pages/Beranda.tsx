import { HeroHome } from "@/layouts";
import VisiMisiCard from "@/components/pages/VisiMisiCard";
import { TBerandaProps } from "@/types/components/TBeranda";
import { Head } from "@inertiajs/react";

export default function Beranda({ vision, mission }: TBerandaProps) {
  return (
    <>
      <Head title="Beranda" />
      <HeroHome pageName="Beranda" />
      <section className="single-section-padding-y flex w-full items-center justify-between sm:justify-center">
        <span className="h-[50px] w-1/5 bg-white sm:hidden" />

        <h2 className="section-title">Visi & Misi</h2>

        <span className="h-[50px] w-1/5 bg-white sm:hidden" />
      </section>

      <section className="section-padding-x relative flex flex-col items-center gap-10 pb-16 sm:pb-10">
        {/* Background Container */}
        <div className="absolute inset-0 left-0 top-1/2 z-0 w-full -translate-y-1/2 bg-forest-green" />

        {/* Cards */}
        <div className="relative z-10 flex w-full flex-col gap-10">
          <VisiMisiCard text={vision?.content} />
          <VisiMisiCard text={mission?.content} />
        </div>
      </section>
    </>
  );
}
