<script setup lang="ts">
const slides = [
  {
    id: 1,
    image: 'https://skyloveacademy.edu.vn/uploads/images/banner-trang-chu-38487745.jpg',
    subtitleKey: 'hero.subtitle',
    titleKey: 'hero.title',
    descKey: 'hero.desc',
    ctaKey: 'hero.cta',
  },
]
</script>

<template>
  <section class="hero">
    <div v-for="s in slides" :key="s.id" class="hero__slide" :style="{ '--bg': `url('${s.image}')` }">
      <div class="hero__overlay">
        <div class="hero__content">
          <h3 class="head-bn">{{ $t(s.subtitleKey) }}</h3>
          <h1 class="hero__title" v-html="$t(s.titleKey)" />
          <p class="hero__desc">{{ $t(s.descKey) }}</p>
          <p class="view-proj">
            <a href="#about" class="primary-btn">{{ $t('hero.cta') }}</a>
          </p>
        </div>
        <div class="slideState">
          <div class="num-slide">
            <div class="active"><span>01</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  position: relative;
  width: 100%;
  overflow: hidden;
}

.hero__slide {
  min-height: 100vh;
  background-image: var(--bg);
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  height: 100vh;
}

.hero__overlay {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
}

.hero__content {
  max-width: 1100px;
  margin: 0 10vw;
  padding: 3rem 1.25rem;
  color: #fff;
}

.hero__subtitle {
  font-size: 1rem;
  letter-spacing: .2em;
  text-transform: uppercase;
  opacity: .9;
}

.hero__title {
  font-size: clamp(2rem, 4vw, 2.5rem);
  line-height: 1.15;
  margin: .5rem 0 1rem;
  font-weight: 700;
}

.hero__desc {
  font-size: 1.05rem;
  max-width: 60ch;
  opacity: .95;
}

/* .hero__cta { display: inline-block; margin-top: 1.25rem; padding: .75rem 1.25rem; border-radius: .5rem; background: #00a76f; color: #fff; text-decoration: none; font-weight: 600; }
.hero__cta:hover { opacity: .9; } */
</style>
