import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans],
                display: ['"Archivo Black"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: '#111111',
                paper: '#FFFCF2',
                cream: '#FFF1C9',
                pop: {
                    yellow: '#FFD43B',
                    pink: '#FF90B3',
                    cyan: '#7AE7F7',
                    lime: '#B9F27C',
                    purple: '#C3A6FF',
                    orange: '#FFA94D',
                    red: '#FF7A7A',
                },
            },
            boxShadow: {
                nb: '6px 6px 0 0 #111111',
                'nb-sm': '4px 4px 0 0 #111111',
                'nb-lg': '10px 10px 0 0 #111111',
            },
            borderWidth: {
                3: '3px',
            },
        },
    },

    plugins: [forms],
};
