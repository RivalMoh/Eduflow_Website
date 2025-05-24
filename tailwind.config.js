/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'sans-serif'],
            },
            colors: {
                primary: {
                    DEFAULT: '#4F46E5',
                    '50': '#EEF2FF',
                    '100': '#E0E7FF',
                    '200': '#C7D2FE',
                    '300': '#A5B4FC',
                    '400': '#818CF8',
                    '500': '#6366F1',
                    '600': '#4F46E5',
                    '700': '#4338CA',
                    '800': '#3730A3',
                    '900': '#312E81',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
    darkMode: 'class',
}