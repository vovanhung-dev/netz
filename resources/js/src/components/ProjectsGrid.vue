<template>
  <section id="project" class="section section-project animatedParent">
    <div class="container">
      <div class="row">
        <div class="w-head-proj">
          <h2 class="title-left animated fadeInLeftShort delay-250">Khóa Học Tiếp Viên Hàng Không</h2>
          <div class="view-more right animated fadeInRightShort delay-750"><a href="#project">Xem thêm</a></div>
        </div>
        <div class="clearfix"></div>

        <div class="w-project-hot row animated fadeInUpShort delay-500">
          <div class="col-sm-12 col-md-7 projec-big">
            <a href="#">
              <div class="w-pro-hot">
                <div class="img-anima"><img :src="p1" class="img-responsive" alt="Welltone Luxury Residence" /></div>
                <h3 class="name-proj"><span class="num-pro">01</span>Khoá đào tạo xây dựng hình ảnh</h3>
              </div>
            </a>
          </div>

          <div class="col-sm-12 col-md-5 projec-small">
            <div class="list-pro">
              <a href="#">
                <div class="w-pro-hot">
                  <div class="img-anima"><img :src="p2" class="img-responsive" alt="Aria Vung Tau" /></div>
                  <h3 class="name-proj"><span class="num-pro">02</span>Khoá phi công (liên kết đào tạo với các hãng hàng
                    không)</h3>
                </div>
              </a>
            </div>
            <div class="list-pro">
              <a href="#">
                <div class="w-pro-hot">
                  <div class="img-anima"><img :src="p3" class="img-responsive" alt="Takashi Ocean Suite Ky Co" /></div>
                  <h3 class="name-proj"><span class="num-pro">03</span>Khoá kỹ năng phỏng vấn</h3>
                </div>
              </a>
            </div>
          </div>

          <div class="clearfix"></div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
useAnimateOnScroll()

const p1 = new URL('@/assets/images/welltone-luxury-residence-1.jpg', import.meta.url).href
const p2 = new URL('@/assets/images/aria-vung-tau-1-1.jpg', import.meta.url).href
const p3 = new URL('@/assets/images/takashi-oceansuite-ky-co-2.jpg', import.meta.url).href
</script>