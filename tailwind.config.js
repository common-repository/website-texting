import('tailwindcss').Config
module.exports = {
  content: ['./public/**/*.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        'brand-blue': '#1d9ad6', //connectsms blue
        'brand-dark-blue': '#2A9AD6',
        'brand-light-blue': '#B5DEF1',
        'brand-orange': '#F89928',
        'brand-dark-orange': '#EE7600',
        'brand-red': '#F32729',
      }
    },
  },
  plugins: [],
}
