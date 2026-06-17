import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#fff1e8',
                    100: '#ffe3d3',
                    200: '#ffc8ab',
                    300: '#ffa67b',
                    400: '#f78351',
                    500: '#f4b08a', // Brand primary (peach)
                    600: '#e39a72', // Brand primary dark
                    700: '#bd724b',
                    800: '#945131',
                    900: '#5c2d18',
                }
            }
        },
    },

    plugins: [forms],
};

