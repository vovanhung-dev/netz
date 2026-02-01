<script setup lang="ts"></script>
<template>
  <section id="news" class="section section-new">
    <div class="container">
      <div class="row">
        <div class="w-head-proj">
          <h2 class="title-left">{{ $t('news.title') }}</h2>
          <div class="view-more right"><a href="#">{{ $t('news.viewMore') }}</a></div>
        </div>
        <div class="clearfix"></div>
        <div class="w-new-hot row">
          <div class="col-sm-12 col-md-4 new-big">
            <a href="#" target="_blank">
              <div class="wnew-hot">
                <div class="img-anima">
                  <img class="img-responsive" :alt="$t('news.n1')" src="https://netland.com.vn/wp-content/uploads/2025/09/emerging-trends-in-vietnams-real-estate-market-2025-scaled.jpg" />
                </div>
                <div class="w-title-new">
                  <div class="date-post">{{ $t('news.date') }}</div>
                  <h3 class="title-new">{{ $t('news.n1') }}</h3>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
