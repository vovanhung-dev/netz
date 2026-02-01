<template>
  <header id="header" :class=" headerClass ">
    <div class="container">
      <div class="row">
        <div class="overlay-mobile" :class=" { active: menuOpen } " @click="toggleMenu(false)"></div>

        <div class="logo-h">
          <a href="#" class="logo-container">
            <img :src=" logoUrl " class="logo" alt="Netland" />
          </a>
        </div>

        <div class="main-menu-container">

          <div class="toggle-menu-container">
            <span class="t_menu">{{ $t('menu.title') }}</span>
            <button class="toggle-menu" @click="toggleMenu()">
              <span class="line"></span><span class="line"></span><span class="line"></span>
            </button>
          </div>

          <div class="main-menu-wrap" :class=" { open: menuOpen } ">
            <div class="close-btn-mobile" @click="toggleMenu(false)">X</div>
            <a href="#" class="mobile-logo-container">
              <img :src=" logoUrl " class="logo" alt="Netland" />
            </a>
            <ul id="main-menu" class="main-menu" @click="toggleMenu(false)">
              <li :class=" ['menu-item', { 'current-menu-item': isCurrent('/') }] ">
                <router-link to="/">{{ $t('menu.home') }}</router-link>
              </li>

              <li :class=" ['menu-item', { 'current-menu-item': isCurrent('/about-us', { startsWith: true }) }] ">
                <router-link to="/about-us">{{ $t('menu.about') }}</router-link>
              </li>

              <!-- <li :class="['menu-item', { 'current-menu-item': isCurrent('/business-lines', { startsWith: true }) }]">
                <router-link to="/business-lines">{{ $t('menu.business_lines') }}</router-link>
              </li>

              <li :class="['menu-item', { 'current-menu-item': isCurrent('/project', { startsWith: true }) }]">
                <router-link to="/project">{{ $t('menu.project') }}</router-link>
              </li> -->

              <li :class=" ['menu-item', { 'current-menu-item': isCurrent('/courses', { startsWith: true }) }] ">
                <router-link to="/courses">Khóa học</router-link>
              </li>

              <li :class=" ['menu-item', { 'current-menu-item': isCurrent('/news', { startsWith: true }) }] ">
                <router-link to="/news">{{ $t('menu.news') }}</router-link>
              </li>

              <li :class=" ['menu-item', { 'current-menu-item': isCurrent('/careers', { startsWith: true }) }] ">
                <router-link to="/careers">Tuyển dụng</router-link>
              </li>

              <li :class=" ['menu-item', { 'current-menu-item': isCurrent('/contact-us', { startsWith: true }) }] ">
                <router-link to="/contact-us">{{ $t('menu.contact_us') }}</router-link>
              </li>
            </ul>

            <div class="social visible-tab">
              <ul>
                <li class="facebook"><a href="#" target="_blank">{{ $t('facebook') }}</a></li>
                <li class="youtube"><a href="#" target="_blank">{{ $t('youtube') }}</a></li>
              </ul>
            </div>

            <div class="hotline visible-tab">
              <a href="tel:{{ $t('call') }}" class="hotline">
                <small class="icon-phone phonering-alo-ph-img-circle"></small>
                <span>{{ $t('call') }}</span>
              </a>
            </div>

          </div>
        </div>

      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, watch, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const menuOpen = ref(false)
const toggleMenu = (force?: boolean) => {
  menuOpen.value = typeof force === 'boolean' ? force : !menuOpen.value
}

const headerClass = computed(() => ({
  sticky: false,
  open: menuOpen.value,
}))

watch(menuOpen, (v) => {
  if (v) document.body.classList.add('no-scroll')
  else document.body.classList.remove('no-scroll')
})

const router = useRouter()
onMounted(() => {
  router.afterEach(() => {
    menuOpen.value = false
    document.body.classList.remove('no-scroll')
  })
})
const isCurrent = (path: string, { startsWith = false } = {}) => {
  if (startsWith) return router.currentRoute.value.path.startsWith(path)
  return router.currentRoute.value.path === path
}
const logoUrl = new URL('@/assets/images/logo.png', import.meta.url).href
</script>


<!-- <style scoped>
.toggle-menu {
  background: none;
  border: 0;
  width: 36px;
  height: 28px;
  display: grid;
  gap: 6px;
  cursor: pointer;
}

.toggle-menu .line {
  display: block;
  height: 2px;
  background: #000;
}

.main-menu-wrap {
  position: fixed;
  right: -100%;
  top: 0;
  bottom: 0;
  width: 80%;
  max-width: 360px;
  background: #fff;
  padding: 20px;
  transition: right .25s;
  overflow: auto;
}

.main-menu-wrap.open {
  right: 0;
}

@media (min-width: 992px) {
  .main-menu-wrap {
    position: static;
    width: auto;
    max-width: none;
    right: 0;
    display: block;
    padding: 0;
  }

  .toggle-menu-container,
  .close-btn-mobile,
  .overlay-mobile {
    display: none;
  }
}
</style> -->