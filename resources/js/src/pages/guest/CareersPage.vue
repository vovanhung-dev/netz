<script setup lang="ts">
import { ref, onMounted, onUnmounted, nextTick, computed } from 'vue'
import { useAnimateOnScroll } from '@/composables/useAnimateOnScroll'
import useJqueryPlugins from '@/composables/useJqueryPlugins'
import http from '@/api/http'
import VPagination from '@hennge/vue3-pagination'
import '@hennge/vue3-pagination/dist/vue3-pagination.css'
import Swal from 'sweetalert2'

const Toast = Swal.mixin({
  toast: true, position: 'center-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
  didOpen: (t: any) => { t.addEventListener('mouseenter', Swal.stopTimer); t.addEventListener('mouseleave', Swal.resumeTimer) }
})

useAnimateOnScroll()
const { initFancybox, initMatchHeight, initNiceScroll, destroyAll } = useJqueryPlugins()

/* ===== Sticky anchors ===== */
const isScrollNavi = ref(false)
const stickyOffset = 0
const anchorsSectionEl = ref<HTMLElement | null>(null) // (FIX tên ref)
let ticking = false
function computeScrollNavi() {
  if (!anchorsSectionEl.value) return
  const sectionTop = anchorsSectionEl.value.offsetTop - stickyOffset
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

const bannerUrl = new URL('../../assets/images/about/khu-vui-choi-sasuke.jpg', import.meta.url).href
const policyImg = new URL('../../assets/images/project/HR-final.jpg', import.meta.url).href

/* ===== Data & API integration ===== */
type Job = { no: string; title: string; qty: string; exp: string; id: string | number; bodyHtml: string }

// state
const jobs = ref<Job[]>([])
const loading = ref(false)
const errorMsg = ref('')

const page = ref(1)
const perPage = ref(10)
const lastPage = ref(1)
const pageCount = computed(() => Math.max(1, lastPage.value))

function mapJob(row: any, idx: number, pageIndexBase = 0): Job {
  const title = row?.title ?? row?.name ?? row?.position ?? ''
  const qtyRaw = row?.quantity ?? row?.qty ?? row?.number ?? ''
  const expRaw = row?.expired_at ?? row?.expire_at ?? row?.exp ?? row?.expiration_date ?? ''
  const bodyHtml = row?.body_html ?? row?.description_html ?? row?.description ?? row?.body ?? ''
  const id = row?.id ?? `${ Date.now() }-${ idx }`
  const no = String((page.value - 1) * perPage.value + idx + 1 + pageIndexBase).padStart(2, '0')

  let exp = ''
  if (typeof expRaw === 'string' && /^\d{4}-\d{2}-\d{2}/.test(expRaw)) {
    const d = new Date(expRaw)
    const dd = String(d.getDate()).padStart(2, '0')
    const mm = String(d.getMonth() + 1).padStart(2, '0')
    const yyyy = d.getFullYear()
    exp = `${ dd }/${ mm }/${ yyyy }`
  } else {
    exp = String(expRaw || '')
  }

  return { no, title, qty: String(qtyRaw || ''), exp, id, bodyHtml }
}

async function loadJobs() {
  loading.value = true
  errorMsg.value = ''
  try {
    const { data } = await http.get('/api/careers', {
      params: {
        status: 'open',
        page: page.value,
        per_page: perPage.value,
      },
    })

    const list = Array.isArray(data?.data) ? data.data : (Array.isArray(data) ? data : [])
    jobs.value = list.map((row: any, idx: number) => mapJob(row, idx))

    if (data?.meta) {
      lastPage.value = data.meta.last_page ?? 1
      page.value = data.meta.current_page ?? page.value
    } else {
      lastPage.value = 1
    }

    openId.value = jobs.value.length ? jobs.value[0].id : null
  } catch (e: any) {
    Toast.fire({ icon: 'error', title: e?.response?.data?.message || e?.message || 'Load jobs failed' })
    errorMsg.value = e?.response?.data?.message || e?.message || 'Load jobs failed'
    jobs.value = []
  } finally {
    loading.value = false
  }
}
const submitting = ref(false)
const successMsg = ref('')
const fileObj = ref<File | null>(null)

const cv = ref({
  name: '',
  phone: '',
  email: '',
  position: '',
  address: '',
})

function onFileChange(e: Event) {
  const input = e.target as HTMLInputElement
  const f = input.files?.[0] || null
  fileObj.value = f
}

async function submitCV() {
  successMsg.value = ''
  errorMsg.value = ''
  if (!fileObj.value) {
    errorMsg.value = 'Please attach your CV (PDF/DOC/DOCX).'
    return
  }
  const okType = ['application/pdf', 'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
  if (!okType.includes(fileObj.value.type)) {
    Toast.fire({ icon: 'error', title: 'Only PDF/DOC/DOCX are allowed.' })
    return
  }
  if (fileObj.value.size > 5 * 1024 * 1024) {
    Toast.fire({ icon: 'error', title: 'File must be ≤ 5MB.' })
    return
  }

  const form = new FormData()
  form.append('name', cv.value.name)
  form.append('phone', cv.value.phone)
  form.append('email', cv.value.email)
  form.append('position', cv.value.position)
  form.append('address', cv.value.address)
  form.append('cv_file', fileObj.value) // tên field backend

  submitting.value = true
  try {
    await http.post('/api/careers/apply', form, {
      headers: { 'Content-Type': 'multipart/form-data' },
    })
    Toast.fire({ icon: 'success', title: 'Your application has been sent. Thank you!' })
    // reset form
    cv.value = { name: '', phone: '', email: '', position: '', address: '' }
    fileObj.value = null
    // clear file input
    const inputs = document.querySelectorAll('input[type="file"][name="your-file"]') as NodeListOf<HTMLInputElement>
    inputs.forEach(i => (i.value = ''))
  } catch (e: any) {
    Toast.fire({ icon: 'error', title: e?.response?.data?.message || 'Failed to send application. Please try again.' })
  } finally {
    submitting.value = false
  }
}
/* ===== Toggle job panel ===== */
const openId = ref<string | number | null>(null)
function toggle(jobId: string | number) {
  openId.value = openId.value === jobId ? null : jobId
}
function isOpen(jobId: string | number) {
  return openId.value === jobId
}
function onPageChange(newPage: number) {
  if (newPage === page.value) return
  page.value = newPage
  loadJobs()
  window.scrollTo({ top: anchorsSectionEl.value?.offsetTop ?? 0, behavior: 'smooth' })
}

/* ===== Lifecycle ===== */
onMounted(async () => {
  document.body.classList.add('site', 'page', 'courses') // Thay 'careers' thành 'courses'
  try { initFancybox() } catch { }
  try { initMatchHeight('.height_cus') } catch { }
  try { initNiceScroll('.w-chinhsach, #boxscroll') } catch { }

  await loadJobs()
  await nextTick()

  window.addEventListener('scroll', onScrollOrResize, { passive: true })
  window.addEventListener('resize', onScrollOrResize)
  computeScrollNavi()
})

onUnmounted(() => {
  document.body.classList.remove('site', 'page', 'courses') // Thay 'careers' thành 'courses'
  try { destroyAll() } catch { }
  window.removeEventListener('scroll', onScrollOrResize)
  window.removeEventListener('resize', onScrollOrResize)
})
</script>

<template>
  <div id="fullpage">
    <div class="section banner-page">
      <div class="p-recruitment bannner-t" :style=" `background: url(${ bannerUrl }) center top no-repeat` ">
        <div class="breadcrumb-b">
          <div class="container">
            <div class="row">
              <div class="br-dl">
                <span class="home-breadc">Home</span><span class="breadcrumb-2">Tuyển dụng</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="breadcrumb-b des_tab">
      <div class="container">
        <div class="row">
          <div class="br-dl">
            <span class="home-breadc">Home</span><span class="breadcrumb-2">Tuyển dụng</span>
          </div>
        </div>
      </div>
    </div>

    <div ref="anchorsSectionEl" class="section p-section-about" :class=" { 'scroll-navi': isScrollNavi } ">
      <div class="header-breadcrumb animatedParent">
        <div class="container">
          <div class="row align-center">
            <div class="logo-b animated fadeInLeftShort delay-250">
              <img src="@/assets/images/logo.png" class="img-responsive" alt="Khóa học" />
            </div>
            <div class="right-b animated fadeInRightShort delay-250">
              <nav id="mainNav" class="navigation">
                <a class="navigation__link" href="#philosophy">Triết lý đào tạo</a>
                <a class="navigation__link active" href="#available-courses">Phần tuyển dụng</a>
                <a class="navigation__link" href="#register">Đăng ký ngay</a>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <div class="content-page">
        <div id="philosophy" class="page-section bg-ico animatedParent chinhsachnhansu" data-anchor="philosophy">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-6 p-left-about p-left0">
                <div class="ico-section padding-ico ico-tuyendung animated fadeInLeftShort delay-250">
                  <h1 class="small-title-h margin-b0">Tham gia cùng chúng tôi</h1>
                  <h2 class="big-title-h">Triết lý đào tạo</h2>
                </div>
                <div class="clearfix"></div>

                <div class="w-chinhsach animated fadeInUpShort delay-500" tabindex="1"
                  style="overflow:hidden;outline:none;">
                  <div id="boxscroll" class="cont-chinhsach scrollbar-deep-purple bordered-deep-purple thin"
                    tabindex="2" style="overflow:hidden;outline:none;">
                    <h2>Làm Việc Thực Tế</h2>
                    <p>Chúng tôi tin vào việc học thông qua thực hành. Các khóa học được thiết kế tập trung vào ứng dụng
                      thực tế, các dự án trong thế giới thực và workshop tương tác để đảm bảo bạn có được những kỹ năng
                      hữu hình.</p>
                    <h2>Giảng viên chuyên gia</h2>
                    <p>Học hỏi từ những người giỏi nhất trong ngành. Giảng viên của chúng tôi là những chuyên gia giàu
                      kinh nghiệm, đam mê chia sẻ kiến thức và dìu dắt thế hệ tài năng tiếp theo.</p>
                    <h2>Cộng đồng hỗ trợ</h2>
                    <p>Tham gia một cộng đồng sôi động của những người học và sáng tạo. Chúng tôi thúc đẩy một môi
                      trường hợp tác nơi học viên có thể kết nối, chia sẻ ý tưởng và cùng nhau phát triển, cả trong và
                      sau khóa học.</p>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 col-lg-6 p-right-tdung animated fadeInUpShort delay-250">
                <img :src=" policyImg " class="img-responsive" alt="Môi trường học tập" />
              </div>
            </div>
          </div>
        </div>

        <div id="available-courses" class="page-section animatedParent vitrituyendung" data-anchor="available-courses">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 w-vitrituyendung no-padding">
                <div class="ico-section padding-ico ico-vitritd animated fadeInLeftShort delay-250">
                  <h2 class="small-title-h margin-b0">Chương trình của chúng tôi</h2>
                  <h2 class="big-title-h">Các khóa học hiện có</h2>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="col-sm-12 col-lg-12 vitritd no-padding animated FadeInUpShort delay-250">
                <div class="header-vit">
                  <ul>
                    <li class="stt-td">STT</li>
                    <li class="vtri-td">Tên khóa học</li>
                    <li class="sl-td">Số lượng</li>
                    <li class="nhh-td">Hạn đăng ký</li>
                  </ul>
                  <div class="clearfix"></div>
                </div>

                <div class="toogle-tuyendung animated fadeInUpShort delay-500">
                  <div v-if="loading" class="loading-box">Đang tải danh sách khóa học…</div>
                  <div v-else-if="errorMsg" class="error-box">{{ errorMsg }}</div>

                  <div v-else id="accordion">
                    <div v-if="!jobs.length" class="empty-box">Hiện chưa có khóa học nào. Vui lòng quay lại sau.</div>

                    <div v-for="job in jobs" :key=" job.id " class="card">
                      <div :id=" `heading${ job.id }` ">
                        <a href="#" class="btn btn-link" :class=" { collapsed: !isOpen(job.id) } " role="button"
                          :aria-expanded=" isOpen(job.id) " :aria-controls=" `vttd${ job.id }` "
                          @click.prevent="toggle(job.id)">
                          <ul>
                            <li class="stt-td">{{ job.no }}</li>
                            <li class="vtri-td">{{ job.title }}</li>
                            <li class="sl-td">{{ job.qty }}</li>
                            <li class="nhh-td">{{ job.exp }}</li>
                            <li class="apply-cv">
                              <button type="button" class="btn-apply">Chi tiết</button>
                            </li>
                          </ul>
                          <div class="clearfix"></div>
                        </a>
                      </div>

                      <div :id=" `vttd${ job.id }` " class="collapse" :class=" { show: isOpen(job.id) } "
                        :aria-labelledby=" `heading${ job.id }` ">
                        <div class="card-body" v-show=" isOpen(job.id) " v-html=" job.bodyHtml "></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="pageCount > 1" class="pagination-wrap animated fadeInUpShort delay-750">
                  <v-pagination v-model=" page " :pages=" pageCount " :range-size=" 1 " active-color="#3ea9e0"
                    hide-first-button hide-last-button @update:modelValue=" onPageChange " />
                  <label class="pg-size">
                    <span>Hiển thị</span>
                    <select v-model.number=" perPage " @change=" () => { page = 1; loadJobs() } ">
                      <option :value=" 5 ">5</option>
                      <option :value=" 10 ">10</option>
                      <option :value=" 15 ">15</option>
                    </select>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="register" class="page-section animatedParent cv-apply nophoso" data-anchor="register">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-lg-12 w-nophoso no-padding">
                <div class="ico-section padding-ico ico-nophoso animated fadeInLeftShort delay-250">
                  <h2 class="small-title-h margin-b0">Tham gia cùng chúng tôi</h2>
                  <h2 class="big-title-h">Đăng ký ngay</h2>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="col-md-12 right-form animated fadeInRightShort delay-500">
                <form class="wpcf7-form" aria-label="Form đăng ký" enctype="multipart/form-data"
                  @submit.prevent=" submitCV " novalidate>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <p><input class="form-control" placeholder="Họ và tên (*)" type="text" name="your-name"
                            v-model.trim=" cv.name " required></p>
                      </div>
                      <div class="form-group">
                        <p><input class="form-control" placeholder="Số điện thoại (*)" type="tel" name="your-phone"
                            v-model.trim=" cv.phone " required></p>
                      </div>
                      <div class="form-group-label">
                        <p>Vị trí quan tâm:</p>
                      </div>
                      <div class="form-group">
                        <p><input class="form-control" type="text" name="your-position" v-model.trim=" cv.position ">
                        </p>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <p><input class="form-control" placeholder="Email (*)" type="email" name="your-email"
                            v-model.trim=" cv.email " required>
                        </p>
                      </div>
                      <div class="form-group">
                        <p><input class="form-control" placeholder="Ghi chú thêm" type="text" name="your-address"
                            v-model.trim=" cv.address "></p>
                      </div>
                      <div class="form-group-label">
                        <p>Tải lên tài liệu (nếu có, chỉ nhận word hoặc pdf):</p>
                      </div>
                      <div class="form-group">
                        <p><input class="form-control" accept=".doc,.docx,.pdf" type="file" name="your-file"
                            @change=" onFileChange " required>
                        </p>
                      </div>
                      <p><input class="wpcf7-form-control wpcf7-submit has-spinner form-control" type="submit"
                          :disabled=" submitting " value="Gửi đăng ký"><span class="wpcf7-spinner"></span>
                      </p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.loading-box,
.error-box,
.empty-box {
  padding: 16px;
  border-radius: 10px;
  background: #fafafa;
  border: 1px dashed #e5e7eb;
  text-align: center;
  color: #666;
}

.pagination-wrap {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 24px 0 8px;
  flex-wrap: wrap;
}

.pg-size {
  margin-left: auto;
  display: flex;
  align-items: center;
  gap: 8px;
}

.pg-size select {
  height: 36px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  padding: 0 10px;
  background: #fff;
}
</style>