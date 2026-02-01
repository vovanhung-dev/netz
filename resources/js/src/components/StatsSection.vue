<script setup lang="ts"></script>
<template>
  <section class="section section-develope">
    <div class="container">
      <div class="row">
        <h2 class="title-left">{{ $t('stats.title') }}</h2>
        <div class="clearfix"></div>
        <div class="row w-develope">
          <div class="col-sm-6 col-lg-4 g-number">
            <div class="w-pro project">
              <div class="number"><p><span class="count">20</span> +</p></div>
              <div class="des-dev">{{ $t('stats.projects') }}</div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 g-number">
            <div class="w-pro acreage">
              <div class="number"><p><span class="count">15000</span> +</p></div>
              <div class="des-dev">{{ $t('stats.customers') }}</div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 g-number">
            <div class="w-pro staff">
              <div class="number"><p><span class="count">15</span> +</p></div>
              <div class="des-dev">{{ $t('stats.partners') }}</div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 g-number">
            <div class="w-pro province">
              <div class="number"><p><span class="count">14</span> +</p></div>
              <div class="des-dev">{{ $t('stats.provinces') }}</div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4 g-number">
            <div class="w-pro apart">
              <div class="number"><p>20 +</p></div>
              <div class="des-dev">{{ $t('stats.awards') }}</div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </section>
</template>
