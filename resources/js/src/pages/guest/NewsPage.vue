<script setup lang="ts">
import { ref, onMounted, onUnmounted, nextTick, computed } from 'vue'
import VPagination from '@hennge/vue3-pagination'
import '@hennge/vue3-pagination/dist/vue3-pagination.css'

import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
import useJqueryPlugins from '@/composables/useJqueryPlugins'
import http from '@/api/http'

useAnimateOnScroll()
const { initFancybox, initMatchHeight, initNiceScroll, destroyAll } = useJqueryPlugins()

/** Sticky header (anchors) */
const isScrollNavi = ref(false)
const stickyOffset = 0
const anchorsSectionEl = ref<HTMLElement | null>(null)
let ticking = false
function computeScrollNavi() {
  if (!anchorsSectionEl.value) return
  const sectionTop = anchorsSectionEl.value.offsetTop - stickyOffset
  isScrollNavi.value = window.scrollY >= sectionTop
}
function onScrollOrResize() {
  if (!ticking) {
    ticking = true
    requestAnimationFrame(() => {
      computeScrollNavi()
      ticking = false
    })
  }
}

/** Banner */
const bannerUrl = 'https://netland.com.vn/wp-content/uploads/2025/09/khu-vui-choi-sasuke.jpg'

/** News list */
type BigNews = { href: string; title: string; img: string; dateSpan: string; dateTail: string; excerpt?: string }
const bigNews = ref<BigNews[]>([])

function mapToBigNews(row: any): BigNews {
  // Backend row: { title, slug, cover_image_url, published_at, excerpt }
  const d = row?.published_at ? new Date(row.published_at) : null
  const day = d ? String(d.getDate()).padStart(2, '0') : ''
  const month = d ? String(d.getMonth() + 1).padStart(2, '0') : ''
  const year = d ? d.getFullYear() : ''
  return {
    href: `/news/${ row.slug }`,
    title: row.title ?? '',
    img: row.cover_image_url ?? '',
    dateSpan: day,
    dateTail: `${ month } - ${ year }`,
    excerpt: row.excerpt ?? '',
  }
}

/** Pagination */
const page = ref(1)
const perPage = ref(8)
const total = ref(0)
const lastPage = ref(1)
const loading = ref(false)
const errorMsg = ref('')

const pageCount = ref(1)

async function loadNews() {
  loading.value = true
  errorMsg.value = ''
  try {
    const { data } = await http.get('/api/news', {
      params: { page: page.value, per_page: perPage.value },
    })
    const list = Array.isArray(data?.data) ? data.data : (Array.isArray(data) ? data : [])
    bigNews.value = list.map(mapToBigNews)
    const last = data?.last_page ?? data?.news?.last_page ?? 1
    pageCount.value = last || 1
    if (data?.meta) {
      total.value = data.meta.total ?? list.length
      lastPage.value = data.meta.last_page ?? 1
      page.value = data.meta.current_page ?? page.value

    }
  } catch (e: any) {
    errorMsg.value = e?.message || 'Load news failed.'
    bigNews.value = []
  } finally {
    loading.value = false
  }
}

function onPage(newPage: number) {
  if (newPage === page.value) return
  page.value = newPage
  loadNews()
  // scroll mượt về section tin
  window.scrollTo({ top: anchorsSectionEl.value?.offsetTop ?? 0, behavior: 'smooth' })
}

/** jQuery legacy (nếu có) */
function initLegacy() {
  const w = window as any
  const $ = w.jQuery || w.$
  if (!$) return
  try { $('[data-fancybox]').fancybox?.({ toolbar: false, smallBtn: true, iframe: { preload: false } }) } catch { }
  try { $('.w-chinhsach').niceScroll?.() } catch { }
  try { $('.height_cus').matchHeight?.() } catch { }
}

/** Lifecycle */
onMounted(async () => {
  document.body.classList.add('site', 'page', 'news')
  try { initFancybox() } catch { }
  try { initMatchHeight('.height_cus') } catch { }
  try { initNiceScroll('.w-chinhsach') } catch { }

  await loadNews()
  await nextTick()
  requestAnimationFrame(initLegacy)

  window.addEventListener('scroll', onScrollOrResize, { passive: true })
  window.addEventListener('resize', onScrollOrResize)
  computeScrollNavi()

  // phím tắt ← →
  window.addEventListener('keydown', (e: KeyboardEvent) => {
    if (e.key === 'ArrowRight' && page.value < lastPage.value) onPage(page.value + 1)
    if (e.key === 'ArrowLeft' && page.value > 1) onPage(page.value - 1)
  })
})

onUnmounted(() => {
  document.body.classList.remove('site', 'page', 'news')
  try { destroyAll() } catch { }
  window.removeEventListener('scroll', onScrollOrResize)
  window.removeEventListener('resize', onScrollOrResize)
})
</script>

