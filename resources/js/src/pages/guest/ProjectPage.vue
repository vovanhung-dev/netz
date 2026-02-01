<script setup lang="ts">
import { onMounted, onUnmounted, nextTick, ref } from 'vue'
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
import useJqueryPlugins from '@/composables/useJqueryPlugins'

import bannerImg from '@/assets/images/about/khu-vui-choi-sasuke.jpg'
import logoSvg   from '@/assets/images/logo.png'

import ariaMain   from '@/assets/images/project/Aria-Vung-Tau2.jpg'
import ariaThumb  from '@/assets/images/project/Aria-Vung-Tau2.jpg'
import takashiCard from '@/assets/images/project/takashi-oceansuite-ky-co-2.jpg'
import baryaCard   from '@/assets/images/project/barya-city.jpg'
import camauCard   from '@/assets/images/project/ca-mau-new-city-1.jpg'
import metroCard   from '@/assets/images/project/saigon-metro-mall.webp'
import goldviewCard from '@/assets/images/project/the-gold-view.webp'
import citibellaCard from '@/assets/images/project/citibella-1.webp'
import linhtayCard   from '@/assets/images/project/linh-tay.webp'

import welltoneMain  from '@/assets/images/project/welltone-luxury-residence-1.jpg'
import welltoneCard  from '@/assets/images/project/welltone-luxury-residence-1.jpg'

useAnimateOnScroll()
const { initFancybox, initMatchHeight, initNiceScroll, destroyAll } = useJqueryPlugins()

/* ================= scroll-navi cho anchors ================= */
// NEW
const anchorsSectionEl = ref<HTMLElement | null>(null)
const isScrollNavi = ref(false)
// Nếu có header sticky cao 80px, đổi offset = 80
const stickyOffset = 0

let ticking = false
// NEW
function computeScrollNavi() {
  const el = anchorsSectionEl.value
  if (!el) return
  isScrollNavi.value = window.scrollY + stickyOffset >= el.offsetTop
}
// NEW
function onScrollOrResize() {
  if (!ticking) {
    ticking = true
    requestAnimationFrame(() => {
      computeScrollNavi()
      ticking = false
    })
  }
}

/** Khởi tạo Owl & đồng bộ bigslide <-> thumbs theo HTML cũ */
function initOwlForSection(root: HTMLElement) {
  const w = window as any
  const $ = w.jQuery || w.$
  if (!$ || !$.fn?.owlCarousel) return

  const $big = $(root).find('.bigslide.owl-carousel')
  const $thumbs = $(root).find('.thumbs.owl-carousel')

  // Tránh init trùng
  if ($big.data('owl.carousel')) $big.trigger('destroy.owl.carousel')
  if ($thumbs.data('owl.carousel')) $thumbs.trigger('destroy.owl.carousel')

  $big.owlCarousel({
    items: 1,
    margin: 0,
    nav: false,
    dots: false,
    loop: true,
    autoplay: true,
    autoplayTimeout: 3500,
    autoplayHoverPause: true,
    smartSpeed: 450,
    onChanged: (e: any) => {
      const index = (e.item.index - e.relatedTarget._clones.length / 2) % e.item.count
      const current = (index + e.item.count) % e.item.count
      $thumbs.trigger('to.owl.carousel', [current, 300, true])
      $thumbs.find('.owl-item').removeClass('current')
      $thumbs.find('.owl-item').eq(current).addClass('current')
    },
  })

  $thumbs.owlCarousel({
    items: 2,
    margin: 30,
    nav: false,
    dots: false,
    loop: false,
    autoplay: false,
  })

  // Set trạng thái ban đầu cho thumbs
  $thumbs.find('.owl-item').removeClass('current').eq(0).addClass('current')

  // Click thumb -> chuyển big
  $thumbs.off('click.owlThumb').on('click.owlThumb', '.owl-item', function (this: HTMLElement) {
    const idx = $(this).index()
    $big.trigger('to.owl.carousel', [idx, 300, true])
    $thumbs.find('.owl-item').removeClass('current')
    $(this).addClass('current')
  })
}

