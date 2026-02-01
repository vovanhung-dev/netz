import { ref, onMounted, onBeforeUnmount } from 'vue'

export function useStickyHeader(selector = '#header') {
  const isSticky = ref(false)
  const onScroll = () => {
    isSticky.value = window.scrollY > 0
    const el = document.querySelector(selector)
    if (el) el.classList.toggle('sticky', isSticky.value)
  }
  onMounted(() => {
    onScroll()
    window.addEventListener('scroll', onScroll, { passive: true })
  })
  onBeforeUnmount(() => window.removeEventListener('scroll', onScroll))
  return { isSticky }
}
