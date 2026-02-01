import { defineStore } from 'pinia';

export const useAppStore = defineStore('app', {
    state: () => ({
        theme: 'light' as 'light' | 'dark',
        locale: 'vi' as 'en' | 'vi',
    }),
    actions: {
        setTheme(theme: 'light' | 'dark') {
            this.theme = theme;
            document.documentElement.dataset.theme = theme;
        },
        setLocale(locale: 'en' | 'vi') {
            this.locale = locale;
        },
    },
    
});
