<!-- <script setup lang="ts">
// Dummy line to make sure <script> is not empty and parsed correctly.
const _ok = true
</script>

<template>
  <section class="section section-partner">
    <div class="container">
      <div class="row">
        <div class="w-head-proj">
          <h2 class="title-left">{{ $t('partner.title') }}</h2>
        </div>
        <div class="clearfix"></div>

        <div class="w-partner">
          <ul class="nav nav-tabs justify-content-end">
            <li class="nav-item">
              <a class="nav-link active" href="#">{{ $t('partner.tab1') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">{{ $t('partner.tab2') }}</a>
            </li>
          </ul>

          <div class="tab-content">
            <div class="owl-carousel partner-slide">
              <div class="item height_cus" style="height:80px">
                <img class="img-responsive" alt="Danh Khoi Holdings"
                     src="https://netland.com.vn/wp-content/uploads/2025/09/Danh-Khoi-Holdings.png" />
              </div>
              <div class="item height_cus" style="height:80px">
                <img class="img-responsive" alt="DKRA Group"
                     src="https://netland.com.vn/wp-content/uploads/2025/09/dkra-group.png" />
              </div>
              <div class="item height_cus" style="height:80px">
                <img class="img-responsive" alt="Apave"
                     src="https://netland.com.vn/wp-content/uploads/2025/09/Apave.svg" />
              </div>
              <div class="item height_cus" style="height:80px">
                <img class="img-responsive" alt="DnD"
                     src="https://netland.com.vn/wp-content/uploads/2025/09/DnD.svg" />
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </section>
</template> -->
<template>
  <section id="news" class="section section-new animatedParent">
    <div class="container">
      <div class="row">
        <div class="w-head-proj">
          <h2 class="title-left animated fadeInLeftShort delay-250">News</h2>
          <div class="view-more right animated fadeInRightShort delay-750"><a href="#news">View more</a></div>
        </div>
        <div class="clearfix"></div>

        <div class="w-new-hot row animated fadeInUpShort delay-500">
          <div class="col-sm-12 col-md-4 new-big">
            <a href="#"><div class="wnew-hot">
              <div class="img-anima">
                <img :src="newsImg" class="img-responsive" alt="Emerging trends in Vietnam’s real estate market 2025" />
              </div>
              <div class="w-title-new">
                <div class="date-post"><span>18</span>09 - 2025</div>
                <h3 class="title-new">Emerging trends in Vietnam’s real estate market 2025</h3>
              </div>
            </div></a>
          </div>
          <div class="col-sm-6 col-md-4 new-small"></div>
          <div class="col-sm-6 col-md-4 new-small"></div>
          <div class="clearfix"></div>
        </div>

      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
useAnimateOnScroll()
const newsImg = new URL('@/assets/images/emerging-trends-in-vietnams-real-estate-market-2025-scaled.jpg', import.meta.url).href
</script>
