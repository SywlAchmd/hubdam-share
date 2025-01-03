import InputError from "@/components/atoms/InputError";
import PrimaryButton from "@/components/atoms/PrimaryButton";
import FormInput from "@/components/molecules/FormInput";
import { Head, useForm, usePage } from "@inertiajs/react";
import { FormEventHandler, useEffect, useState } from "react";
import { toast } from "sonner";

export default function Profile() {
  const { flash, auth, baseUrl } = usePage().props;

  const [preview, setPreview] = useState(
    auth.user?.image ? `${baseUrl}/storage/${auth.user.image}` : "/assets/images/default_avatar.jpg",
  );

  useEffect(() => {
    return () => {
      if (preview) URL.revokeObjectURL(preview);
    };
  }, [preview]);

  useEffect(() => {
    if (flash.success) {
      toast.success(flash.success);
    }
    if (flash.error) {
      toast.error(flash.error);
    }
  }, [flash]);

  const { data, setData, post, reset, processing, errors } = useForm({
    name: auth.user?.name ?? "",
    username: auth.user?.username ?? "",
    email: auth.user?.email ?? "",
    staff: auth.user?.staff ?? "",
    image: auth.user?.image ?? null,
    password: "",
    password_confirmation: "",
  });

  const handleSubmit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route("profile.update"), {
      preserveScroll: true,
      onSuccess: () => {
        reset("password", "password_confirmation");
      },
    });
  };

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files?.[0]) {
      const file = e.target.files[0];

      if (!["image/jpeg", "image/png", "image/jpg"].includes(file.type)) {
        toast.error("Only JPG, PNG, or JPEG files are allowed.");
        return;
      }

      if (file.size > 2 * 1024 * 1024) {
        toast.error("File tidak boleh lebih dari 2 MB.");
        setData("image", null);
        setPreview("/assets/images/default_avatar.jpg");
        return;
      }

      setData("image", file);
      const previewUrl = URL.createObjectURL(file);
      setPreview(previewUrl);
    }
  };

  return (
    <section className="single-section-padding flex min-h-screen gap-10">
      <Head title="Profile" />

      {/* Profile picture */}
      <section className="section-bg w-1/4 overflow-hidden">
        <section className="bg-slate-200 p-3 font-medium text-olive-gray">Foto Profil</section>
        <section className="flex flex-col items-center gap-4 p-10 text-xs">
          <img
            src={preview}
            alt="user_image"
            className="aspect-square w-32 cursor-pointer overflow-hidden rounded-full"
          />

          <p>File tidak boleh lebih dari 2 MB</p>
          <input id="image-upload" type="file" className="hidden" onChange={handleImageChange} />

          <InputError message={errors?.image} />
        </section>

        <section className="flex w-full justify-center pb-8">
          <PrimaryButton className="text-sm" onClick={() => document.getElementById("image-upload")?.click()}>
            Upload gambar
          </PrimaryButton>
        </section>
      </section>

      {/* Account details */}
      <section className="section-bg w-3/4 overflow-hidden">
        <section className="bg-slate-200 p-3 font-medium text-olive-gray">Detail Akun</section>

        <form className="flex flex-col gap-4 p-5" onSubmit={handleSubmit}>
          <FormInput
            label="Name"
            value={data.name}
            onChange={(e) => setData("name", e.target.value)}
            error={errors?.name}
            placeholder="Masukan nama anda"
          />

          <FormInput
            label="Username"
            value={data.username}
            onChange={(e) => setData("username", e.target.value)}
            error={errors?.username}
            placeholder="Masukan username anda"
          />

          <FormInput
            label="Email"
            value={data.email}
            onChange={(e) => setData("email", e.target.value)}
            error={errors?.email}
            placeholder="Masukan email anda"
          />

          <FormInput
            label="Staff"
            value={data.staff}
            onChange={(e) => setData("staff", e.target.value)}
            error={errors?.staff}
            disabled
          />

          <FormInput
            label="Password"
            value={data.password}
            onChange={(e) => setData("password", e.target.value)}
            error={errors?.password}
            placeholder="Masukkan password baru"
            type="password"
          />

          {data.password && (
            <FormInput
              label="Confirm Password"
              value={data.password_confirmation}
              onChange={(e) => setData("password_confirmation", e.target.value)}
              placeholder="Konfirmasi password"
              type="password"
            />
          )}

          <section className="flex justify-end">
            <PrimaryButton className="text-sm" disabled={processing}>
              Simpan
            </PrimaryButton>
          </section>
        </form>
      </section>
    </section>
  );
}
