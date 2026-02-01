<script setup lang="ts">
import { ref, computed, onMounted, nextTick, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import http from '@/api/http' // axios instance bạn đang dùng cho FE (guest không cần token)
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
import useJqueryPlugins from '@/composables/useJqueryPlugins'

useAnimateOnScroll()
const { initFancybox, initMatchHeight, initNiceScroll, destroyAll } = useJqueryPlugins()

const route = useRoute()
const slug = computed(() => route.params.slug as string)

const loading = ref(true)
const error = ref<string | null>(null)
const article = ref<{
  title: string
  slug: string
  excerpt?: string
  body: string
  cover_image_url?: string
  status?: string
  published_at?: string
  author_id?: number
  author_name?: string
} | null>(null)

// const bannerUrl = new URL('@/assets/images/banner-tintuc.jpg', import.meta.url).href
const bannerUrl = computed(() => {
  const coverUrl = article.value?.cover_image_url || fallbackCover;
  try {
    return new URL(coverUrl).toString();
  } catch {
    return coverUrl.startsWith('http') ? coverUrl : fallbackCover;
  }
});
const fallbackCover =
  'https://netland.com.vn/wp-content/uploads/2025/09/emerging-trends-in-vietnams-real-estate-market-2025-scaled.jpg'

const dateStr = computed(() => {
  const d = article.value?.published_at
  if (!d) return ''
  // format dd/MM/yyyy
  const dt = new Date(d)
  const dd = String(dt.getDate()).padStart(2, '0')
  const mm = String(dt.getMonth() + 1).padStart(2, '0')
  const yyyy = dt.getFullYear()
  return `${ dd }/${ mm }/${ yyyy }`
})

async function fetchDetail() {
  loading.value = true
  error.value = null
  try {
    const res = await http.get(`/api/courses/${ encodeURIComponent(slug.value) }`)
    const a = res.data
    article.value = {
      title: a.title,
      slug: a.slug,
      excerpt: a.excerpt,
      body: a.body,
      cover_image_url: a.cover_image_url,
      status: a.status,
      published_at: a.published_at,
      author_id: a.author_id,
      author_name: a.author_name || 'SKYLOVE'
    }
  } catch (e: any) {
    error.value = e?.response?.data?.message || 'Cannot load article.'
  } finally {
    loading.value = false
  }
}

function initLegacy() {
  try { initFancybox() } catch { }
  try { initMatchHeight('.height_cus') } catch { }
  try { initNiceScroll('.w-chinhsach') } catch { }
}

onMounted(async () => {
  document.body.classList.add('site')
  await fetchDetail()
  await nextTick()
  requestAnimationFrame(initLegacy)
})

onUnmounted(() => {
  document.body.classList.remove('site')
  try { destroyAll() } catch { }
})
</script>

<template>
  <div id="fullpage">
    <!-- Banner -->
    <div class="section banner-page">
      <div class="p-news-detail bannner-t" :style=" `background: url(${ bannerUrl }) center top no-repeat` ">
        <div class="breadcrumb-b">
          <div class="container">
            <div class="row">
              <div class="br-dl">
                <span class="home-breadc">Home</span>
                <span class="breadcrumb-2">Khóa học</span>
                <span class="breadcrumb-3">{{ article?.title || '...' }}</span>
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
            <span class="breadcrumb-2">Khóa học</span>
            <span class="breadcrumb-3">{{ article?.title || '...' }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="section p-section-about">
      <div class="content-page">
        <div class="page-section animatedParent" id="detail-news">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 no-padding">
                <div class="heading-news fadeInLeftShort delay-250 animated">
                  <template v-if="!loading && !error && article">
                    <h1 class="title-new-p">{{ article.title }}</h1>
                    <span v-if="dateStr" class="date-post-n">{{ dateStr }}</span>
                    <span class="by-user">By {{ article.author_name || 'SKYLOVE' }}</span>
                    <router-link class="btn-cta" :to=" { name: 'contact-us' } ">Đăng ký ngay</router-link>
                  </template>

                  <template v-else-if="loading">
                    <h1 class="title-new-p">Loading…</h1>
                  </template>

                  <template v-else>
                    <h1 class="title-new-p">Not found</h1>
                  </template>
                </div>
              </div>

              <div class="detail-news fadeInRightShort delay-500 animated">
                <!-- Cover -->

                <!-- Excerpt -->
                <p v-if="article?.excerpt"><strong v-text=" article.excerpt " /></p>

                <!-- Body (HTML từ BE) -->
                <div v-if="article" class="prose max-w-none" v-html=" article.body "></div>

                <!-- Error -->
                <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
              </div>

              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.cta-row {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.btn-cta {
  display: inline-block;
  padding: 10px 18px;
  border-radius: 999px;
  background: #3ea9e0;
  /* màu chủ đạo */
  color: #fff;
  font-weight: 700;
  text-decoration: none;
  transition: transform .15s ease, box-shadow .15s ease;
}

.btn-cta:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(62, 169, 224, .35);
}

.btn-cta:active {
  transform: translateY(0);
  box-shadow: 0 3px 8px rgba(62, 169, 224, .25);
}

.banner-page .bannner-t {
  min-height: 280px;
}

.breadcrumb-b {
  padding: 10px 0;
}

.title-new-p {
  font-size: 28px;
  font-weight: 800;
  margin: 0 0 8px;
}

.date-post-n,
.by-user {
  margin-right: 12px;
  color: #777;
}

.detail-news {
  margin-top: 24px;
}

.detail-news img {
  max-width: 100%;
  height: auto;
}

.prose :deep(img) {
  max-width: 100%;
  height: auto;
}
</style>
