/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["../views/**/*.{html,php}", "../assets/js/**/*.js"],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwindcss-border-image'),
  ],
}

