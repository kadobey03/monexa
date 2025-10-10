import type { Config } from 'tailwindcss'

export default <Partial<Config>>{
  darkMode: 'class',
  content: [
    './app.vue',
    './components/**/*.{vue,js,ts}',
    './layouts/**/*.vue',
    './pages/**/*.vue',
    './plugins/**/*.{js,ts}',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#10B981',
          dark: '#059669',
          light: '#D1FAE5'
        },
        ink: '#0b1320',
        surface: '#0b1b16'
      },
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui']
      },
      boxShadow: {
        card: '0 10px 25px -10px rgba(24, 39, 75, 0.12)',
      },
      keyframes: {
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(12px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' }
        },
        float: {
          '0%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-4px)' },
          '100%': { transform: 'translateY(0)' }
        },
        pulseGlow: {
          '0%, 100%': { boxShadow: '0 0 0 0 rgba(16,185,129,0.35)' },
          '50%': { boxShadow: '0 0 0 12px rgba(16,185,129,0.0)' }
        },
        ticker: {
          '0%': { transform: 'translateX(0)' },
          '100%': { transform: 'translateX(-50%)' }
        }
      },
      animation: {
        ticker: 'ticker 40s linear infinite',
        'fade-in-up': 'fadeInUp .6s ease-out both',
        float: 'float 4s ease-in-out infinite',
        'pulse-glow': 'pulseGlow 2.4s ease-out infinite'
      }
    }
  },
  plugins: []
}
