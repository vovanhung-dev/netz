<script setup lang="ts">
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import SiteHeader from '../src/components/Header.vue';
import SiteFooter from '../src/components/FooterSection.vue';

const route = useRoute();
const showPublicChrome = computed(() => !route.path.startsWith('/admin'));
</script>

<template>
  <div id="app" class="site">
    <!-- <SiteHeader v-if="showPublicChrome" /> -->
    <RouterView />
    <!-- <SiteFooter v-if="showPublicChrome" /> -->
  </div>
</template>
