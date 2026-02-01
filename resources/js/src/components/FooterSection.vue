<script setup lang="ts">
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
useAnimateOnScroll()

const logoWhite = new URL('@/assets/images/logo.png', import.meta.url).href
const fbPage = 'https://www.facebook.com/skyloveacademy';
const icoFacebook = new URL('@/assets/images/facebook.svg', import.meta.url).href
const icoYoutube = new URL('@/assets/images/youtube.svg', import.meta.url).href
</script>

<template>
  <footer class="site-footer">
    <div class="container animatedParent">
      <div class="row cols">
        <div class="col col-12 col-md-6 col-lg-3 animated fadeInUpShort delay-0">
          <h4 class="ft-title">Giới thiệu</h4>
          <span class="ft-underline" />
          <p class="ft-desc">
            Học viện hướng tới mục tiêu là đối tác cung ứng nguồn nhân lực ngành Hàng Không, Dịch vụ,
            Du lịch Chất lượng, nâng cao hiệu quả công việc và vị thế ngành.
          </p>
        </div>

        <div class="col col-12 col-md-6 col-lg-3 animated fadeInUpShort delay-150">
          <h4 class="ft-title">Trụ sở chính</h4>
          <span class="ft-underline" />
          <p class="ft-company"><strong>Công ty Cổ phần Đào tạo Kỹ năng Nghiệp vụ Hàng không Skylove</strong></p>
          <p class="ft-address">
            Địa chỉ: Số1 T15-48, đường T15 Khu The Manhattan Glory, phường Long Thạnh Mỹ, TP. Thủ Đức, TP. Hồ Chí Minh
          </p>
        </div>

        <div class="col col-12 col-md-6 col-lg-3 animated fadeInUpShort delay-300">
          <h4 class="ft-title">Liên hệ</h4>
          <span class="ft-underline" />
          <ul class="ft-contact">
            <li><span class="label">Hotline:</span> <a href="tel:0906653098">0906653098</a></li>
            <li><span class="label">Email:</span> <a
                href="mailto:skylove.academy@gmail.com">skylove.academy@gmail.com</a></li>
          </ul>
        </div>

        <div class="col col-12 col-md-6 col-lg-3 animated fadeInUpShort delay-450">
          <h4 class="ft-title">Theo dõi chúng tôi</h4>
          <span class="ft-underline" />

          <div class="fb-embed animated fadeInUpShort delay-450">
            <iframe
              :src=" `https://www.facebook.com/plugins/page.php?href=${ encodeURIComponent(fbPage) }&tabs=timeline&width=340&height=180&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true` "
              width="340" height="180" style="border:none;overflow:hidden" title="Skylove Academy Facebook Page"
              allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
          </div>
          <div class="ft-social">
            <a href="#" aria-label="Facebook" class="ico">
              <img :src=" icoFacebook " alt="Facebook" />
            </a>
            <a href="#" aria-label="YouTube" class="ico">
              <img :src=" icoYoutube " alt="YouTube" />
            </a>
            <a href="#" aria-label="TikTok" class="ico">
              <i class="fa-brands fa-tiktok"></i>
            </a>
          </div>
        </div>
      </div>

      <div class="ft-bottom animated fadeInUpShort delay-600">
        <img :src=" logoWhite " alt="Logo" class="ft-logo" />
        <div class="copy">© {{ new Date().getFullYear() }} Skylove Academy. All rights reserved.</div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.site-footer {
  background: #2e4250;
  color: #fff;
  padding: 48px 0 28px;
}

.cols {
  row-gap: 28px;
}

.ft-title {
  font-size: 18px;
  font-weight: 700;
  margin: 0 0 8px 0;
}

.ft-underline {
  display: block;
  width: 48px;
  height: 4px;
  background: #ff5a3d;
  border-radius: 2px;
  margin-bottom: 14px;
}

.ft-desc,
.ft-company,
.ft-address {
  opacity: 0.9;
  line-height: 1.6;
  margin: 0 0 8px 0;
}

.ft-contact {
  list-style: none;
  padding: 0;
  margin: 0;
}

.ft-contact li {
  margin: 6px 0;
}

.ft-contact .label {
  opacity: 0.8;
  margin-right: 6px;
}

.fb-embed {
  border-radius: 10px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, .08);
  background: #1f2d38;
  margin-bottom: 14px;
}

/* Responsive theo chiều ngang cột */
.fb-embed iframe {
  width: 100%;
  height: 180px;
  /* có thể tăng lên 200–220 cho thoáng hơn */
  display: block;
}

.fb-card {
  position: relative;
  border-radius: 10px;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, .08);
  background: #1f2d38;
  margin-bottom: 14px;
}

.fb-card img {
  display: block;
  width: 100%;
  height: auto;
}

.fb-badge {
  position: absolute;
  left: 10px;
  bottom: 10px;
  background: rgba(0, 0, 0, .55);
  padding: 6px 10px;
  border-radius: 999px;
  font-size: 12px;
}

.ft-social {
  display: flex;
  align-items: center;
  gap: 16px;
}

.ft-social .ico {
  display: inline-flex;
  width: 36px;
  height: 36px;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  background: rgba(255, 255, 255, .08);
  transition: transform .2s ease, background .2s ease;
  text-decoration: none;
  color: #fff;
}

.ft-social .ico:hover {
  transform: translateY(-2px);
  background: rgba(255, 255, 255, .18)
}

.ft-social img {
  width: 18px;
  height: 18px;
  display: block
}

.ft-bottom {
  border-top: 1px solid rgba(255, 255, 255, .08);
  margin-top: 28px;
  padding-top: 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  flex-wrap: wrap;
  opacity: .9;
}

.ft-logo {
  height: 28px;
  width: auto;
}

.copy {
  font-size: 13px;
}
</style>