/** Carousel danh sách “project-orther” */
function initProjectOtherCarousel(ctx: HTMLElement) {
  const w = window as any
  const $ = w.jQuery || w.$
  if (!$ || !$.fn?.owlCarousel) return
  $(ctx).find('.slide-project-ort').each(function (this: HTMLElement) {
    const $el = $(this)
    if ($el.data('owl.carousel')) return
    $el.owlCarousel({
      items: 3,
      margin: 30,
      nav: true,
      dots: false,
      loop: false,
      responsive: {
        0: { items: 1, margin: 15 },
        768: { items: 2 },
        1200: { items: 3 },
      },
    })
  })
}

/** Init toàn trang Project */
function initLegacyOnPage() {
  const root = document.querySelector('#project-page-root') as HTMLElement | null
  if (!root) return
  initOwlForSection(root)       // cả 2 block bigslide + thumbs
  initProjectOtherCarousel(root)
}

// NEW — Destroy Owl khi rời trang (tránh init đè)
function destroyOwlOnPage() {
  const w = window as any
  const $ = w.jQuery || w.$
  if (!$ || !$.fn?.owlCarousel) return
  $('#project-page-root .owl-carousel').each(function (this: HTMLElement) {
    const $el = $(this)
    if ($el.data('owl.carousel')) $el.trigger('destroy.owl.carousel')
    $el.off('.owlThumb')
  })
}

onMounted(async () => {
  document.body.classList.add('site')
  try { initFancybox() } catch {}
  try { initMatchHeight('.height_cus') } catch {}
  try { initNiceScroll('.w-chinhsach') } catch {}

  await nextTick()

  // NEW — lắng nghe scroll/resize cho scroll-navi
  window.addEventListener('scroll', onScrollOrResize, { passive: true })
  window.addEventListener('resize', onScrollOrResize)
  computeScrollNavi()

  requestAnimationFrame(() => initLegacyOnPage())
})

onUnmounted(() => {
  document.body.classList.remove('site')
  // NEW — huỷ Owl trước khi destroyAll()
  destroyOwlOnPage()
  try { destroyAll() } catch {}
  // NEW — gỡ listeners
  window.removeEventListener('scroll', onScrollOrResize)
  window.removeEventListener('resize', onScrollOrResize)
})
</script>


