import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                blueTheme: {
                    light: '#ebf8ff',  // Light blue
                    DEFAULT: '#4299e1', // Primary blue
                    dark: '#2b6cb0',    // Dark blue
                    accent: '#63b3ed',  // Accent blue
                },
            },
        },
    },

    plugins: [forms],
};
