const colors = require('tailwindcss/colors');

const gray = {
    50: 'blue',
    100: 'var(--active-text-color)',
    200: 'var(--text-color)',
    300: 'var(--text-color)',
    400: 'var(--text-color)',
    500: 'var(--text-color)',
    600: 'var(--theme-secondary-bg)',
    700: 'var(--second-background)',
    800: 'var(--main-background)',
    900: 'var(--second-background)',
};

module.exports = {
    content: [
        './resources/scripts/**/*.{js,ts,tsx}',
    ],
    theme: {
        extend: {
            fontFamily: {
                header: ['"IBM Plex Sans"', '"Roboto"', 'system-ui', 'sans-serif'],
            },
            colors: {
                black: '#131a20',
                // "primary" and "neutral" are deprecated, prefer the use of "blue" and "gray"
                // in new code.
                primary: colors.blue,
                gray: gray,
                neutral: gray,
                cyan: colors.cyan,
            },
            fontSize: {
                '2xs': '0.625rem',
            },
            transitionDuration: {
                250: '250ms',
            },
            borderColor: theme => ({
                default: theme('colors.neutral.400', 'currentColor'),
            }),
        },
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/forms')({
            strategy: 'class',
        }),
    ]
};