export default function useJqueryPlugins() {
    const initFancybox = () => {
      if (!window.$) return
      $('[data-fancybox="gallery-1"]').fancybox()
      $('[data-fancybox="gallery-2"]').fancybox()
      $('[data-fancybox="gallery"]').fancybox()
      $('[data-fancybox="gallery-lv"]').fancybox()
      $('[data-fancybox]').fancybox({
        toolbar: false, smallBtn: true, iframe: { preload: false }
      })
    }
  
    const initMatchHeight = (selector) => {
      if (!window.$ || !selector) return
      try { $(selector).matchHeight() } catch (e) {}
    }
  
    const initNiceScroll = (selector) => {
      if (!window.$ || !selector) return
      try { $(selector).niceScroll() } catch (e) {}
    }
  
    const destroyAll = () => {
      // fancybox không cần destroy thủ công
      try { $('.owl-carousel').trigger('destroy.owl.carousel') } catch (e) {}
    }
  
    return { initFancybox, initMatchHeight, initNiceScroll, destroyAll }
  }
  