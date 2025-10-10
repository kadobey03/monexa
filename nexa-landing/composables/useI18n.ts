import tr from '~/locales/tr'
import en from '~/locales/en'

type Locale = 'tr' | 'en'
const messages: Record<Locale, any> = { tr, en }

export const useI18n = () => {
  const locale = useState<Locale>('locale', () => {
    if (process.client) {
      const saved = (localStorage.getItem('locale') as Locale | null)
      if (saved === 'tr' || saved === 'en') return saved
    }
    return 'tr'
  })

  const get = (key: string): any => {
    const parts = key.split('.')
    let obj: any = messages[locale.value]
    for (const p of parts) {
      if (obj && typeof obj === 'object' && p in obj) obj = obj[p]
      else return key
    }
    return obj
  }
  const t = (key: string): string => {
    const v = get(key)
    return typeof v === 'string' ? v : key
  }
  const tm = (key: string): any => get(key)

  const setLocale = (l: Locale) => {
    locale.value = l
    if (process.client) localStorage.setItem('locale', l)
  }

  return { t, tm, locale, setLocale }
}
