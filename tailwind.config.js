/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.php"],
  theme: {
    extend: {
      colors: {
        primary: "#00AC66",
        light: "#F5F3EF",
        background: "#FAF9F7",
        dark: "#292929",
        muted: "#A6A6A6",
        available: "#6DC5A1",
        unavailable: "#C56D6D",
      },
      fontFamily: {
        display: ['"Playfair Display"', "serif"],
        body: ["Inter", "sans-serif"],
      },
      boxShadow: {
        card: "0 4px 24px 0 rgba(0, 0, 0, 0.01)",
      },
    },
  },
  plugins: [],
};
