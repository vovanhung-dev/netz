<template>
  <main class="netland-home">
    <HeroCarousel />
    <AboutSection />
    <DevelopmentStats />
    <ProjectsGrid />
    <NewsSection />
    <PartnersCarousel />
  </main>
</template>

<script setup lang="ts">
import HeroCarousel from '../../components/HeroCarousel.vue'
import AboutSection from '../../components/AboutSection.vue'
import DevelopmentStats from '../../components/DevelopmentStats.vue'
import ProjectsGrid from '../../components/ProjectsGrid.vue'
import NewsSection from '../../components/NewsSection.vue'
import PartnersCarousel from '../../components/PartnersCarousel.vue'
</script>

<style scoped>
.netland-home {
  display: block;
}
</style>
