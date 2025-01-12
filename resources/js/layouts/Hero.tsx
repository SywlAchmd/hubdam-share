export default function Hero({
  pageName,
  bgImage,
  uppercase = false,
}: {
  pageName: string;
  bgImage: string;
  uppercase?: boolean;
}) {
  return (
    <div className="flex w-full flex-col">
      <div
        className="relative grid w-full overflow-hidden bg-cover bg-top bg-no-repeat py-72 before:absolute before:left-0 before:top-0 before:z-20 before:h-full before:w-full before:bg-black before:opacity-20 before:content-[''] sm:bg-center sm:py-16"
        style={{ backgroundImage: `url("/assets/images/${bgImage}")` }}
      >
        {/* pagename container */}
        <div className="absolute bottom-0 left-1/2 z-40 flex w-4/5 -translate-x-1/2 transform justify-center bg-white py-10 sm:py-3">
          <h2 className={`${uppercase ? "uppercase" : ""} section-title text-5xl font-bold sm:text-2xl`}>{pageName}</h2>
        </div>

        {/* bg container */}
        <div className="absolute bottom-0 z-30 w-full bg-white py-4 sm:py-1">
          <div className="flex justify-center bg-white py-5"></div>
        </div>
      </div>
    </div>
  );
}
