import { createI18n } from 'vue-i18n';
import en from './en.json';
import vi from './vi.json';

import { SUPPORT_LOCALES, type Locales } from './types';

function detectBrowserLocale(): Locales {
  try {
    const saved = (localStorage.getItem('locale') || '').trim();
    if (saved && (SUPPORT_LOCALES as readonly string[]).includes(saved)) {
      return saved as Locales;
    }

    const langs: string[] = Array.from(
      new Set([...(navigator.languages || []), navigator.language || ''])
    ).filter(Boolean) as string[];

    for (const lang of langs) {
      const lower = lang.toLowerCase();
      if (lower.startsWith('vi')) return 'vi';
      if (lower.startsWith('en')) return 'en';
    }
  } catch {
  }

  return 'vi';
}

export default createI18n({
    legacy: false,
    locale: detectBrowserLocale(),
    fallbackLocale: 'en',
    messages: { en, vi },
});
