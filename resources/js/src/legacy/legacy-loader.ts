// type ScriptItem = { src: string; check?: () => boolean }

// function loadScript(item: ScriptItem): Promise<void> {
//   if (item.check && item.check()) return Promise.resolve()

//   return new Promise((resolve, reject) => {
//     const s = document.createElement('script')
//     s.src = item.src
//     s.async = false
//     s.onload = () => resolve()
//     s.onerror = () => reject(new Error('Failed to load ' + item.src))
//     document.head.appendChild(s)
//   })
// }

// const LEGACY_SCRIPTS: ScriptItem[] = [
//   { src: '../assets/js/jquery-3.4.1.min.js', check: () => !!(window as any).jQuery },

//   { src: '../assets/js/masterslider.min.js' },
//   { src: '../assets/js/bootstrap.min.js' },
//   { src: '../assets/js/jquery.slicknav.js' },
//   { src: '../assets/js/owl.carousel.min.js' },
//   { src: '../assets/js/slick.min.js' },
//   { src: '../assets/js/css3-animate-it.js' },
//   { src: '../assets/js/jquery.matchHeight-min.js' },
//   { src: '../assets/js/jquery.fancybox.js' },
//   { src: '../assets/js/jquery.nicescroll.min.js' },
//   { src: '../assets/js/homepage.js' },
//   { src: '../assets/js/script-custom.js' },
//   { src: '../assets/js/my-custom.js' },
//   { src: '../assets/js/gioithieu.js' },
// ]

// let loaded = false

// export async function loadLegacyScripts() {
//   if (loaded) return
//   for (const item of LEGACY_SCRIPTS) {
//     await loadScript(item)
//   }

//   const $ = (window as any).jQuery || (window as any).$
//   if ($) {
//     ;(window as any).$ = $
//     ;(window as any).jQuery = $
//   }

//   loaded = true
// }

// export function legacyReady(): boolean {
//   const w = window as any
//   return !!(w.jQuery && w.$)
// }


type ScriptItem = { src: string; check?: () => boolean }
let loaded = false

function loadScript(item: ScriptItem): Promise<void> {
  if (item.check && item.check()) return Promise.resolve()

  return new Promise((resolve, reject) => {
    const s = document.createElement('script')
    s.src = item.src
    s.async = false
    s.onload = () => resolve()
    s.onerror = () => reject(new Error('Failed to load ' + item.src))
    document.head.appendChild(s)
  })
}

// Build URL đúng tới file trong src (Vite sẽ phục vụ URL asset chuẩn)
const legacy = (file: string) =>
  new URL(`../assets/js/${file}`, import.meta.url).href

const LEGACY_SCRIPTS: ScriptItem[] = [
  { src: legacy('jquery-3.4.1.min.js'), check: () => !!(window as any).jQuery },
  { src: legacy('bootstrap.min.js') },
  { src: legacy('jquery.slicknav.js') },
  { src: legacy('owl.carousel.min.js') },
  { src: legacy('slick.min.js') },
  { src: legacy('css3-animate-it.js') },
  { src: legacy('jquery.matchHeight-min.js') },
  { src: legacy('jquery.fancybox.js') },
  { src: legacy('jquery.nicescroll.min.js') },
  { src: legacy('homepage.js') },
  { src: legacy('script-custom.js') },
  { src: legacy('my-custom.js') },
  { src: legacy('gioithieu.js') },
]

export async function loadLegacyScripts() {
  if (loaded) return
  for (const item of LEGACY_SCRIPTS) {
    try {
      await loadScript(item)
    } catch (e) {
      console.warn('Failed to load legacy script:', item.src, e)
    }
  }

  // Expose jQuery global (phòng trường hợp plugin yêu cầu)
  const $ = (window as any).jQuery || (window as any).$
  if ($) {
    ;(window as any).$ = $
    ;(window as any).jQuery = $
  }

  loaded = true
}

export function legacyReady(): boolean {
  const w = window as any
  return !!(w.jQuery && w.$)
}
