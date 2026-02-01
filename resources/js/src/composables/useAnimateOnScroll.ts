import { onMounted, onBeforeUnmount } from 'vue'

export function useAnimateOnScroll(selector = '.animatedParent') {
  let io: IntersectionObserver | null = null

  onMounted(() => {
    io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        const parent = e.target as HTMLElement
        const kids = parent.querySelectorAll<HTMLElement>('.animated')
        if (e.isIntersecting) kids.forEach(k => k.classList.add('go'))
        else kids.forEach(k => k.classList.remove('go'))
      })
    }, { threshold: 0.15 })

    document.querySelectorAll<HTMLElement>(selector).forEach(p => io!.observe(p))
  })

  onBeforeUnmount(() => io?.disconnect())
}
