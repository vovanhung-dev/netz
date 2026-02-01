<template>
    <section id="home" class="section slider-top">
      <Swiper
        :modules="modules"
        :slides-per-view="1"
        :loop="canLoop"
        effect="fade"
        :speed="100"
        :autoplay="autoplayOpt"
        :allow-touch-move="allowTouchMove"
        :watch-overflow="true"
        @afterInit="onAfterInit"
        @slideChange="onSlideChange"
      >
        <SwiperSlide v-for="(slide, i) in slides" :key="i">
          <div class="owl-slide d-flex align-items-center cover" :style="bgStyle(slide.bg)">
            <div class="container"><div class="row">
              <div class="hero__text">
                <h3 class="head-bn">Netland</h3>
                <h2 class="project-name" v-html="slide.title" />
                <p class="desp-proj">{{ slide.desc }}</p>
                <p class="view-proj"><a href="#about" class="primary-btn">View more</a></p>
              </div>
            </div></div>
          </div>
        </SwiperSlide>
      </Swiper>
  
      <div class="slideState">
        <div class="num-slide">
          <div v-for="(slide, i) in slides" :key="i" :class="{ active: i === activeIndex }" @click="goTo(i)">
            <span>{{ (i+1).toString().padStart(2, '0') }}</span>
          </div>
        </div>
      </div>
    </section>
  </template>

  <script setup lang="ts">
  import { ref, computed } from 'vue'
  import { Swiper, SwiperSlide } from 'swiper/vue'
  import { EffectFade, Autoplay } from 'swiper/modules'

const modules = [EffectFade, Autoplay]
const activeIndex = ref(0)
let swiperRef: any = null

const slidesData = [
  { bg: new URL('@/assets/netland/Netland - Homepage_files/Welltone3.png', import.meta.url).href,
    title: 'Trust Creates Value – <br/>Quality Builds the Brand',
    desc: 'For over a decade, Netland has cemented its position...'
  },
  { bg: new URL('@/assets/netland/Netland - Homepage_files/Welltone3.png', import.meta.url).href,
    title: 'Trust Creates Value – <br/>Quality Builds the Brand',
    desc: 'For over a decade, Netland has cemented its position...'
  },
  { bg: new URL('@/assets/netland/Netland - Homepage_files/Welltone3.png', import.meta.url).href,
    title: 'Trust Creates Value – <br/>Quality Builds the Brand',
    desc: 'For over a decade, Netland has cemented its position...'
  },
  { bg: new URL('@/assets/netland/Netland - Homepage_files/Welltone3.png', import.meta.url).href,
    title: 'Trust Creates Value – <br/>Quality Builds the Brand',
    desc: 'For over a decade, Netland has cemented its position...'
  }
]

// ✅ chỉ loop/autoplay khi có >1 slide
const canLoop = computed(() => slidesData.length > 1)
const autoplayOpt = computed(() => canLoop.value ? { delay: 3000, disableOnInteraction: false } : false)
const allowTouchMove = computed(() => slidesData.length > 1)

const onAfterInit = (sw: any) => { swiperRef = sw; activeIndex.value = sw.realIndex }
const onSlideChange = (sw: any) => { activeIndex.value = sw.realIndex }
const goTo = (i: number) => swiperRef?.slideToLoop?.(i, 0)

const slides = [
    {
      bg: slidesData[0].bg,
      title: slidesData[0].title,
      desc: slidesData[0].desc
    },
    {
      bg: slidesData[1].bg,
      title: slidesData[1].title,
      desc: slidesData[1].desc
    },
    {
      bg: slidesData[2].bg,
      title: slidesData[2].title,
      desc: slidesData[2].desc
    },
    {
      bg: slidesData[3].bg,
      title: slidesData[3].title,
      desc: slidesData[3].desc
    }
  ]
  const bgStyle = (url: string) => ({ backgroundImage: `url(${url})` })
  </script>
  
  <style scoped>
  .cover { min-height: clamp(420px, 70vh, 720px); background-size: cover; background-position: center; display: flex; align-items: center; }
  .slideState { position: absolute; bottom: 16px; left: 16px; }
  .num-slide { display: flex; gap: 12px; }
  .num-slide div { cursor: pointer; opacity: .5; transition: .2s; }
  .num-slide div.active { opacity: 1; font-weight: 700; }
  </style>
  