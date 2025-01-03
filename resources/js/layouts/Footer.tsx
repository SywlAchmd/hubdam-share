import { FaFacebook, FaInstagram } from "react-icons/fa";
import { MdLocationOn } from "react-icons/md";

export default function Footer() {
  return (
    <footer className="section-padding-x single-section-padding-y flex w-full flex-col gap-8 bg-forest-green text-white">
      <section className="flex justify-between smdlg:flex-col smdlg:gap-10">
        <section className="flex flex-col gap-3">
          <h4 className="text-2xl font-black italic text-white">HUBDAM XIV / HASANUDDIN</h4>
          <section className="flex gap-2">
            <a
              title="social media"
              target="_blank"
              href={"https://web.facebook.com/pemdes.tritiro"}
              className="rounded-full bg-white p-1"
            >
              <FaFacebook size={30} color="black" />
            </a>

            <a
              title="social media"
              target="_blank"
              href={"https://www.instagram.com/tritirodesawisata/"}
              className="rounded-full bg-white p-1"
            >
              <FaInstagram size={30} color="black" />
            </a>
          </section>
        </section>

        <section className="flex max-w-[500px] items-center gap-2">
          <MdLocationOn size={60} color="white" />
          <p>Jl. Opu Daeng Risadju No.420, Baji Mappakasunggu, Kec. Mamajang, Kota Makassar, Sulawesi Selatan 90121</p>
        </section>
      </section>

      {/* line */}
      <hr />

      <span className="text-center">© Hubdam XIV/Hasanuddin</span>
    </footer>
  );
}
