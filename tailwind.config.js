/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
    "./templates/components/*.html.twig"

  ],
  theme: {
    extend: {
      colors: {
        primary: '#eadcd1',
        secondary: '#f1e8d5',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
