const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.css',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            flex : {
              '5':  '1 0 100%'
            },
            fontFamily: {
                'sans': ['Poppins', 'sans-serif']
            },
            cursor: {
                revert: 'revert'
            },
            zIndex: {
                behind: '-1'
            },
            height: {
                '128': '32rem',
                '192': '48rem',
                '70vh': '70vh'
            },
            width: {
                '24ch': '24ch',
                '32ch': '32ch',
                '40ch': '40ch',
                '50ch': '50ch',
                '80vw': '80vw'
            },
            minWidth: {
                'full': '100%'
            },
            minHeight: {
                'full': '100%'
            },
            minHeight: {
                'full': '100%'
            },
            colors: {
                primary: '#32678f',
                secondary: '#58b12c',
                'secondary-alt': '#72c02c',
                'blue': {
                    DEFAULT: '#2b84ef',
                    light: '#4090f1',
                    dark: '#1A2940'
                },
                'green': {
                    DEFAULT: '#32ba83',
                    light: '#47C190'
                },
                'gray': {
                    DEFAULT: '#394a5d',
                    light: '#F2F4F6'
                },
                'purple': {
                    DEFAULT: '#070774',
                },
                // Agenda linked
                'yellow': {
                    DEFAULT: '#f1c40f',
                },
                'pink': {
                    DEFAULT: '#ff38a5',
                },
                'orange': {
                    DEFAULT: '#ff851b',
                },
                'red': {
                    DEFAULT: '#dd4b39',
                },
            },   
        },
    },
    variants: {
        extend: {
            width: ['hover','focus','responsive'],
            display: ['responsive', 'hover', 'focus', 'group-hover'],
        },
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
        require('tailwindcss-children'),
    ],
}
