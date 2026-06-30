import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-brand-50', 'bg-brand-100', 'bg-brand-200', 'bg-brand-300',
        'bg-brand-400', 'bg-brand-500', 'bg-brand-600', 'bg-brand-700',
        'bg-brand-800', 'bg-brand-900',
        'text-brand-50', 'text-brand-100', 'text-brand-200', 'text-brand-300',
        'text-brand-400', 'text-brand-500', 'text-brand-600', 'text-brand-700',
        'text-brand-800', 'text-brand-900',
        'border-brand-50', 'border-brand-100', 'border-brand-200', 'border-brand-300',
        'border-brand-400', 'border-brand-500', 'border-brand-600', 'border-brand-700',
        'border-brand-800', 'border-brand-900',
        'from-brand-50', 'via-brand-50', 'to-brand-50',
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

