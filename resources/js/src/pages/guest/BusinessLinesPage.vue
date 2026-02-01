<!-- <script setup lang="ts">
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
import useJqueryPlugins from '@/composables/useJqueryPlugins'

// Helper tạo URL asset (để dùng trong template, tránh lỗi Volar)
const asset = (p: string) => new URL(p, import.meta.url).href

// Ảnh sử dụng trong trang
const bannerUrl  = ref(asset('../../assets/images/about/khu-vui-choi-sasuke.jpg'))
const logoUrl    = asset('../../assets/images/logo.png')
const imgInvest  = asset('../../assets/images/activity/welltone-luxury-residence-2.jpg')
const imgDevelop = asset('../../assets/images/activity/Takashi2.jpg')
const imgSales   = asset('../../assets/images/activity/tiep-thi-phan-phoi-2.jpg')
const imgService = asset('../../assets/images/activity/Welltone1-2.png')

useAnimateOnScroll()
const { initFancybox, initMatchHeight, initNiceScroll, destroyAll } = useJqueryPlugins()

function initLegacyOnPage() {
  const $: any = (window as any).jQuery || (window as any).$
  if (!$) return

  // Fancybox
  try {
    $('[data-fancybox]').fancybox({ toolbar: false, smallBtn: true, iframe: { preload: false } })
  } catch {}

  // matchHeight / NiceScroll (nếu có phần tử tương ứng)
  try { if ($.fn.matchHeight) $('.height_cus').matchHeight() } catch {}
  try { if ($.fn.niceScroll)  $('.w-chinhsach').niceScroll() } catch {}

  // Owl Carousel cho các gallery của từng section
  try {
    if ($.fn.owlCarousel) {
      const sel = '.owl-carousel.slide-lv'
      $(sel).each(function (this: HTMLElement) {
        const $el = $(this)
        if ($el.data('owl.carousel')) return
        $el.owlCarousel({
          loop: true,
          items: 1,
          margin: 0,
          nav: false,
          dots: false,
          autoplay: true,
          autoplayTimeout: 3500,
          autoplayHoverPause: true,
          smartSpeed: 450,
        })
      })
    }
  } catch (e) { console.warn('owl init skipped:', e) }
}

onMounted(async () => {
  document.body.classList.add('page', 'activity')
  try { initFancybox() } catch {}
  try { initMatchHeight('.height_cus') } catch {}
  try { initNiceScroll('.w-chinhsach') } catch {}
  await nextTick()
  requestAnimationFrame(() => initLegacyOnPage())
})

onUnmounted(() => {
  document.body.classList.remove('page', 'activity')
  try { destroyAll() } catch {}
})
</script> -->
<script setup lang="ts">
import { ref, onMounted, onUnmounted, nextTick } from 'vue'
import { useAnimateOnScroll } from '../../composables/useAnimateOnScroll'
import useJqueryPlugins from '../../composables/useJqueryPlugins'

// Helper tạo URL asset (để dùng trong template, tránh lỗi Volar)
const asset = (p: string) => new URL(p, import.meta.url).href

// Ảnh sử dụng trong trang
const bannerUrl = ref(asset('../../assets/images/about/khu-vui-choi-sasuke.jpg'))
const logoUrl = asset('../../assets/images/logo.png')
const imgInvest = asset('../../assets/images/activity/welltone-luxury-residence-2.jpg')
const imgDevelop = asset('../../assets/images/activity/Takashi2.jpg')
const imgSales = asset('../../assets/images/activity/tiep-thi-phan-phoi-2.jpg')
const imgService = asset('../../assets/images/activity/Welltone1-2.png')

useAnimateOnScroll()
const { initFancybox, initMatchHeight, initNiceScroll, destroyAll } = useJqueryPlugins()

/* ========== scroll-navi cho section anchors ========== */
const anchorsSectionEl = ref<HTMLElement | null>(null)
const isScrollNavi = ref(false)
// Nếu header sticky có chiều cao ~80px thì bù trừ offset này (tuỳ chỉnh)
const stickyOffset = 0 // đổi thành 80 nếu bạn có header sticky cao 80px

