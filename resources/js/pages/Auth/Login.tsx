import InputError from "@/components/atoms/InputError";
import InputLabel from "@/components/atoms/InputLabel";
import PrimaryButton from "@/components/atoms/PrimaryButton";
import TextInput from "@/components/atoms/TextInput";

import { Head, useForm } from "@inertiajs/react";
import { FormEventHandler, useState } from "react";
import { FaUser, FaLock, FaEye, FaEyeSlash } from "react-icons/fa";

export default function Login({ status }: { status?: string }) {
  const basePath = "/hubdamshare";
  const [showPassword, setShowPassword] = useState(false);

  const { data, setData, post, processing, errors, reset } = useForm({
    identifier: "",
    password: "",
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route("login"), {
      onFinish: () => reset("password"),
    });
  };

  return (
    <section className="flex h-screen w-full p-24 sm:p-0 mdlg:p-10">
      <Head title="Log in" />

      {/* image */}
      <section className="flex w-full overflow-hidden rounded-2xl bg-white shadow-2xl">
        <section className="h-auto w-1/2 smdlg:hidden">
          <img src={`${basePath}/assets/images/login-bg.png`} alt="login-bg" className="h-full w-full object-cover" />
        </section>

        <section className="flex w-1/2 flex-col items-center justify-center smdlg:w-full">
          <section className="rounded-xl p-10 smdlg:bg-white">
            <h2 className="py-7 text-center text-4xl font-bold text-forest-green sm:text-3xl">
              Selamat Datang Prajurit!
            </h2>

            <form onSubmit={submit} className="flex flex-col gap-4">
              {status && <div className="mb-4 text-sm font-medium text-green-600">{status}</div>}
              <section>
                <InputLabel htmlFor="identifier" value="Username / Email" />

                <div className="mt-1 flex items-center gap-2 rounded-md border-2 border-solid border-light-gray bg-white px-5 py-3">
                  <FaUser size={20} fill="gray" />
                  <TextInput
                    id="identifier"
                    type="text"
                    name="identifier"
                    placeholder="Username atau Email"
                    value={data.identifier}
                    className="w-full border-none text-black placeholder-gray-400 outline-none focus:ring-transparent sm:text-sm"
                    autoComplete="username"
                    isFocused={true}
                    onChange={(e) => setData("identifier", e.target.value)}
                  />
                </div>

                <InputError message={errors.identifier} className="mt-2" />
              </section>

              <section>
                <InputLabel htmlFor="password" value="Password" />

                <div className="mt-1 flex items-center gap-2 rounded-md border-2 border-solid border-light-gray bg-white px-5 py-3">
                  <FaLock size={20} fill="gray" />
                  <TextInput
                    id="password"
                    type={showPassword ? "text" : "password"}
                    name="password"
                    placeholder="Masukan Password"
                    value={data.password}
                    className="w-full border-none text-black placeholder-gray-400 outline-none focus:ring-transparent sm:text-sm"
                    autoComplete="current-password"
                    onChange={(e) => setData("password", e.target.value)}
                  />

                  <button type="button" onClick={() => setShowPassword((prev) => !prev)} className="focus:outline-none">
                    {showPassword ? <FaEyeSlash size={18} /> : <FaEye size={18} />}
                  </button>
                </div>

                <InputError message={errors.password} className="mt-2" />
              </section>

              <section className="text-xs text-olive-gray">
                <p>Belum memiliki akun?</p>
                <p>Hubungi Admin untuk dibuatkan akun.</p>
              </section>

              <section className="w-full text-center">
                <PrimaryButton disabled={processing} className="w-1/3 justify-center py-3 text-sm">
                  Log in
                </PrimaryButton>
              </section>
            </form>
          </section>
        </section>
      </section>
    </section>
  );
}
