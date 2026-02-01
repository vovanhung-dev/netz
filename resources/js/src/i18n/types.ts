export const SUPPORT_LOCALES = ['vi', 'en'] as const;

export type Locales = typeof SUPPORT_LOCALES[number];