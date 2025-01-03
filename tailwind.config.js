import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
import daisyui from "daisyui";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.tsx",
    "./resources/views/**/*.blade.php",
    "./app/Filament/**/*.php",
    "./resources/views/filament/**/*.blade.php",
    "./vendor/filament/**/*.blade.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Figtree", ...defaultTheme.fontFamily.sans],
        poppins: ["Poppins", "sans-serif"],
      },
      colors: {
        "forest-green": "#5C6124",
        "forest-green-dark": "#494D1C",
        "light-gray": "#D9D9D9",
        "olive-gray": "#797A6D",
      },
    },
    screens: {
      lg: { min: "835px", max: "1040px" },
      md: { min: "526px", max: "834px" },
      sm: { max: "525px" },
      // tablet to 1040px
      mdlg: { min: "526px", max: "1040px" },
      // phone to 1040px
      smdlg: { max: "1040px" },
      // phone to tablet
      smd: { max: "834px" },
    },
  },

  plugins: [forms, typography, daisyui],
};