<template>
  <div id="project-page-root">
    <!-- Banner -->
    <section class="section banner-page">
      <div class="p-project bannner-t" :style="`background: url(${bannerImg}) center top no-repeat`">
        <div class="breadcrumb-b">
          <div class="container">
            <div class="row">
              <div class="br-dl">
                <span class="home-breadc">Home</span>
                <span class="breadcrumb-2">Project</span>
              </div>
              <div class="dl-pro">
                <div class="download-pf"><a href="#" target="_blank" rel="noopener">Download Company Profile</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- breadcrumb desktop -->
    <div class="breadcrumb-b des_tab">
      <div class="container">
        <div class="row">
          <div class="br-dl">
            <span class="home-breadc">Home</span>
            <span class="breadcrumb-2">Project</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Header breadcrumb (anchors) -->
    <section
        ref="anchorsSectionEl"
        class="section p-section-about"
        :class="{ 'scroll-navi': isScrollNavi }"
      >
      <div class="header-breadcrumb animatedParent">
        <div class="container">
          <div class="row align-center">
            <div class="logo-b animated fadeInLeftShort delay-250">
              <img :src="logoSvg" class="img-responsive" alt="Project" />
            </div>
            <div class="right-b animated fadeInRightShort delay-250">
              <nav id="mainNav" class="navigation">
                <a class="navigation__link active" href="#project-implemented">Project implemented</a>
                <a class="navigation__link" href="#ongoing-projects">Ongoing projects</a>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- CONTENT -->
      <div class="content-page">
        <!-- Project implemented -->
        <div id="project-implemented" class="page-section bg-ico animatedParent" data-anchor="project-implemented">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-5 p-left-lv p-left0">
                <div class="content-proj">
                  <div class="ico-section padding-ico ico-project-hot animated fadeInLeftShort delay-250">
                    <div class="small-title-h">Project implemented</div>
                    <h1 class="big-title-h">Outstanding project</h1>
                  </div>

                  <h2 class="name-project animated fadeInLeftShort delay-500">Aria Vung Tau</h2>

                  <div class="detail-proj animated fadeInLeftShort delay-750">
                    <ul>
                      <li><strong>Commercial name</strong>: Aria Vũng Tàu Hotel &amp; Resort</li>
                      <li><strong>Location</strong>: 79 Hà Huy Tập (D5), Ward 10, Vũng Tàu City, Bà Rịa–Vũng Tàu</li>
                      <li><strong>Developer</strong>: Asia Tourism and Construction Investment JSC (COTECASIA)</li>
                      <li><strong>Site area</strong>: 76,900 m²</li>
                      <li><strong>Number of units</strong>: 1,190 condotel apartments and 36 villas</li>
                      <li><strong>Building coverage</strong>: 35% (tower blocks), 40% (podium)</li>
                      <li><strong>Amenities</strong>: Infinity pool, spa, restaurants, bar, entertainment area, 150 m private beach</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- slides -->
              <div class="col-sm-12 col-lg-7 p-img-pro animated fadeInRightShort delay-250">
                <div class="bigslide owl-carousel slide-project">
                  <div class="item">
                    <img :src="ariaMain" class="img-responsive" alt="Aria Vung Tau" />
                  </div>
                </div>

                <div class="thumbs owl-carousel owl-theme">
                  <div class="item">
                    <img :src="ariaThumb" class="img-responsive" alt="Aria Vung Tau" />
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>

              <!-- other projects -->
              <div class="col-sm-12 col-lg-12 project-orther animated fadeInUpShort delay-500">
                <div class="owl-carousel slide-project-ort">
                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${ariaMain})`"></div></a>
                    <h4>Aria Vung Tau</h4>
                  </div>

                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${takashiCard})`"></div></a>
                    <h4>Takashi Ocean Suite Ky Co</h4>
                  </div>

                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${baryaCard})`"></div></a>
                    <h4>Barya Citi</h4>
                  </div>

                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${camauCard})`"></div></a>
                    <h4>Ca Mau New City</h4>
                  </div>

                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${metroCard})`"></div></a>
                    <h4>Saigon Metro Mall</h4>
                  </div>

                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${goldviewCard})`"></div></a>
                    <h4>The Gold View</h4>
                  </div>

                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${citibellaCard})`"></div></a>
                    <h4>Citibella</h4>
                  </div>

                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${linhtayCard})`"></div></a>
                    <h4>Linh Tay Tower</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Ongoing projects -->
        <div id="ongoing-projects" class="page-section project-right progress-project mb-5 animatedParent" data-anchor="ongoing-projects">
          <div class="container">
            <div class="row">
              <!-- slides -->
              <div class="col-sm-12 col-lg-7 p-img-pro animated fadeInLeftShort delay-250">
                <div class="bigslide owl-carousel slide-project">
                  <div class="item">
                    <img :src="welltoneMain" class="img-responsive" alt="Welltone Luxury Residence" />
                  </div>
                </div>

                <div class="thumbs owl-carousel owl-theme">
                  <div class="item">
                    <img :src="welltoneMain" class="img-responsive" alt="Welltone Luxury Residence" />
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-lg-5 p-left-lv p-right0">
                <div class="content-proj">
                  <div class="ico-section padding-ico  ico-projectplan animated fadeInRightShort delay-250">
                    <div class="small-title-h">Ongoing projects</div>
                    <h1 class="big-title-h">Outstanding project</h1>
                  </div>

                  <h2 class="name-project animated fadeInRightShort delay-500">Welltone Luxury Residence</h2>

                  <div class="detail-proj col-white animated fadeInRightShort delay-750">
                    As a complex of premium apartments, retail, entertainment, and leisure in Nha Trang (Khanh Hoa), Welltone Luxury Residence draws inspiration from gentle ocean waves embracing the shore. Its soft, flowing curves create a new architectural icon for the area and define a new lifestyle for the elite.
                    <ul>
                      <li><strong>Total site area</strong>: 11,115.7 m²</li>
                      <li>Inventory: 1,341 apartments; commercial/service areas; two interconnected basement levels linking three towers</li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="col-sm-12 col-lg-12 project-orther animated fadeInUpShort delay-500">
                <div class="owl-carousel slide-project-ort">
                  <div class="item">
                    <a href="#"><div class="img-anima height_cus" :style="`background:url(${welltoneCard})`"></div></a>
                    <h4>Welltone Luxury Residence</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /sections -->
      </div>
    </section>
  </div>
</template>
