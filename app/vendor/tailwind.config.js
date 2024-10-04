/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["../views/**/*.{html,php}", "../assets/js/**/*.js", "../woocommerce/**/*.{html,php}", "../includes/**/*.{html,php}"],
  exclude: ["../files/**/*"],
  theme: {
    extend: {},
  },
  plugins: [
    require('tailwindcss-border-image'),
  ],
}

