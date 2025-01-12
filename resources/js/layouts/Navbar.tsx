import { useState } from "react";
import { navLinksId } from "@/constants/layouts/NavbarConstants";
import { Link, usePage } from "@inertiajs/react";
import { TNavLinksItem, TNavLinksChildren } from "@/types/layouts/TNavLinks";
import { FaChevronDown } from "react-icons/fa";
import { RiUserSettingsLine, RiLogoutBoxRLine } from "react-icons/ri";

export default function Navbar() {
  const { appName, auth } = usePage().props;

  const baseUrl = window.location.origin;
  const currentPathname = window.location.pathname;
  const [navLinks, setNavLinks] = useState(navLinksId.map((item) => item));
  const [isDropdownOpened, setIsDropdownOpened] = useState(false);
  const [isHamburgerClicked, setIsHamburgerClicked] = useState(false);
  const [isProfileDropdownOpened, setIsProfileDropdownOpened] = useState(false);

  /**
   * @description handle open/close dropdown menu
   */
  const handleDropdown = (id: string) => {
    const updatedLinks = navLinks.map((link) => {
      if (link.id === id) {
        setIsDropdownOpened(!link.isOpen);
        return { ...link, isOpen: !link.isOpen };
      } else return { ...link, isOpen: false };
    });
    setNavLinks(updatedLinks);
  };

  const handleClickOutsideDropdown = () => {
    const updatedLinks = navLinks.map((link) => {
      return { ...link, isOpen: false };
    });
    setNavLinks(updatedLinks);
    setIsDropdownOpened(false);
    setIsHamburgerClicked(false);
    setIsProfileDropdownOpened(false);
  };

  /**
   * @description handle when user clicks hamburger menu
   */
  const handleHamburgerMenuClick = () => {
    setIsHamburgerClicked(!isHamburgerClicked);
    setIsDropdownOpened(!isDropdownOpened);
  };

  /**
   * @description handle open/close profile dropdown
   */
  const handleProfileClick = () => {
    setIsProfileDropdownOpened(!isProfileDropdownOpened);
  };

  const handleProfileLinkClick = () => {
    setIsProfileDropdownOpened(false);
  };

  return (
    <nav className="sticky top-0 z-50 flex h-[85px] w-full flex-col text-forest-green">
      <div className="flex h-full w-full items-center justify-center bg-white px-8 py-2">
        <section
          onClick={handleClickOutsideDropdown}
          className={`${isDropdownOpened || isProfileDropdownOpened ? "" : "hidden"} absolute left-0 right-0 top-0 mt-[82px] h-screen w-full bg-[#0F164925]`}
        ></section>

        <section className="flex w-full items-center justify-between">
          {/* logo */}
          <Link href="/" className="flex items-center gap-5 smdlg:hidden">
            <img src="/assets/images/logo2.png" alt="logo1" width={80} className="-mr-4" />
            <h2 className="font-extrabold italic text-forest-green">{appName}</h2>
            <img src="/assets/images/logo.png" alt="logo2" width={60} />
          </Link>

          {/* Hamburger Button on < 1024px */}
          <section className="hidden cursor-pointer flex-col gap-1 smdlg:flex" onClick={handleHamburgerMenuClick}>
            <span
              className={`${isHamburgerClicked ? "origin-center translate-y-[7px] rotate-45" : ""} h-[3px] w-5 rounded bg-black`}
            ></span>
            <span className={`${isHamburgerClicked ? "opacity-0" : ""} h-[3px] w-5 rounded bg-black`}></span>
            <span
              className={`${isHamburgerClicked ? "origin-center -translate-y-[7px] -rotate-45" : ""} h-[3px] w-5 rounded bg-black`}
            ></span>
          </section>

          {/* Links on > 1024px */}
          <section className="relative flex gap-6 smdlg:hidden">
            {navLinks.map(({ id, path, isOpen, children }: TNavLinksItem, index: number) => {
              return children.length === 0 && !Array.isArray(path) ? (
                <Link
                  key={index}
                  href={path}
                  onClick={handleClickOutsideDropdown}
                  className={`${currentPathname === path ? "font-bold" : ""} capitalize hover:font-bold`}
                >
                  <p>{id}</p>
                </Link>
              ) : (
                <section
                  key={index}
                  onClick={() => handleDropdown(id)}
                  className={`${path.includes(currentPathname) ? "font-bold" : ""} flex cursor-pointer items-center gap-1 capitalize hover:font-bold`}
                >
                  <p>{id}</p>
                  <FaChevronDown className={`${isOpen && "rotate-180"} aspect-square h-3`} />

                  <section
                    className={`${isOpen ? "" : "hidden"} absolute top-0 mt-[45px] flex min-w-full flex-col divide-y divide-solid divide-opacity-50 overflow-hidden rounded-lg border-2 border-solid border-light-gray bg-white leading-5`}
                  >
                    {children.map(({ id, path }: TNavLinksChildren, index: number) => {
                      return (
                        <Link
                          key={`children-${index}`}
                          href={path}
                          className={`${currentPathname === path ? "bg-forest-green font-bold text-white" : "font-light"} flex w-full items-center justify-between gap-10 px-8 py-3 hover:bg-forest-green hover:font-bold hover:text-white`}
                        >
                          <p>{id}</p>
                        </Link>
                      );
                    })}
                  </section>
                </section>
              );
            })}
          </section>

          {/* profile */}
          <section>
            <img
              src={`${auth.user.image ? `${baseUrl}/storage/${auth.user.image}` : "/assets/images/default_avatar.jpg"}`}
              alt="user_image"
              className="aspect-square w-12 cursor-pointer overflow-hidden rounded-full"
              onClick={handleProfileClick}
            />
            <section
              className={`${isProfileDropdownOpened ? "" : "hidden"} absolute right-0 mt-2 w-32 divide-y divide-solid divide-neutral-600 divide-opacity-25 overflow-hidden rounded-lg border-2 border-solid border-light-gray bg-white shadow-md`}
            >
              <Link
                href={route("profile.edit")}
                className="flex items-center gap-2 px-4 py-2 text-sm hover:font-bold"
                onClick={handleProfileLinkClick}
              >
                <RiUserSettingsLine />
                <p>Profil</p>
              </Link>

              <Link
                method="post"
                href={route("logout")}
                className="flex items-center gap-2 px-4 py-2 text-sm hover:font-bold"
                onClick={handleProfileLinkClick}
              >
                <RiLogoutBoxRLine />
                <p>Logout</p>
              </Link>
            </section>
          </section>

          {/* Hamburger Menu Dropdown */}
          <section
            onClick={handleClickOutsideDropdown}
            className={`${isHamburgerClicked ? "opacity-1" : "translate-x-[-100%] opacity-0"} absolute left-0 right-0 top-0 z-10 mt-[66px] h-screen w-full duration-200`}
          ></section>
          <section
            className={`${isHamburgerClicked ? "opacity-1" : "translate-x-[-100%] opacity-0"} absolute left-0 right-0 top-0 z-20 mt-[82px] w-full divide-y divide-solid divide-light-gray divide-opacity-25 bg-white duration-200`}
          >
            {navLinks.map(({ id, path, isOpen, children }: TNavLinksItem, index: number) => {
              return children.length === 0 && !Array.isArray(path) ? (
                <Link
                  key={index}
                  href={path}
                  onClick={handleClickOutsideDropdown}
                  className={`${currentPathname === path ? "bg-forest-green font-bold text-white" : ""} flex h-full cursor-pointer items-center justify-between gap-2 px-6 py-3 text-sm capitalize hover:bg-forest-green hover:font-bold hover:text-white`}
                >
                  <p>{id}</p>
                </Link>
              ) : (
                <section className="flex flex-col" key={index}>
                  <section
                    onClick={() => handleDropdown(id)}
                    className={`${path.includes(currentPathname) ? "bg-forest-green font-bold text-white" : ""} ${isOpen ? "shadow-md" : ""} relative flex h-full cursor-pointer items-center justify-between gap-2 px-6 py-4 capitalize hover:bg-forest-green hover:font-bold hover:text-white`}
                  >
                    <h5 className="text-sm">{id}</h5>
                    <FaChevronDown className={`${isOpen && "rotate-180"} aspect-square h-3`} />
                  </section>

                  <section
                    className={`${isOpen ? "" : "hidden"} left-0 top-0 flex min-w-full flex-col divide-y divide-solid divide-neutral-600 divide-opacity-25 leading-4`}
                  >
                    {children.map(({ id, path }: TNavLinksChildren, index: number) => {
                      return (
                        <Link
                          key={`children-${index}`}
                          href={path}
                          className={`${currentPathname === path ? "bg-forest-green-dark font-bold text-white" : "bg-slate-200"} flex w-full items-center justify-between gap-10 px-10 py-4 text-sm capitalize hover:bg-forest-green-dark hover:font-bold hover:text-white`}
                        >
                          <p>{id}</p>
                        </Link>
                      );
                    })}
                  </section>
                </section>
              );
            })}
          </section>
        </section>
      </div>
    </nav>
  );
}
