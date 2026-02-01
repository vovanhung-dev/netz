<template>
    <div class="container-fluid">
        <main>
            <div class="left">
                <NavDashboard />
            </div>

            <div class="right">
                <div class="header">
                    <HeaderDashboard />
                </div>

                <div class="content">
                    <RouterView />
                </div>
            </div>
        </main>
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useAuthStore } from '@/stores/auth';

const NavDashboard = defineAsyncComponent(() => import('../../Components/Dashboard/Nav.vue'));
const HeaderDashboard = defineAsyncComponent(
    () => import('../../Components/Dashboard/HeaderDashboardComponent.vue'),
);

const auth = useAuthStore();
onMounted(() => {
    auth.fetchMe().catch(() => {});
});
</script>

<script lang="ts">
import { defineAsyncComponent } from 'vue';
export default {};
</script>

<style scoped>
.container-fluid {
    padding: 0;
    width: 100vw;
    height: 100vh;
    background: #3ea9e0;
    overflow: hidden;
}
main {
    display: flex;
    justify-content: space-between;
}
.left {
    width: 7vw;
    height: 100vh;
}
.right {
    width: 92vw;
    height: 100vh;
}
.right .header {
    width: 100%;
    height: 10vh;
    margin-top: 1vw;
    margin-bottom: 1vw;
}
.right .content {
    width: 100%;
    height: calc(90vh - 2vw);
    border-radius: 10px 0 0 0px;
    background: #fff;
    padding: 30px;
    overflow-x: auto;
}
</style>
