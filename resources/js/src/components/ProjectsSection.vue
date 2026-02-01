<script setup lang="ts"></script>
<template>
  <section id="project" class="section section-project">
    <div class="container">
      <div class="row">
        <div class="w-head-proj">
          <h2 class="title-left">{{ $t('projects.title') }}</h2>
          <div class="view-more right"><a href="#project-list">{{ $t('projects.viewMore') }}</a></div>
        </div>
        <div class="clearfix"></div>
        <div class="w-project-hot row">
          <div class="col-sm-12 col-md-7 projec-big">
            <a href="#" target="_blank">
              <div class="w-pro-hot">
                <div class="img-anima">
                  <img class="img-responsive" :alt="$t('projects.p1')" src="https://netland.com.vn/wp-content/uploads/2025/09/welltone-luxury-residence-1.jpg" />
                </div>
                <h3 class="name-proj"><span class="num-pro">01</span>{{ $t('projects.p1') }}</h3>
              </div>
            </a>
          </div>
          <div class="col-sm-12 col-md-5 projec-small">
            <div class="list-pro">
              <a href="#" target="_blank">
                <div class="w-pro-hot">
                  <div class="img-anima">
                    <img class="img-responsive" :alt="$t('projects.p2')" src="https://netland.com.vn/wp-content/uploads/2025/09/aria-vung-tau-1-1.jpg" />
                  </div>
                  <h3 class="name-proj"><span class="num-pro">02</span>{{ $t('projects.p2') }}</h3>
                </div>
              </a>
            </div>
            <div class="list-pro">
              <a href="#" target="_blank">
                <div class="w-pro-hot">
                  <div class="img-anima">
                    <img class="img-responsive" :alt="$t('projects.p3')" src="https://netland.com.vn/wp-content/uploads/2025/09/takashi-oceansuite-ky-co-2.jpg" />
                  </div>
                  <h3 class="name-proj"><span class="num-pro">03</span>{{ $t('projects.p3') }}</h3>
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
