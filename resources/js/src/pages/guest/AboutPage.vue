<script setup lang="ts">
import { onMounted, onUnmounted, nextTick, ref } from 'vue'
import Message from '../../components/sections/Message.vue'
import VisionMission from '../../components/sections/VisionMission.vue'
import Partners from '../../components/sections/Partners.vue'

// hiệu ứng vào viewport (thêm class .go cho .animated bên trong .animatedParent)
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
// gói khởi tạo nhanh fancybox / matchHeight / niceScroll và destroy
import useJqueryPlugins from '@/composables/useJqueryPlugins'

useAnimateOnScroll()
const { initFancybox, initMatchHeight, initNiceScroll, destroyAll } = useJqueryPlugins()

// banner local (tránh 404/blocked)
const bannerUrl = ref(
  new URL('../../assets/images/about/khu-vui-choi-sasuke.jpg', import.meta.url).href
)
// NEW — state & handlers cho scroll-navi
const aboutSectionEl = ref<HTMLElement | null>(null)
const isScrollNavi = ref(false)

// throttle bằng rAF để nhẹ nhàng
let ticking = false
function computeScrollNavi() {
  if (!aboutSectionEl.value) return
  // vị trí top tuyệt đối của section
  const sectionTop = aboutSectionEl.value.offsetTop
  // Nếu đã scroll vượt qua điểm bắt đầu section thì bật scroll-navi
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

function safeInitLegacy() {
  const $: any = (window as any).jQuery || (window as any).$
  if (!$) return

  // Fancybox
  try {
    if ($.fancybox) {
      const $fz = $('[data-fancybox]')
      if ($fz.length) {
        $fz.fancybox({ toolbar: false, smallBtn: true, iframe: { preload: false } })
      }
    }
  } catch (e) { console.warn('fancybox init skipped:', e) }

  try {
    if ($.fn.niceScroll) {
      const $ns = $('.w-chinhsach')
      if ($ns.length) $ns.niceScroll({ cursorwidth: 6, autohidemode: false, boxzoom: true })
    }
  } catch (e) { console.warn('nicescroll init skipped:', e) }

  // matchHeight
  try {
    if ($.fn.matchHeight) {
      const $mh = $('.height_cus')
      if ($mh.length) $mh.matchHeight()
    }
  } catch (e) { console.warn('matchHeight init skipped:', e) }

  try {
    if ($.fn.owlCarousel) {
      const $owl = $('.banner-home-s')
      if ($owl.length && !$owl.data('owl.carousel')) {
        $owl.owlCarousel({
          loop: true, items: 1, autoplay: true, autoplayTimeout: 5000, dots: true, nav: false
        })
      }
    }
  } catch (e) { console.warn('owl init skipped:', e) }
}

onMounted(async () => {
  // body classes mà CSS cũ phụ thuộc
  document.body.classList.add('page', 'about', 'page-template-about')

  // init composables (jQuery plugins bọc sẵn)
  try { initFancybox() } catch { }
  try { initMatchHeight('.height_cus') } catch { }
  try { initNiceScroll('.w-chinhsach') } catch { }
  // init các script legacy khác (nếu cần)
  await nextTick()

  window.addEventListener('scroll', onScrollOrResize, { passive: true })
  window.addEventListener('resize', onScrollOrResize)
  computeScrollNavi()

  requestAnimationFrame(() => safeInitLegacy())
})

onUnmounted(() => {
  document.body.classList.remove('page', 'about', 'page-template-about')
  try { destroyAll() } catch { }
  // NEW — remove listeners
  window.removeEventListener('scroll', onScrollOrResize)
  window.removeEventListener('resize', onScrollOrResize)
})
</script>

<template>
  <div id="fullpage">
    <!-- Banner page -->
    <section class="section banner-page">
      <div class="p-about bannner-t" :style="`background: url(${bannerUrl}) center top no-repeat`">
        <div class="breadcrumb-b">
          <div class="container">
            <div class="row">
              <div class="br-dl">
                <span class="home-breadc">home</span>
                <span class="breadcrumb-2">Giới thiệu</span>
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
            <span class="home-breadc">home</span>
            <span class="breadcrumb-3">Giới thiệu</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Anchor / header breadcrumb -->
    <section class="section p-section-about" ref="anchorsSectionEl" :class="{ 'scroll-navi': isScrollNavi }">
      <div class="header-breadcrumb animatedParent">
        <div class="container">
          <div class="row align-center">
            <div class="logo-b animated fadeInLeftShort delay-250">
              <img src="../../assets/images/logo.png" class="img-responsive" alt="About" />
            </div>
            <div class="right-b animated fadeInRightShort delay-250">
              <nav id="mainNav" class="navigation">
                <a class="navigation__link active" href="#gthieu">Về chúng tôi</a>
                <a class="navigation__link" href="#thongdiep">Tin nhắn</a>
                <a class="navigation__link" href="#giatricl">Giá trị</a>
                <a class="navigation__link" href="#doitac">Đối tác</a>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- About us -->
      <div id="gthieu" class="content-page">
        <section class="page-section bg-ico animatedParent gthieu" data-anchor="gthieu">
          <div class="container">
            <div class="row align-center">
              <div class="col-sm-12 col-lg-6 p-left-about p-left0">
                <div class="ico-section padding-ico ico-about animated fadeInLeftShort delay-250">
                  <div class="small-title-h">Về</div>
                  <h1 class="big-title-h">Skylove</h1>
                </div>
                <div class="clearfix"></div>
                <div class="w-des-ab text-justify animated fadeInUpShort delay-500">
                  <strong>
                    Công ty Cổ phần Đào tạo Kỹ năng Nghiệp vụ Hàng không Skylove</strong>
                  Thật đáng quý khi ngay lúc này, quý vị đang bớt chút thời gian của mình để lắng nghe (những chia sẻ
                  cũng như tìm hiểu về Skylove.)
                  <br />
                  Với sứ mệnh giúp các bạn trẻ "Bứt phá giới hạn của bản thân” để thực hiện hóa ước mơ cho một tương lai
                  tươi sáng và được làm việc trong lĩnh vực Hàng không. Skylove được hình thành với những con người
                  không có gì là xuất chúng. Nhưng họ hội tụ đủ các yếu tố cần thiết TÂM - TẦM - TÀI hơn thế nữa họ còn
                  là những con người đam mê với nghề.
                  <br />
                  Niềm vui lớn nhất của những người làm Phi công, Tiếp viên hàng không không phải chỉ có được một công
                  việc mơ ước, có được mức lương khủng, có được cơ chế đãi ngộ tốt nhất, có được môi trường làm việc bậc
                  nhất trong các ngành nghề ... Mà là được trực tiếp tiếp đón và phục vụ người thân của mình trên các
                  chuyến bay mình đang làm việc.
                  <br />
                  Lấy con người làm trọng tâm - lấy chất lượng làm thước đo, chúng tôi tự hào là đơn vị hàng đầu Việt
                  Nam tổ chức Tuyển sinh Đào tạo - Cam kết việc làm đầu ra nhân lực ngành Hàng không.
                </div>
              </div>
              <div class="col-sm-12 col-lg-6 p-right-about animated fadeInUpShort delay-250">
                <div class="w-img-ab">
                  <img src="../../assets/images/HINHVECTY.jpg" class="img-responsive" alt="About Netland" />
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Message -->
        <section id="thongdiep" class="page-section animatedParent thongdiep" data-anchor="thongdiep">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 w-thongdiep no-padding">
                <div class="ico-section padding-ico ico-thongdiep animated fadeInLeftShort delay-250">
                  <div class="small-title-h">Message</div>
                  <h2 class="big-title-h">Tầm Nhìn - Sứ Mệnh - Giá Trị Cốt Lõi</h2>
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="col-sm-2 col-lg-2 img-thongdiep animated fadeInUpShort delay-250">
                <div class="img-td">
                  <div class="name-tgd"></div>
                </div>
              </div>
              <div class="col-sm-10 col-lg-10 right-thongdiep animated fadeInUpShort delay-250">
                <div class="w-thongdiep-r text-justify">
                  <h3>Tầm Nhìn</h3>
                  Trở thành Doanh nghiệp Đào tạo và cung ứng nhân lực toàn cầu hàng đầu Việt Nam, mang đến các chương
                  trình đào tạo chất lượng, đáp ứng nhu cầu của nhà tuyển dụng, phù hợp xu thế phát triển của ngành Hàng
                  không trong nước và Thế giới.

                  Doanh nghiệp hướng tới việc phủ sóng toàn quốc, mở rộng quy mô cơ sở nhằm đáp ứng nhu cầu học tập ngày
                  càng cao của các học viên trên cả nước.
                  <br />
                  <h3>Sứ Mệnh</h3>
                  Trang bị kiến thức, kỹ năng tốt nhất cho các học viên, thắp sáng ước mơ theo đuổi giấc mơ bay của các
                  bạn trẻ, giúp thế hệ trẻ vươn lên một tầm cao mới được tiếp cận và làm việc trong môi trường hàng
                  không chuyên nghiệp.
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Vision - Mission - Core Values -->
        <section id="giatricl" class="page-section animatedParent giatricl" data-anchor="giatricl">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 no-padding w-thongdiep">
                <div class="ico-section padding-ico ico-giatricl animated fadeInLeftShort delay-250">
                  <h2 class="big-title-h t-white">Tầm Nhìn - Sứ Mệnh - Giá Trị Cốt Lõi</h2>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="col-sm-6 col-lg-6 w-giatricl animated fadeInUpShort delay-500">
                <div class="w-giatricl-l">
                  <img src="../../assets/images/about/vision1-1.png" class="img-responsive" alt="Vision" />
                  <h3 class="title-gt">Tầm Nhìn</h3>
                  <div>
                    Trở thành Doanh nghiệp Đào tạo và cung ứng nhân lực toàn cầu hàng đầu Việt Nam, mang đến các chương
                    trình đào tạo chất lượng, đáp ứng nhu cầu của nhà tuyển dụng, phù hợp xu thế phát triển của ngành
                    Hàng
                    không trong nước và Thế giới.

                    Doanh nghiệp hướng tới việc phủ sóng toàn quốc, mở rộng quy mô cơ sở nhằm đáp ứng nhu cầu học tập
                    ngày
                    càng cao của các học viên trên cả nước.</div>
                </div>
              </div>

              <div class="col-sm-6 col-lg-6 w-giatricl animated fadeInUpShort delay-750">
                <div class="w-giatricl-l">
                  <img src="../../assets/images/about/mission1-2.png" class="img-responsive" alt="Mission" />
                  <h3 class="title-gt">Sứ Mệnh</h3>
                  <div>Trang bị kiến thức, kỹ năng tốt nhất cho các học viên, thắp sáng ước mơ theo đuổi giấc mơ bay của
                    các bạn trẻ, giúp thế hệ trẻ vươn lên một tầm cao mới được tiếp cận và làm việc trong môi trường
                    hàng không chuyên nghiệp.</div>
                </div>
              </div>

              <div class="col-sm-12 col-lg-12 w-giatricl mt-5 animated fadeInUpShort delay-1000">
                <div class="w-giatricl-l">
                  <img src="../../assets/images/about/value1-1.png" class="img-responsive" alt="Core Values (N-E-T)" />
                  <h3 class="title-gt">GIÁ TRỊ CỐT LÕI</h3>
                </div>
              </div>

              <!-- 3 core values -->
              <div class="col-sm-6 col-lg-4 col2-tab w-giatricl animated fadeInUpShort delay-1250">
                <div class="gitrcl w-giatricl1">
                  <h4 class="title-gt-sm">TRUYỀN ĐỘNG LỰC</h4>
                  <p class="des-gt">Connectivity serves as the cornerstone of Netland’s business operations within the
                    community, laying the foundation for the development of urban areas and real estate projects aligned
                    with principles of sustainable growth.</p>
                </div>
              </div>

              <div class="col-sm-6 col-lg-4 col2-tab w-giatricl animated fadeInUpShort delay-1250">
                <div class="gitrcl w-giatricl2">
                  <h4 class="title-gt-sm">THAY ĐỔI TƯ DUY
                  </h4>
                  <p class="des-gt">Cty CP Đào Tạo Huấn Luyện Nghiệp Vụ Hàng Không Skylove không chỉ là nơi đào tạo kiến
                    thức và kỹ năng thi tuyển các vị trí ngành Hàng không, mà còn truyền dạy tư duy học tập, làm việc
                    đúng dân, thay đổi thái độ sống giúp học viên trở nên chuẩn mục, chuyên nghiệp và dễ dàng tháng tiến
                    trong sự nghiệp.</p>
                </div>
              </div>

              <div class="col-sm-6 col-lg-4 col2-tab w-giatricl animated fadeInUpShort delay-1250">
                <div class="gitrcl w-giatricl3">
                  <h4 class="title-gt-sm">TẬN TÂM</h4>
                  <p class="des-gt">Đặt lợi ích của học viên lên hàng đầu, Cty CP Đào Tạo Huấn Luyện Nghiệp Vụ Hàng
                    Không Skylove dành trọn tâm huyết để hỗ trợ và đồng hành cùng học viên thực hiện hóa giấc mơ bay.
                    Chúng tôi cam kết đạo đức của người dẫn đường đối với các học viên của mình.</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Partners -->
        <section id="doitac" class="page-section animatedParent doitac" data-anchor="doitac">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 no-padding w-doitac">
                <div class="ico-section padding-ico ico-doitac animated fadeInLeftShort delay-250">
                  <h2 class="big-title-h">Partners</h2>
                </div>
                <div class="clearfix"></div>
              </div>

              <!-- Strategic -->
              <div class="col-sm-12 col-lg-6 w-doitac">
                <h3 class="head-dtac animated fadeInLeftShort delay-500">Strategic Partnership</h3>
                <div class="w-logo-dt animated fadeInUpShort delay-500">
                  <div class="w-logo"><img src="../../assets/images/Danh-Khoi-Holdings.png" class="img-responsive"
                      alt="Danh Khoi" /></div>
                  <div class="w-logo"><img src="../../assets/images/dkra-group.png" class="img-responsive" alt="DKRA" />
                  </div>
                  <div class="w-logo"><img src="../../assets/images/Apave.svg" class="img-responsive" alt="Apave" />
                  </div>
                  <div class="w-logo"><img src="../../assets/images/DnD.svg" class="img-responsive" alt="DnD" /></div>
                  <div class="w-logo"><img src="../../assets/images/Kien-Vang-01.png" class="img-responsive"
                      alt="Kien Vang" /></div>
                  <div class="w-logo"><img src="../../assets/images/Logo-Phat-Dat-scaled.png" class="img-responsive"
                      alt="Phat Dat" /></div>
                  <div class="w-logo"><img src="../../assets/images/The-Son.svg" class="img-responsive" alt="The Son" />
                  </div>
                  <div class="w-logo"><img src="../../assets/images/PHUC-KHANG.png" class="img-responsive"
                      alt="Phuc Khang" /></div>
                </div>
              </div>

              <!-- Bank -->
              <div class="col-sm-12 col-lg-6 w-doitac">
                <h3 class="head-dtac animated fadeInLeftShort delay-750">Bank Partner</h3>
                <div class="w-logo-dt animated fadeInUpShort delay-750">
                  <div class="w-logo"><img src="../../assets/images/BIDV-LOGO.jpg" class="img-responsive" alt="BIDV" />
                  </div>
                  <div class="w-logo"><img src="../../assets/images/Hd-Bank-01.png" class="img-responsive"
                      alt="HDBank" />
                  </div>
                  <div class="w-logo"><img src="../../assets/images/Logo-Pvcombank.png" class="img-responsive"
                      alt="PVcomBank" /></div>
                  <div class="w-logo"><img src="../../assets/images/NCB-LOGO.png" class="img-responsive" alt="NCB" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
    </section>
  </div>
</template>
