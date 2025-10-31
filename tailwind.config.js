const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.vue',
    './resources/js/**/*.js',
    './themes/**/*.blade.php',
    './themes/**/*.js',
    './themes/**/*.vue',
  ],

  darkMode: 'class', // Enable dark mode with class strategy
  
  // Enable JIT mode for Tailwind CSS v3+
  mode: 'jit',
  
  // Future flags for upcoming features
  future: {
    hoverOnlyWhenSupported: true,
    respectDefaultRingColorOpacity: true,
  },

  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'Nunito', ...defaultTheme.fontFamily.sans],
      },
      
      // Design Token System
      colors: {
        // Base Design Tokens
        base: {
          // Neutral palette for UI structure
          white: '#ffffff',
          gray: {
            50: '#fafafa',
            100: '#f4f4f5',
            200: '#e4e4e7',
            300: '#d4d4d8',
            400: '#a1a1aa',
            500: '#71717a',
            600: '#52525b',
            700: '#3f3f46',
            800: '#27272a',
            900: '#18181b',
            950: '#09090b',
          }
        },
        
        // Brand Design Tokens
        brand: {
          primary: {
            50: '#eff6ff',
            100: '#dbeafe',
            200: '#bfdbfe',
            300: '#93c5fd',
            400: '#60a5fa',
            500: '#3b82f6',
            600: '#2563eb',
            700: '#1d4ed8',
            800: '#1e40af',
            900: '#1e3a8a',
            950: '#172554',
          },
          secondary: {
            50: '#f8fafc',
            100: '#f1f5f9',
            200: '#e2e8f0',
            300: '#cbd5e1',
            400: '#94a3b8',
            500: '#64748b',
            600: '#475569',
            700: '#334155',
            800: '#1e293b',
            900: '#0f172a',
            950: '#020617',
          }
        },
        
        // Semantic Design Tokens
        semantic: {
          success: {
            50: '#ecfdf5',
            100: '#d1fae5',
            200: '#a7f3d0',
            300: '#6ee7b7',
            400: '#34d399',
            500: '#10b981',
            600: '#059669',
            700: '#047857',
            800: '#065f46',
            900: '#064e3b',
          },
          warning: {
            50: '#fffbeb',
            100: '#fef3c7',
            200: '#fde68a',
            300: '#fcd34d',
            400: '#fbbf24',
            500: '#f59e0b',
            600: '#d97706',
            700: '#b45309',
            800: '#92400e',
            900: '#78350f',
          },
          danger: {
            50: '#fef2f2',
            100: '#fee2e2',
            200: '#fecaca',
            300: '#fca5a5',
            400: '#f87171',
            500: '#ef4444',
            600: '#dc2626',
            700: '#b91c1c',
            800: '#991b1b',
            900: '#7f1d1d',
          },
          info: {
            50: '#eff6ff',
            100: '#dbeafe',
            200: '#bfdbfe',
            300: '#93c5fd',
            400: '#60a5fa',
            500: '#3b82f6',
            600: '#2563eb',
            700: '#1d4ed8',
            800: '#1e40af',
            900: '#1e3a8a',
          }
        },
        
        // Status colors for leads
        status: {
          new: '#3b82f6',        // blue
          contacted: '#f59e0b',  // yellow
          qualified: '#10b981',  // green
          proposal: '#8b5cf6',   // purple
          negotiation: '#f97316', // orange
          won: '#059669',        // emerald
          lost: '#dc2626',       // red
          nurturing: '#6366f1',  // indigo
        },
        
        // Priority colors
        priority: {
          low: '#6b7280',        // gray
          medium: '#f59e0b',     // yellow
          high: '#f97316',       // orange
          urgent: '#dc2626',     // red
        },
        
        // Legacy support - mapped to design tokens
        admin: {
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#1e293b',
          900: '#0f172a',
        },
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        }
      },
      
      // Design Token Spacing System
      spacing: {
        // Base spacing scale (4px base)
        'xs': '0.25rem',    // 4px
        'sm': '0.5rem',     // 8px
        'md': '0.75rem',    // 12px
        'lg': '1rem',       // 16px
        'xl': '1.5rem',     // 24px
        '2xl': '2rem',      // 32px
        '3xl': '3rem',      // 48px
        '4xl': '4rem',      // 64px
        '5xl': '6rem',      // 96px
        '6xl': '8rem',      // 128px
        
        // Extended spacing
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem',
      },
      
      // Typography Design Tokens
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1' }],
        '6xl': ['3.75rem', { lineHeight: '1' }],
        '7xl': ['4.5rem', { lineHeight: '1' }],
        '8xl': ['6rem', { lineHeight: '1' }],
        '9xl': ['8rem', { lineHeight: '1' }],
      },
      
      // Border Radius Design Tokens
      borderRadius: {
        'none': '0',
        'sm': '0.125rem',
        'md': '0.375rem',
        'lg': '0.5rem',
        'xl': '0.75rem',
        '2xl': '1rem',
        '3xl': '1.5rem',
        '4xl': '2rem',
        'full': '9999px',
      },
      
      // Shadow Design Tokens
      boxShadow: {
        'xs': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
        'sm': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
        'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
        'lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
        'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
        'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
        'strong': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
        'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
        'none': 'none',
      },
      
      // Height/Width Design Tokens
      height: {
        'xs': '1rem',
        'sm': '1.5rem',
        'md': '2rem',
        'lg': '2.5rem',
        'xl': '3rem',
        '2xl': '3.5rem',
        '3xl': '4rem',
        '128': '32rem',
      },
      
      maxHeight: {
        '128': '32rem',
      },
      
      // Animation Design Tokens
      animation: {
        'fade-in': 'fadeIn 0.3s ease-out',
        'fade-out': 'fadeOut 0.5s ease-in-out',
        'slide-in': 'slideIn 0.3s ease-out',
        'slide-out': 'slideOut 0.3s ease-out',
        'bounce-light': 'bounceLight 1s infinite',
        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'scale-in': 'scaleIn 0.2s ease-out',
      },
      
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        fadeOut: {
          '0%': { opacity: '1', transform: 'translateY(0)' },
          '100%': { opacity: '0', transform: 'translateY(-10px)' },
        },
        slideIn: {
          '0%': { opacity: '0', transform: 'translateX(100%)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideOut: {
          '0%': { opacity: '1', transform: 'translateX(0)' },
          '100%': { opacity: '0', transform: 'translateX(100%)' },
        },
        slideUp: {
          '0%': { opacity: '0', transform: 'translateY(10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideDown: {
          '0%': { opacity: '0', transform: 'translateY(-10px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        scaleIn: {
          '0%': { opacity: '0', transform: 'scale(0.95)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        bounceLight: {
          '0%, 100%': { transform: 'translateY(-5%)', opacity: '0.8' },
          '50%': { transform: 'translateY(0)', opacity: '1' },
        }
      },
      
      // Backdrop Design Tokens
      backdropBlur: {
        'xs': '2px',
      },
      
      // Border Radius Design Tokens (already above, but keeping for consistency)
      borderRadius: {
        'none': '0',
        'sm': '0.125rem',
        'md': '0.375rem',
        'lg': '0.5rem',
        'xl': '0.75rem',
        '2xl': '1rem',
        '3xl': '1.5rem',
        '4xl': '2rem',
        'full': '9999px',
      },
      
      // Z-Index Design Tokens
      zIndex: {
        '10': '10',
        '20': '20',
        '30': '30',
        '40': '40',
        '50': '50',
        '60': '60',
        '70': '70',
        '80': '80',
        '90': '90',
        '100': '100',
      },
      
      // Screen Size Design Tokens
      screens: {
        'xs': '475px',
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
        '3xl': '1600px',
        '4xl': '1920px',
      },
      
      // Container queries support
      containers: {
        xs: '20rem',
        sm: '24rem',
        md: '28rem',
        lg: '32rem',
        xl: '36rem',
        '2xl': '42rem',
        '3xl': '48rem',
        '4xl': '56rem',
        '5xl': '64rem',
        '6xl': '72rem',
        '7xl': '80rem',
      },
    },
  },

  plugins: [
    require('@tailwindcss/forms')({
      strategy: 'class', // Use class strategy to avoid conflicts
    }),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/container-queries'),
    
    // Custom plugin for table utilities
    function({ addUtilities, theme }) {
      const newUtilities = {
        '.table-compact': {
          '& th, & td': {
            padding: theme('spacing.2') + ' ' + theme('spacing.4'),
            fontSize: theme('fontSize.sm'),
            lineHeight: theme('lineHeight.4'),
          },
        },
        '.table-comfortable': {
          '& th, & td': {
            padding: theme('spacing.3') + ' ' + theme('spacing.6'),
            fontSize: theme('fontSize.sm'),
            lineHeight: theme('lineHeight.5'),
          },
        },
        '.table-spacious': {
          '& th, & td': {
            padding: theme('spacing.4') + ' ' + theme('spacing.8'),
            fontSize: theme('fontSize.base'),
            lineHeight: theme('lineHeight.6'),
          },
        },
        '.scrollbar-thin': {
          '&::-webkit-scrollbar': {
            width: '6px',
          },
          '&::-webkit-scrollbar-track': {
            backgroundColor: theme('colors.gray.100'),
          },
          '&::-webkit-scrollbar-thumb': {
            backgroundColor: theme('colors.gray.400'),
            borderRadius: theme('borderRadius.full'),
          },
          '&::-webkit-scrollbar-thumb:hover': {
            backgroundColor: theme('colors.gray.500'),
          },
        },
        '.scrollbar-none': {
          '-ms-overflow-style': 'none',
          'scrollbar-width': 'none',
          '&::-webkit-scrollbar': {
            display: 'none',
          },
        },
        '.glass': {
          backgroundColor: 'rgba(255, 255, 255, 0.8)',
          backdropFilter: 'blur(10px)',
          WebkitBackdropFilter: 'blur(10px)',
          border: '1px solid rgba(255, 255, 255, 0.2)',
        },
        '.glass-dark': {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          backdropFilter: 'blur(10px)',
          WebkitBackdropFilter: 'blur(10px)',
          border: '1px solid rgba(255, 255, 255, 0.1)',
        },
      }
      
      addUtilities(newUtilities)
    },
    
    // Custom plugin for status indicators
    function({ addComponents, theme }) {
      const statusComponents = {
        '.status-badge': {
          display: 'inline-flex',
          alignItems: 'center',
          padding: theme('spacing.1') + ' ' + theme('spacing.2'),
          borderRadius: theme('borderRadius.full'),
          fontSize: theme('fontSize.xs'),
          fontWeight: theme('fontWeight.medium'),
          textTransform: 'capitalize',
        },
        '.status-new': {
          backgroundColor: theme('colors.blue.100'),
          color: theme('colors.blue.800'),
        },
        '.status-contacted': {
          backgroundColor: theme('colors.yellow.100'),
          color: theme('colors.yellow.800'),
        },
        '.status-qualified': {
          backgroundColor: theme('colors.green.100'),
          color: theme('colors.green.800'),
        },
        '.status-proposal': {
          backgroundColor: theme('colors.purple.100'),
          color: theme('colors.purple.800'),
        },
        '.status-negotiation': {
          backgroundColor: theme('colors.orange.100'),
          color: theme('colors.orange.800'),
        },
        '.status-won': {
          backgroundColor: theme('colors.emerald.100'),
          color: theme('colors.emerald.800'),
        },
        '.status-lost': {
          backgroundColor: theme('colors.red.100'),
          color: theme('colors.red.800'),
        },
        '.status-nurturing': {
          backgroundColor: theme('colors.indigo.100'),
          color: theme('colors.indigo.800'),
        },
        '.dark .status-new': {
          backgroundColor: theme('colors.blue.900') + '33',
          color: theme('colors.blue.400'),
        },
        '.dark .status-contacted': {
          backgroundColor: theme('colors.yellow.900') + '33',
          color: theme('colors.yellow.400'),
        },
        '.dark .status-qualified': {
          backgroundColor: theme('colors.green.900') + '33',
          color: theme('colors.green.400'),
        },
        '.dark .status-proposal': {
          backgroundColor: theme('colors.purple.900') + '33',
          color: theme('colors.purple.400'),
        },
        '.dark .status-negotiation': {
          backgroundColor: theme('colors.orange.900') + '33',
          color: theme('colors.orange.400'),
        },
        '.dark .status-won': {
          backgroundColor: theme('colors.emerald.900') + '33',
          color: theme('colors.emerald.400'),
        },
        '.dark .status-lost': {
          backgroundColor: theme('colors.red.900') + '33',
          color: theme('colors.red.400'),
        },
        '.dark .status-nurturing': {
          backgroundColor: theme('colors.indigo.900') + '33',
          color: theme('colors.indigo.400'),
        },
      }
      
      addComponents(statusComponents)
    }
  ],
}