let ticking = false
function computeScrollNavi() {
  const el = anchorsSectionEl.value
  if (!el) return
  const sectionTop = el.offsetTop
  isScrollNavi.value = window.scrollY + stickyOffset >= sectionTop
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

/* ========== Legacy jQuery plugins (nếu có) ========== */
function initLegacyOnPage() {
  const $: any = (window as any).jQuery || (window as any).$
  if (!$) return
  try { $('[data-fancybox]').fancybox({ toolbar: false, smallBtn: true, iframe: { preload: false } }) } catch { }
  try { if ($.fn.matchHeight) $('.height_cus').matchHeight() } catch { }
  try { if ($.fn.niceScroll) $('.w-chinhsach').niceScroll() } catch { }
  try {
    if ($.fn.owlCarousel) {
      const sel = '.owl-carousel.slide-lv'
      $(sel).each(function (this: HTMLElement) {
        const $el = $(this)
        if ($el.data('owl.carousel')) return
        $el.owlCarousel({
          loop: true,
          items: 1,
          margin: 0,
          nav: false,
          dots: false,
          autoplay: true,
          autoplayTimeout: 3500,
          autoplayHoverPause: true,
          smartSpeed: 450,
        })
      })
    }
  } catch (e) { console.warn('owl init skipped:', e) }
}

onMounted(async () => {
  document.body.classList.add('page', 'activity')
  try { initFancybox() } catch { }
  try { initMatchHeight('.height_cus') } catch { }
  try { initNiceScroll('.w-chinhsach') } catch { }
  await nextTick()

  // scroll-navi
  window.addEventListener('scroll', onScrollOrResize, { passive: true })
  window.addEventListener('resize', onScrollOrResize)
  computeScrollNavi()

  requestAnimationFrame(() => initLegacyOnPage())
})

onUnmounted(() => {
  document.body.classList.remove('page', 'activity')
  try { destroyAll() } catch { }
  window.removeEventListener('scroll', onScrollOrResize)
  window.removeEventListener('resize', onScrollOrResize)
})
</script>


<template>
  <div id="fullpage">
    <section class="section banner-page">
      <div class="p-field bannner-t" :style=" `background: url(${ bannerUrl }) center top no-repeat` ">
        <div class="breadcrumb-b">
          <div class="container">
            <div class="row">
              <div class="br-dl">
                <span class="home-breadc">Home</span>
                <span class="breadcrumb-2">Business Lines</span>
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
            <span class="breadcrumb-2">Business Lines</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Header breadcrumb (anchors) -->
    <section class="section p-section-about" ref="anchorsSectionEl" :class=" { 'scroll-navi': isScrollNavi } ">
      <div class="header-breadcrumb animatedParent">
        <div class="container">
          <div class="row align-center">
            <div class="logo-b animated fadeInLeftShort delay-250">
              <img :src=" logoUrl " class="img-responsive" alt="Business Lines" />
            </div>
            <div class="right-b animated fadeInRightShort delay-250">
              <nav id="mainNav" class="navigation">
                <a class="navigation__link active" href="#project-investment">Project Investment</a>
                <a class="navigation__link" href="#project-development">Project Development</a>
                <a class="navigation__link" href="#sales-marketing">Sales &amp; Marketing</a>
                <a class="navigation__link" href="#real-estate-services">Real Estate Services</a>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- CONTENT -->
      <div class="content-page">
        <!-- 1) Project Investment -->
        <div id="project-investment" class="section-lv pos-left animatedParent" data-anchor="project-investment">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-5 p-left-lv p-left0">
                <div class="left-lv">
                  <h2 class="numb-lv lv-1 animated fadeInLeftShort delay-250">Activity</h2>
                  <h3 class="name-lv animated fadeInLeftShort delay-500">Project Investment</h3>
                  <div class="des-lv animated fadeInLeftShort delay-750">
                    <p>
                      Netland targets projects with strategic locations, clear legal standing, and
                      strong return potential. Drawing on deep market insight, we curate a diversified
                      portfolio spanning townships, high-rise residences, retail centers, and beachfront
                      resorts—strengthening financial fundamentals and compounding long-term value for
                      customers, investors, and shareholders.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-lg-6 p-img-lv animated fadeInRightShort delay-250">
                <div class="owl-carousel slide-lv">
                  <div class="item">
                    <div class="wsl-lv">
                      <a data-fancybox="gallery-lv" :href=" imgInvest ">
                        <img :src=" imgInvest " class="img-responsive" alt="" />
                      </a>
                    </div>
                    <h4></h4>
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>
            </div>
          </div>
        </div>

        <!-- 2) Project Development -->
        <div id="project-development" class="section-lv pos-right animatedParent" data-anchor="project-development">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-6 p-img-lv animated fadeInLeftShort delay-250">
                <div class="owl-carousel slide-lv">
                  <div class="item">
                    <div class="wsl-lv">
                      <a data-fancybox="gallery-lv" :href=" imgDevelop ">
                        <img :src=" imgDevelop " class="img-responsive" alt="" />
                      </a>
                    </div>
                    <h4></h4>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-lg-6 p-right-lv">
                <div class="right-lv">
                  <h2 class="numb-lv lv-2 animated fadeInRightShort delay-250">Activity</h2>
                  <h3 class="name-lv animated fadeInRightShort delay-500">Project Development</h3>
                  <div class="des-lv animated fadeInRightShort delay-750">
                    <p>
                      Netland takes an end-to-end role in large-scale developments—spanning planning,
                      design, construction, and operations management. Guided by our promise of
                      Excellence – Transparency – Sustainability, we deliver quality living environments
                      with integrated infrastructure and modern amenities, elevating the urban fabric of
                      every community we serve.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 3) Sales & Marketing -->
        <div id="sales-marketing" class="section-lv pos-left animatedParent" data-anchor="sales-marketing">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-5 p-left-lv p-left0">
                <div class="left-lv">
                  <h2 class="numb-lv lv-3 animated fadeInLeftShort delay-250">Activity</h2>
                  <h3 class="name-lv animated fadeInLeftShort delay-500">Sales &amp; Marketing</h3>
                  <div class="des-lv animated fadeInLeftShort delay-750">
                    <p>
                      Netland runs a professional sales &amp; marketing platform powered by seasoned
                      talent and a nationwide agency network. We’ve brought dozens of projects to market
                      across Vietnam, serving tens of thousands of homebuyers and investors. Our
                      commercial edge blends modern marketing, smart technology, and attentive customer
                      care—establishing Netland as the trusted link between developers and customers.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-lg-6 p-img-lv animated fadeInRightShort delay-250">
                <div class="owl-carousel slide-lv">
                  <div class="item">
                    <div class="wsl-lv">
                      <a data-fancybox="gallery-lv" :href=" imgSales ">
                        <img :src=" imgSales " class="img-responsive" alt="" />
                      </a>
                    </div>
                    <h4></h4>
                  </div>
                </div>
              </div>

              <div class="clearfix"></div>
            </div>
          </div>
        </div>

        <!-- 4) Real Estate Services -->
        <div id="real-estate-services" class="section-lv pos-right animatedParent" data-anchor="real-estate-services">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-6 p-img-lv animated fadeInLeftShort delay-250">
                <div class="owl-carousel slide-lv">
                  <div class="item">
                    <div class="wsl-lv">
                      <a data-fancybox="gallery-lv" :href=" imgService ">
                        <img :src=" imgService " class="img-responsive" alt="" />
                      </a>
                    </div>
                    <h4></h4>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-lg-6 p-right-lv">
                <div class="right-lv">
                  <h2 class="numb-lv lv-4 animated fadeInRightShort delay-250">Activity</h2>
                  <h3 class="name-lv animated fadeInRightShort delay-500">Real Estate Services</h3>
                  <div class="des-lv animated fadeInRightShort delay-750">
                    <p>
                      Beyond investment and development, Netland delivers a full real estate services
                      ecosystem—including investment advisory, property operations, after-sales service,
                      and customer care. Together, these services enhance asset value, provide peace of
                      mind, and deepen trust in the Netland brand.
                    </p>
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
