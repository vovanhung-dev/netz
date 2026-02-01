import { createApp } from 'vue';
import { createPinia } from 'pinia';
import i18n from './i18n';
import App from './App.vue';
import router from './router';

import '../src/assets/styles/vendor.css';
// import '../src/assets/styles/base.css'

import $ from 'jquery';
// @ts-ignore
window.$ = window.jQuery = $;

// Swiper core styles (cho slider & carousel)
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/autoplay';
import { loadLegacyScripts } from '../src/legacy/legacy-loader';

import ElementTiptapPlugin from 'element-tiptap-vue3-fixed'   // ✅ plugin
import 'element-tiptap-vue3-fixed/lib/style.css'    

import '@/assets/js/jquery-3.4.1.min.js';

import '@fortawesome/fontawesome-free/css/all.min.css';

window.$ = window.jQuery = window.$ || window.jQuery;

const app = createApp(App);

async function bootstrap() {
    await loadLegacyScripts();
}
bootstrap();

app.use(createPinia());
app.use(router);
app.use(i18n);
app.use(ElementTiptapPlugin) 
app.mount('#app');