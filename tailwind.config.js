/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Filament/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                bg: { DEFAULT: '#0A0A0A', alt: '#111111', card: '#161616' },
                accent: { DEFAULT: '#E8FF47', dark: '#c8df2a' },
                border: '#222222',
            },
            fontFamily: {
                heading: ['Syne', 'sans-serif'],
                body:    ['Inter', 'sans-serif'],
            },
        },
    },
    plugins: [],
};
