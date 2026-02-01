<!-- new -->
<template>
  <section id="about" class="section section-about animatedParent">
    <div class="container">
      <div class="row align-center">
        <div class="col-12 col-lg-6 left-about">
          <div class="logo-ab animated fadeInLeftShort delay-250">
            <img :src="logoUrl" class="img-responsive" alt="Giới thiệu Netland" />
          </div>
          <h2 class="title-about animated fadeInRightShort delay-250">VỀ SKYLOVE</h2>
          <div class="clearfix"></div>
          <div class="w-des-ab animated fadeInLeftShort delay-500">
            <strong>Mục Tiêu Đào Tạo Của Skylove</strong>
            <br />
            Chúng tôi tập trung vào mục tiêu đào tạo các kỹ năng thi tuyển các vị trí ngành Hàng Không, Dịch vụ, Du lịch
            điển hình như: Kỹ năng xây dựng hình ảnh, kỹ năng phỏng vấn, kỹ năng giao tiếp, xử lý tình huống, tiếng
            Anh.<br />-> Bứt phá giới hạn của bản thân<br />-> TÂM - TẦM - TÀI<br />-> Môi trường làm việc bậc nhất
            <br />
          </div>
          <p class="view-more animated fadeInLeftShort delay-750">
            <router-link to="/about-us" class="primary-btn">Xem thêm</router-link>
          </p>
        </div>

        <div class="col-12 col-lg-6 right-about animated fadeInUpShort delay-250">
          <img :src="aboutImg" class="img-responsive" alt="Giới thiệu Netland" />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
useAnimateOnScroll()

const logoUrl = new URL('@/assets/images/logo.png', import.meta.url).href
const aboutImg = new URL('@/assets/images/HINHVECTY.jpg', import.meta.url).href
</script>
