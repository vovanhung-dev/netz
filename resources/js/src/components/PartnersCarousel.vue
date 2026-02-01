<template>
    <section class="section section-partner animatedParent">
      <div class="container">
        <div class="row">
          <div class="w-head-proj">
            <h2 class="title-left animated fadeInLeftShort delay-250">{{ $t('partner.title') }}</h2>
          </div>
          <div class="clearfix"></div>
  
          <div class="w-partner animated fadeInUpShort delay-500">
            <ul class="nav nav-tabs justify-content-end" role="tablist">
              <li class="nav-item"><a class="nav-link" :class="{ active: tab==='sp' }" @click.prevent="tab='sp'">{{ $t('partner.tab1') }}</a></li>
              <li class="nav-item"><a class="nav-link" :class="{ active: tab==='bank' }" @click.prevent="tab='bank'">{{ $t('partner.tab2') }}</a></li>
            </ul>
  
            <div class="tab-content">
              <div class="tab-pane" :class="{ show: tab==='sp', active: tab==='sp' }">
                <Swiper class="partner-slide" :modules="modules" :slides-per-view="getSlidesPerView()" :spaceBetween="50" :loop="true" :autoplay="{ delay: 2500 }" :breakpoints="breakpoints">
                  <SwiperSlide v-for="(img, i) in strategic" :key="i">
                    <div class="item height_cus"><img :src="img" class="img-responsive" alt="{{ $t('partner.tab1') }}" /></div>
                  </SwiperSlide>
                </Swiper>
              </div>
  
              <div class="tab-pane" :class="{ show: tab==='bank', active: tab==='bank' }">
                <Swiper class="partner-slide" :modules="modules" :slides-per-view="getSlidesPerView()" :spaceBetween="50" :loop="true" :autoplay="{ delay: 2500 }" :breakpoints="breakpoints">
                  <SwiperSlide v-for="(img, i) in bank" :key="i">
                    <div class="item height_cus"><img :src="img" class="img-responsive" alt="{{ $t('partner.tab2') }}" /></div>
                  </SwiperSlide>
                </Swiper>
              </div>
            </div>
  
            <div class="clearfix"></div>
          </div>
  
        </div>
      </div>
    </section>
  </template>
  
  <script setup lang="ts">
  import { ref } from 'vue'
  import { Swiper, SwiperSlide } from 'swiper/vue'
  import { Autoplay } from 'swiper/modules'
  import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
  useAnimateOnScroll()
  
  const modules = [Autoplay]
  const tab = ref<'sp' | 'bank'>('sp')
  
  const strategic = [
    new URL('@/assets/images/Danh-Khoi-Holdings.png', import.meta.url).href,
    new URL('@/assets/images/dkra-group.png', import.meta.url).href,
    new URL('@/assets/images/Apave.svg', import.meta.url).href,
    new URL('@/assets/images/DnD.svg', import.meta.url).href,
    new URL('@/assets/images/Kien-Vang-01.png', import.meta.url).href,
    new URL('@/assets/images/Logo-Phat-Dat-scaled.png', import.meta.url).href,
    new URL('@/assets/images/The-Son.svg', import.meta.url).href,
    new URL('@/assets/images/PHUC-KHANG.png', import.meta.url).href,
  ]
  
  const bank = [
    new URL('@/assets/images/BIDV-LOGO.jpg', import.meta.url).href,
    new URL('@/assets/images/Hd-Bank-01.png', import.meta.url).href,
    new URL('@/assets/images/Logo-Pvcombank.png', import.meta.url).href,
    new URL('@/assets/images/NCB-LOGO.png', import.meta.url).href,
  ]
  
  const breakpoints = {
    0: { slidesPerView: 2 },
    576: { slidesPerView: 3 },
    768: { slidesPerView: 4 },
    992: { slidesPerView: 5 }
  }
  function getSlidesPerView() { return 5 }
  </script>
  
  <style scoped>
  .nav-tabs { display:flex; gap:16px; }
  .nav-link { cursor:pointer; padding:8px 12px; border-bottom:2px solid transparent; }
  .nav-link.active { border-color:#000; font-weight:700; }
  .height_cus { height:80px; display:flex; align-items:center; justify-content:center; }
  </style>
  

   <!-- <script setup lang="ts">
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Navigation } from 'swiper/modules'
import { ref, computed } from 'vue'

const tab = ref<'sp'|'bank'>('sp')
const modules = [Autoplay, Navigation]

const strategic = [
  'Danh-Khoi-Holdings.png','dkra-group.png','Apave.svg','DnD.svg',
  'Kien-Vang-01.png','Logo-Phat-Dat-scaled.png','The-Son.svg','PHUC-KHANG.png',
].map(n => new URL(`../assets/images/${n}`, import.meta.url).href)

const bank = [
  'BIDV-LOGO.jpg','Hd-Bank-01.png','Logo-Pvcombank.png','NCB-LOGO.png',
].map(n => new URL(`../assets/images/${n}`, import.meta.url).href)

const list = computed(() => tab.value==='sp' ? strategic : bank)
const breakpoints = {
  320:{slidesPerView:2,spaceBetween:12},
  576:{slidesPerView:3,spaceBetween:14},
  768:{slidesPerView:4,spaceBetween:16},
  992:{slidesPerView:5,spaceBetween:18},
  1200:{slidesPerView:6,spaceBetween:20}
}
const canLoop = computed(() => list.value.length > 6)
</script>

<template>
  <section class="section section-partner">
    <div class="container">
      <div class="w-head-proj">
        <h2 class="title-left">Partner</h2>
      </div>

      <div class="w-partner">
        <ul class="nav nav-tabs justify-content-end" role="tablist">
          <li class="nav-item">
            <a class="nav-link" :class="{ active: tab==='sp' }" href="#" @click.prevent="tab='sp'">Strategic Partnership</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" :class="{ active: tab==='bank' }" href="#" @click.prevent="tab='bank'">Bank Partner</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane" :class="{ show: tab==='sp', active: tab==='sp' }">
            <Swiper class="partner-slide" :modules="modules" :loop="canLoop" :autoplay="{delay:2200}" :navigation="true" :breakpoints="breakpoints">
              <SwiperSlide v-for="(src,i) in list" :key="i">
                <div class="logo-wrap"><img :src="src" :alt="`Logo ${i+1}`" /></div>
              </SwiperSlide>
            </Swiper>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.logo-wrap{height:72px;display:flex;align-items:center;justify-content:center;padding:8px;border:1px solid rgba(0,0,0,.06);border-radius:8px;background:#fff}
.logo-wrap img{max-height:60px;width:auto}
.nav-link.active{font-weight:700}
</style> -->
