/// <reference types="vite/client" />

// Vue SFC Type Declarations
declare module '*.vue' {
    import type { DefineComponent } from 'vue';
    const component: DefineComponent<{}, {}, any, {}, {}, {}, {}, {}>;
    export default component;
}