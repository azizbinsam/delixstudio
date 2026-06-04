import defaultTheme from 'tailwindcss/defaultTheme'

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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Bebas Neue', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                background: '#010101',
                foreground: '#FFFFFF',
                'soft-white': '#FBFBFD',
                'light-gray': '#EEEFF2',
                'dark-gray': '#272835',
                border: 'rgba(255,255,255,0.10)',
                muted: {
                    DEFAULT: '#1A1A1A',
                    foreground: '#6B7280',
                },
                card: {
                    DEFAULT: '#0D0D0D',
                    foreground: '#FFFFFF',
                },
                secondary: {
                    DEFAULT: '#1A1A1A',
                    foreground: '#FFFFFF',
                },
                primary: {
                    DEFAULT: '#FFFFFF',
                    foreground: '#010101',
                },
                destructive: {
                    DEFAULT: '#ef4444',
                    foreground: '#FFFFFF',
                },
                accent: {
                    DEFAULT: '#1A1A1A',
                    foreground: '#FFFFFF',
                },
            },
            borderRadius: {
                lg: '0.75rem',
                md: '0.5rem',
                sm: '0.375rem',
            },
        },
    },
    plugins: [],
}