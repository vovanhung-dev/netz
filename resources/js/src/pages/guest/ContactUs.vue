<script setup lang="ts">
import { ref, reactive, onMounted, onUnmounted, nextTick } from 'vue'
import { useAnimateOnScroll } from '../../composables/useAnimateOnScroll'
import useJqueryPlugins from '../../composables/useJqueryPlugins'
import http from '../../api/http'
import Swal from 'sweetalert2'
useAnimateOnScroll()
useJqueryPlugins?.()

const bannerUrl = new URL('../../assets/images/about/khu-vui-choi-sasuke.jpg', import.meta.url).href

type SendState = null | 'ok' | 'fail'
const form = reactive({
  name: '',
  phone: '',
  email: '',
  content: '',
})
const submitting = ref(false)
const sent = ref<SendState>(null)
const errors = reactive<Record<string, string | null>>({
  name: null,
  phone: null,
  email: null,
  content: null,
})

function initLegacyOnPage() {
  const w = window as any
  const $ = w.jQuery || w.$
  if (!$) return

  try { $('[data-fancybox]').fancybox?.({ toolbar: false, smallBtn: true, iframe: { preload: false } }) } catch { }
  try { $.fn?.matchHeight && $('.height_cus').matchHeight() } catch { }
  try { $.fn?.niceScroll && $('.w-chinhsach').niceScroll() } catch { }
}

onMounted(async () => {
  document.body.classList.add('site')
  await nextTick()
  requestAnimationFrame(initLegacyOnPage)
})

onUnmounted(() => {
  document.body.classList.remove('site')
})

/** ----- FE validate đơn giản (khớp với BE) ----- */
const phoneRe = /^[0-9+()\s-]{6,}$/
const emailRe = /^\S+@\S+\.\S+$/

function validate(): boolean {
  errors.name = form.name.trim() ? null : 'Name is required'
  errors.phone = form.phone.trim() && phoneRe.test(form.phone) ? null : 'Phone is required / invalid'
  errors.email = form.email.trim() && !emailRe.test(form.email) ? 'Email is invalid' : null
  // content optional
  return !errors.name && !errors.phone && !errors.email
}
const Toast = Swal.mixin({
  toast: true, position: 'top-start', showConfirmButton: false, timer: 3000, timerProgressBar: true,
  didOpen: (t: any) => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer) }
})
/** ----- Submit tới API Laravel: POST /api/contact/send ----- */
async function submit() {
  sent.value = null
  if (!validate()) return

  submitting.value = true
  try {
    const res = await http.post('/api/contact/send', {
      name: form.name.trim(),
      phone: form.phone.trim(),
      email: form.email.trim() || null,
      content: form.content.trim() || null,
    })
    Toast.fire({ icon: 'success', title: res.data?.message || 'Created' })
    sent.value = 'ok'
    // reset form
    form.name = ''
    form.phone = ''
    form.email = ''
    form.content = ''
    Object.keys(errors).forEach(k => (errors[k] = null))
  } catch (e: any) {
    sent.value = 'fail'
    // map lỗi từ Laravel FormRequest: { errors: {field: [msg]} }
    const ve = e?.response?.data?.errors
    if (ve && typeof ve === 'object') {
      errors.name = ve.name?.[0] ?? null
      errors.phone = ve.phone?.[0] ?? null
      errors.email = ve.email?.[0] ?? null
      errors.content = ve.content?.[0] ?? null
    }
    Toast.fire({ icon: 'error', title: e?.response?.data?.message || 'Send failed' })
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <div id="fullpage">
    <!-- Banner -->
    <section class="section banner-page">
      <div class="p-recruitment bannner-t" :style=" `background: url(${ bannerUrl }) center top no-repeat` ">
        <div class="breadcrumb-b">
          <div class="container">
            <div class="row">
              <div class="br-dl">
                <span class="home-breadc">Home</span>
                <span class="breadcrumb-2">Liên hệ với chúng tôi</span>
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
            <span class="breadcrumb-2">Liên hệ với chúng tôi</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <section class="section p-section-about">
      <div class="content-page">
        <div class="page-section bg-ico animatedParent" id="contact">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 header-contact fadeInUpShort delay-250 animated">
                <h1 class="big-title-h">Liên hệ với chúng tôi</h1>
              </div>

              <div class="clearfix"></div>

              <!-- Left info -->
              <div class="col-sm-6 col-lg-4 no-padding text-center">
                <div class="clearfix"></div>
                <div class="left-contact fadeInLeftShort delay-500 animated">
                  <h2 class="title-ct">Thông tin liên hệ</h2>
                  <ul class="mt-4">
                    <li class="address">
                      T15-48, đường số T15, khu The Manhattan Glory,<br />
                      phường Long Thạnh Mỹ, Thành phố Thủ Đức, Thành phố Hồ Chí Minh
                    </li>
                    <li class="hotline-f">Hotline: 0765 799 799 – 0906 653 098</li>
                    <li class="email-f">Email: skylove.academy@gmail.com</li>
                  </ul>
                </div>
              </div>

              <!-- Right form -->
              <div class="col-sm-6 col-lg-6 form-contact fadeInRightShort delay-500 animated">
                <div class="w-contact-r">
                  <h2 class="title-ct text-center">Form liên hệ</h2>

                  <form class="wpcf7-form" @submit.prevent=" submit " aria-label="Form liên hệ" novalidate>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p>
                            <input class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control"
                              type="text" name="your-name" placeholder="Your Name (*)" v-model=" form.name "
                              :aria-invalid=" !!errors.name " maxlength="400" />
                            <small v-if="errors.name" class="text-danger">{{ errors.name }}</small>
                          </p>
                        </div>

                        <div class="form-group">
                          <p>
                            <input
                              class="wpcf7-form-control wpcf7-tel wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-tel form-control"
                              type="tel" name="your-phone" placeholder="Phone Number (*)" v-model=" form.phone "
                              :aria-invalid=" !!errors.phone " maxlength="400" />
                            <small v-if="errors.phone" class="text-danger">{{ errors.phone }}</small>
                          </p>
                        </div>

                        <div class="form-group">
                          <p>
                            <input
                              class="wpcf7-form-control wpcf7-email wpcf7-text wpcf7-validates-as-email form-control"
                              type="email" name="your-email" placeholder="Email" v-model=" form.email "
                              :aria-invalid=" !!errors.email " maxlength="400" />
                            <small v-if="errors.email" class="text-danger">{{ errors.email }}</small>
                          </p>
                        </div>

                        <div class="form-group">
                          <p>
                            <textarea class="wpcf7-form-control wpcf7-textarea form-control" name="your-content"
                              placeholder="Content" v-model=" form.content " rows="8" maxlength="300" />
                          </p>
                        </div>

                        <p>
                          <button class="wpcf7-form-control wpcf7-submit has-spinner form-control" type="submit"
                            :disabled=" submitting ">
                            <span v-if="!submitting">Gửi</span>
                            <span v-else>Đang gửi…</span>
                          </button>
                        </p>

                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped lang="scss">
.text-danger {
  color: #d32f2f;
  font-size: 12px;
}
</style>
