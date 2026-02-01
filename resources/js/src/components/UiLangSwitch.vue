<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { useAppStore } from '../stores/app';
const { locale, t } = useI18n();
const app = useAppStore();

function switchLocale() {
  const next = app.locale === 'vi' ? 'en' : 'vi';
  app.setLocale(next);
  locale.value = next;
}
</script>

<template>
  <button class="c-lang" @click="switchLocale">
    {{ t('app.language') }}: {{ locale.toUpperCase() }}
  </button>
</template>

<style scoped lang="scss">
.c-lang {
  border: 1px solid #ddd;
  border-radius: .5rem;
  padding: .25rem .5rem;
  background: #fff;
  cursor: pointer;
}
</style>
