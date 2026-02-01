<template>
  <SiteHeader />
  <RouterView />
  <SiteFooter />
</template>

<script setup>
import SiteHeader from '../components/Header.vue';
import SiteFooter from '../components/FooterSection.vue';
</script>
