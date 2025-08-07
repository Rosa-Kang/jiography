/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php', 
    './**/*.php', 
    '!./node_modules/**/*.php', 
    './assets/js/**/*.js',
    './template-parts/**/*.php',
    './inc/**/*.php',
    './page-templates/**/*.php'
  ],
  
  theme: {
    extend: {
      // Colors using CSS variables from SCSS
      colors: {
        primary: {
          light: 'var(--color-primary-light)',
          DEFAULT: 'var(--color-primary)',
          dark: 'var(--color-primary-dark)',
          50: '#f8f9ff',
          100: '#e8eaff',
          200: '#d6dbff',
          300: '#b4c0ff',
          400: '#8c9eff',
          500: 'var(--color-primary)',
          600: 'var(--color-primary)',
          700: '#4338ca',
          800: '#3730a3',
          900: '#312e81',
        },
        secondary: {
          light: 'var(--color-secondary-light)',
          DEFAULT: 'var(--color-secondary)',
          dark: 'var(--color-secondary-dark)',
          50: '#fdf2f8',
          100: '#fce7f3',
          200: '#fbcfe8',
          300: '#f9a8d4',
          400: '#f472b6',
          500: 'var(--color-secondary)',
          600: 'var(--color-secondary-dark)',
          700: '#be185d',
          800: '#9d174d',
          900: '#831843',
        },
        // Using CSS variables for gray colors from SCSS
        neutral: {
          50: 'var(--color-gray-50)',
          100: 'var(--color-gold)',
          200: 'var(--color-gray-200)',
          300: 'var(--color-gray-300)',
          400: 'var(--color-gray-400)',
          500: 'var(--color-gray-500)',
          600: 'var(--color-gray-600)',
          700: 'var(--color-gray-700)',
          800: 'var(--color-gray-800)',
          900: 'var(--color-gray-900)',
        },
        // Gray aliases for convenience
        gray: {
          50: 'var(--color-gray-50)',
          100: 'var(--color-gray-100)',
          200: 'var(--color-gray-200)',
          300: 'var(--color-gray-300)',
          400: 'var(--color-gray-400)',
          500: 'var(--color-gray-500)',
          600: 'var(--color-gray-600)',
          700: 'var(--color-gray-700)',
          800: 'var(--color-gray-800)',
          900: 'var(--color-gray-900)',
        },
        gold: {
          light: 'var(--color-gold-light)',
          DEFAULT: 'var(--color-gold)',
          dark: 'var(--color-gold-dark)',
          50: '#fefdf7',
          100: '#fef9e7',
          200: '#fef3c7',
          300: '#fde68a',
          400: 'var(--color-gold-light)',
          500: 'var(--color-gold)',
          600: 'var(--color-gold-dark)',
          700: '#b45309',
          800: '#92400e',
          900: '#78350f',
        },
        // Direct CSS variable mappings
        white: 'var(--color-white)',
        black: 'var(--color-black)',
      },
      
      // Custom fonts using CSS variables
      fontFamily: {
        'sans': ['Inter', 'system-ui', 'sans-serif'],
        'primary': ['var(--font-primary)'],
        'body': ['var(--font-body)'],
        'mono': ['JetBrains Mono', 'monospace'],
        'display': ['Playfair Display', 'Georgia', 'serif'],
        'cursive': ['Dancing Script', 'cursive'],
      },
      
      // Font sizes using CSS variables
      fontSize: {
        '2xs': 'var(--font-size-2xs)',
        'xs': 'var(--font-size-xs)',
        'sm': 'var(--font-size-sm)', 
        'base': 'var(--font-size-base)',
        'lg': 'var(--font-size-lg)',
        'xl': 'var(--font-size-xl)',
        '2xl': 'var(--font-size-2xl)',
        '3xl': 'var(--font-size-3xl)',
        '4xl': 'var(--font-size-4xl)',
        '5xl': 'var(--font-size-5xl)',
        '6xl': 'var(--font-size-6xl)',
      },
      

      
      // Box shadows - 핵심적인 것만
      boxShadow: {
        DEFAULT: 'var(--shadow)',
        'lg': 'var(--shadow-lg)',
        // Photography specific shadows
        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
        'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 30px -5px rgba(0, 0, 0, 0.05)',
      },
      
      // Animation durations - 핵심적인 것만
      transitionDuration: {
        '200': 'var(--duration-200)',
        '300': 'var(--duration-300)',
        '500': 'var(--duration-500)',
      },
      
      // Photography-specific aspect ratios
      aspectRatio: {
        'photo': '3/2',
        'portrait': '2/3',
        'square': '1/1',
        'wide': '16/9',
        'ultra-wide': '21/9'
      },
      
      // Custom spacing
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem',
        '144': '36rem'
      },
      
      // Custom animations - 핵심적인 것만
      animation: {
        'fade-in': 'fadeIn 0.6s ease-in-out',
        'fade-in-up': 'fadeInUp 0.6s ease-out',
      },
      
      // Custom keyframes - 핵심적인 것만
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' }
        },
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(30px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' }
        }
      },
      
      // Custom screens (breakpoints)
      screens: {
        'xs': '475px',
        '3xl': '1600px'
      }
    },
    
    // Override default container configuration to match your usage patterns
    container: {
      center: true,
      padding: 'var(--container-padding-xs)', // Default px-4 like your usage
      screens: {
        sm: 'var(--container-max-width-sm)',    // 640px
        md: 'var(--container-max-width-md)',    // 860px  
        lg: 'var(--container-max-width-lg)',    // 1024px
        xl: 'var(--container-max-width-xl)',    // 1200px
        '2xl': 'var(--container-max-width-2xl)' // 1400px
      }
    }
  },
  
  plugins: [
    require('@tailwindcss/forms')({
      strategy: 'class' // Use class strategy to avoid conflicts
    }),
    require('@tailwindcss/typography')({
      className: 'prose'
    }),
    require('@tailwindcss/aspect-ratio'),
    
    // Custom plugin for photography-specific utilities and container variants
    function({ addUtilities, addComponents, theme, addBase }) {
      // Add container variants - based on your current usage patterns
      addComponents({
        // Replace your: container lg:max-w-[640px] mx-auto px-4
        '.container-sm': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          maxWidth: 'var(--container-max-width-sm)', // 640px
        },
        
        // Replace your: container lg:max-w-[860px] mx-auto px-4  
        '.container-md': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          maxWidth: 'var(--container-max-width-md)', // 860px
        },
        
        // Replace your: container lg:max-w-[1024px] mx-auto px-4 py-6
        '.container-lg': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          maxWidth: 'var(--container-max-width-lg)', // 1024px
        },
        
        // Standard XL container
        '.container-xl': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          maxWidth: 'var(--container-max-width-xl)', // 1280px
        },
        
        // Replace your: container lg:max-w-[1400px] mx-auto
        '.container-2xl': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          maxWidth: 'var(--container-max-width-2xl)', // 1400px
        },
        
        // Extra large container for full-width sections
        '.container-3xl': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          maxWidth: 'var(--container-max-width-3xl)', // 1600px
        },
        
        // Utility containers with different padding
        '.container-lg-padded': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          paddingTop: 'var(--container-padding-sm)', // py-6 equivalent
          paddingBottom: 'var(--container-padding-sm)',
          maxWidth: 'var(--container-max-width-lg)', // 1024px
        },
        
        '.container-2xl-padded': {
          width: '100%',
          marginLeft: 'auto',
          marginRight: 'auto',
          paddingLeft: 'var(--container-padding-xs)', // px-4
          paddingRight: 'var(--container-padding-xs)',
          paddingTop: 'var(--container-padding-sm)', // py-6 equivalent
          paddingBottom: 'var(--container-padding-sm)',
          maxWidth: 'var(--container-max-width-2xl)', // 1400px
        }
      });
      
      const newUtilities = {
        // Image overlay utilities
        '.image-overlay': {
          position: 'relative',
          '&::before': {
            content: '""',
            position: 'absolute',
            top: '0',
            left: '0',
            right: '0',
            bottom: '0',
            backgroundColor: 'rgba(0, 0, 0, 0.4)',
            transition: 'opacity 0.3s ease',
            zIndex: '1'
          }
        },
        '.image-overlay-hover': {
          '&:hover::before': {
            opacity: '0'
          }
        }
      }
      
      addUtilities(newUtilities)
    }
  ]
}