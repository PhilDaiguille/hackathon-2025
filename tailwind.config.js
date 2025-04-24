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
        tertiery1: '#f7f4f1',
        tertiery2: '#473A1F',
        ctaSurvol: '#EADDD1',
        cta: '#BC946F',
        fondGrey: '#1F1F1F',
        fondGrey2: '#6B7479',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
