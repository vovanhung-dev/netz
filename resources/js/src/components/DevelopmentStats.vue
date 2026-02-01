<template>
  <section class="section section-develope animatedParent">
    <div class="container">
      <div class="row">
        <h2 class="title-left animated fadeInLeftShort delay-250">Phát triển</h2>
        <div class="clearfix"></div>
        <div class="row w-develope animated fadeInUpShort delay-500">
          <div class="col-sm-6 col-lg-4 g-number" v-for="it in stats" :key="it.label">
            <div class="w-pro" :class="it.className">
              <div class="number">
                <p><span class="count">{{ it.value }}</span>{{ it.plus ? ' +' : '' }}</p>
              </div>
              <div class="des-dev">{{ it.label }}</div>
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
import { useI18n } from 'vue-i18n'
const { t } = useI18n()
type StatItem = {
  value: number | string
  plus?: boolean
  label: string
  className: string
}

const stats = [
  { value: 20, plus: true, label: "Dự án", className: 'project' },
  { value: 15000, plus: true, label: "Học Viên", className: 'acreage' },
  { value: 15, plus: true, label: "Đối tác", className: 'staff' },
  { value: 14, plus: true, label: "Tỉnh/Thành phố", className: 'province' },
  { value: '20', plus: true, label: "Giải thưởng", className: 'apart' },
]
</script>