<template>
  <div id="fullpage">
    <!-- Banner -->
    <div class="section banner-page">
      <div class="p-news bannner-t" :style=" `background: url(${ bannerUrl }) center top / cover no-repeat` ">
        <div class="breadcrumb-b">
          <div class="container">
            <div class="row">
              <div class="br-dl">
                <span class="home-breadc">Home</span>
                <span class="breadcrumb-2">Tin tức</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- breadcrumb desktop -->
    <div class="breadcrumb-b des_tab">
      <div class="container">
        <div class="row">
          <div class="br-dl">
            <span class="home-breadc">Home</span>
            <span class="breadcrumb-2">Tin tức</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Header breadcrumb (anchors) -->
    <div ref="anchorsSectionEl" class="section p-section-about" :class=" { 'scroll-navi': isScrollNavi } ">
      <div class="header-breadcrumb animatedParent">
        <div class="container">
          <div class="row align-center">
            <div class="logo-b animated fadeInLeftShort delay-250">
              <img src="@/assets/images/logo.png" class="img-responsive" alt="News" />
            </div>
            <div class="right-b animated fadeInRightShort delay-250">
              <nav id="mainNav" class="navigation">
                <a class="navigation__link active" href="#market-news">Về chúng tôi</a>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- CONTENT -->
      <div class="content-page">
        <div class="page-section page-news animatedParent bg-wh" data-anchor="market-news" id="market-news">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 no-padding mb-4">
                <div class="ico-section animated fadeInLeftShort delay-250">
                  <h1 class="small-title-h">Tin tức</h1>
                  <h2 class="big-title-h">Về chúng tôi</h2>
                </div>
              </div>

              <!-- Big news GRID -->
              <div class="big-news-grid animated fadeInRightShort delay-500">
                <!-- loading skeleton -->
                <template v-if="loading">
                  <div v-for="i in 6" :key=" 'sk-' + i " class="news-card skeleton">
                    <div class="thumb"></div>
                    <div class="meta">
                      <div class="date sk-line"></div>
                      <div class="title sk-line"></div>
                      <div class="excerpt sk-line"></div>
                    </div>
                  </div>
                </template>

                <template v-else>
                  <div v-if="errorMsg" class="error-box">{{ errorMsg }}</div>
                  <div v-else-if="!bigNews.length" class="empty-box">No news found.</div>

                  <article v-for="n in bigNews" :key=" n.href " class="news-card">
                    <a :href=" n.href " class="card-link">
                      <div class="thumb">
                        <img :src=" n.img " :alt=" n.title " loading="lazy" />
                        <div class="date-badge">
                          <span class="day">{{ n.dateSpan }}</span>
                          <span class="my">{{ n.dateTail }}</span>
                        </div>
                      </div>
                      <div class="meta">
                        <h3 class="title line-clamp-2">{{ n.title }}</h3>
                        <p class="excerpt line-clamp-3">{{ n.excerpt }}</p>
                      </div>
                    </a>
                  </article>
                </template>
              </div>
              <div class="paginate">
                <v-pagination v-model=" page " :pages=" pageCount " :range-size=" 0 " active-color="#3ea9e0"
                  hide-first-button hide-last-button @update:modelValue=" loadNews " />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* ===== Big News Grid ===== */
.big-news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 24px;
  width: 100%;
}

.paginate {
  margin-top: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding-bottom: 50px
}

.news-card {
  background: #fff;
  border-radius: 14px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
  transition: transform .2s ease, box-shadow .2s ease;
  min-height: 100%;
}

.news-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, .09);
}

.card-link {
  color: inherit;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  height: 100%;
}

/* Thumb giữ tỉ lệ, ảnh cover */
.thumb {
  position: relative;
  width: 100%;
  aspect-ratio: 16/9;
  overflow: hidden;
  background: #f5f5f5;
}

.thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform .4s ease;
}

.news-card:hover .thumb img {
  transform: scale(1.03);
}

/* Date badge */
.date-badge {
  position: absolute;
  left: 12px;
  top: 12px;
  background: rgba(0, 0, 0, .65);
  color: #fff;
  padding: 6px 10px;
  border-radius: 10px;
  line-height: 1.1;
  font-size: 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.date-badge .day {
  font-weight: 700;
  font-size: 16px;
}

.date-badge .my {
  opacity: .9;
}

/* Meta */
.meta {
  padding: 14px 14px 16px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.title {
  font-size: 16px;
  font-weight: 700;
}

.excerpt {
  font-size: 14px;
  opacity: .85;
}

/* Line clamp helper */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Loading skeleton */
.skeleton {
  animation: sk 1.2s infinite linear alternate;
}

@keyframes sk {
  0% {
    opacity: .6
  }

  100% {
    opacity: 1
  }
}

.skeleton .thumb {
  background: #eee;
}

.sk-line {
  height: 12px;
  background: #eee;
  border-radius: 6px;
}

.skeleton .meta {
  padding: 14px;
  display: grid;
  gap: 10px;
}

.skeleton .date {
  width: 60px;
}

.skeleton .title {
  width: 80%;
  height: 16px;
}

.skeleton .excerpt {
  width: 100%;
  height: 12px;
}

/* Pagination */
.pagination-wrap {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 28px 0 8px;
  flex-wrap: wrap;
}

.pg-info {
  opacity: .8;
}

.pg-size {
  margin-left: auto;
  display: flex;
  align-items: center;
  gap: 8px;
}

.pg-size select {
  height: 36px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  padding: 0 10px;
  background: #fff;
}

.big-new,
.col-new,
.img-new-center,
.detail-new {
  display: contents;
}
</style>
<style>
.PaginationControl {
  width: max-content
}

.Control {
  display: none;
  width: 30px;
  height: 30px;
  border-radius: 10px
}

.Control-active {
  border: 1px solid #ccc;
  display: block;
  background: #3ea9e0;
  fill: #fff
}

.Page {
  width: 30px;
  height: 30px;
  border-radius: 10px;
  color: #000;
  transition: .3s;
  font-weight: 900
}

.Page-active {
  width: 30px;
  height: 30px;
  border-radius: 10px;
  background: #3ea9e0;
  color: #fff
}
</style>