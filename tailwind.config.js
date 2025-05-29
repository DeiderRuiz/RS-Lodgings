import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            keyframes: {
                display: {
                  '0%': { transform: 'translateX(200px)', opacity: '0' },
                  '10%': { transform: 'translateX(0)', opacity: '1' },
                  '20%': { transform: 'translateX(0)', opacity: '1' },
                  '30%': { transform: 'translateX(-200px)', opacity: '0' },
                  '100%': { transform: 'translateX(-200px)', opacity: '0' },
                }
              },
              animation: {
                display: 'display 20s infinite',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'bree-serif': ['Bree Serif', 'serif'],
            },
            colors: {
                'gris-antracita': '#293133',
                'gris-marengo': '#5B5D74',
                'gris-perla': '#CDCECf',
                'plata': '#E3E4E5',
                'rojo': '#CC0000',
                'rojo-dark': '#8B0000',
                'crema': '#FDEEC1',
                'crema-dark': '#BDAE81',
                'crema-light': '#FFF9EE',
                'gris-dark': '#5F5F5F',
                'gris-light': '#ABABAB',
                'oro': '#D5BF5C',
            },
        },
    },

    plugins: [
        forms,
        typography,
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('flowbite/plugin'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
