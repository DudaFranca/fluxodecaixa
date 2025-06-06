/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}',
    './node_modules/flowbite/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        blue: '#255267',
        blueBackground: '#CBE1EE',
        greenLightBorder: '#A6CCC0',
        greenBackground: '#F2F7F5',
        greenLightBackground: '#D0F1E7',
      },
    },
    container: {
      center: true,
      padding: {
        DEFAULT: '1rem',
        sm: '2rem',
        lg: '4rem',
        xl: '5rem',
        '2xl': '6rem',
      },
    },
  },
  plugins: [require('flowbite/plugin')],
};
