export default function Hero({ pageName }: { pageName: string }) {
  return (
    <div className="flex w-full flex-col">
      <div
        className="section-padding-x relative grid w-full place-items-center overflow-hidden bg-cover bg-fixed bg-top bg-no-repeat py-64 before:absolute before:left-0 before:top-0 before:z-20 before:h-full before:w-full before:bg-black before:opacity-20 before:content-[''] sm:bg-center sm:py-16"
        style={{ backgroundImage: `url("/assets/images/beranda-bg.png")` }}
      >
        <div className="z-30 flex w-full flex-col items-center gap-3 text-white">
          <h2 className="w-full text-center text-6xl font-bold leading-[5rem] sm:text-4xl">{pageName}</h2>
        </div>
      </div>
    </div>
  );
}
