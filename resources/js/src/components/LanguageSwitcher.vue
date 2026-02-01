<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import { Locales, SUPPORT_LOCALES } from '../i18n/types'

const props = defineProps<{
  isSticky: boolean
}>()

const { locale } = useI18n()

const setLocale = (newLocale: Locales) => {
  if (!SUPPORT_LOCALES.includes(newLocale)) return
  locale.value = newLocale
  localStorage.setItem('locale', newLocale)
}
</script>

<template>
  <div class="language-switcher">
    <ul>
      <li :class="{ active: $i18n.locale === 'vi' }">
        <a href="#" @click.prevent="setLocale('vi')" :class="{ 'dark-text': props.isSticky }">VI</a>
      </li>
      <li :class="{ active: $i18n.locale === 'en' }">
        <a href="#" @click.prevent="setLocale('en')" :class="{ 'dark-text': props.isSticky }">EN</a>
      </li>
    </ul>
  </div>
</template>

<style scoped>
.language-switcher {
  display: block;
}

ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  align-items: center;
  /* gap: 0.75rem; */
}

li a {
  text-decoration: none;
  font-weight: 500;
  text-transform: uppercase;
  font-size: 1.1rem;
  opacity: 0.7;
  color: #000;
  transition: all 0.4s ease;
  padding: 0 0.75rem;
}

/* li+li {
  border-left: 1px solid currentColor;
} */

li a.dark-text {
  color: #000;
}

li.active a {
  font-weight: 700;
  opacity: 1;
  color: #dd1d26 !important;
}
</style>