<template>
    <nav>
        <div class="logo">
            <RouterLink to="/admin">
                <img src="../../src/assets/images/logo.png" alt="SHAREWORK" />
            </RouterLink>
        </div>

        <div class="menu">
            <!-- CAREERS -->
            <RouterLink class="link" :to=" { name: 'admin-careers' } ">
                <div class="item">
                    <i class="fa-solid fa-users"></i>

                </div>
            </RouterLink>

            <!-- BLOG (đổi 'admin-blog' sang route thật của bạn nếu có) -->
            <RouterLink class="link" :to=" { name: 'admin-blog' } " v-if="hasBlog">
                <div class="item">
                    <i class="fa-solid fa-blog"></i>
                </div>
            </RouterLink>

            <!-- NEWS -->
            <RouterLink class="link" :to=" { name: 'admin-news' } ">
                <div class="item">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </RouterLink>

            <!-- COURSES -->
            <RouterLink class="link" :to=" { name: 'admin-courses' } ">
                <div class="item">
                    <i class="fa-solid fa-book"></i>
                </div>
            </RouterLink>

            <!-- CAREER APPLICATIONS -->
            <RouterLink class="link" :to=" { name: 'admin-career-applications' } ">
                <div class="item">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
            </RouterLink>

            <!-- CONTACT (đổi 'admin-contacts' sang route thật của bạn nếu có) -->
            <RouterLink class="link" :to=" { name: 'admin-contacts' } " v-if="hasContact">
                <div class="item">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
            </RouterLink>

            <!-- USER (đổi 'admin-users' sang route thật của bạn nếu có) -->
            <RouterLink class="link" :to=" { name: 'admin-users' } " v-if="hasUser">
                <div class="item">
                    <i class="fa-solid fa-user"></i>
                </div>
            </RouterLink>
        </div>
    </nav>
</template>

<script setup lang="ts">
const hasBlog = false;
const hasContact = true;
const hasUser = false;
</script>

<style scoped>
nav {
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: #fff;
}

nav .logo {
    width: 100%;
    height: 50px;
    position: relative;
    margin-bottom: 100px;
    cursor: pointer;
}

nav .logo img {
    width: 60%;
    margin-left: 20%;
    margin-top: 20%;
}

.link {
    display: block;
    color: #000;
    text-decoration: none;
    border: 5px solid transparent;
}

.menu {
    width: 80%;
    margin: auto;
    text-align: center;
}

.menu .item {
    cursor: pointer;
    height: 50px;
    font-size: 20px;
    transition: 0.5s;
    margin-bottom: 5px;
    position: relative;
}

/* Dùng class mặc định của Vue Router: router-link-exact-active */
.router-link-exact-active {
    border: 5px solid transparent;
    border-left: 5px solid #3ea9e0;
}

.menu .item i {
    width: 50px;
    height: 40px;
    line-height: 40px;
    border-radius: 10px;
}
</style>
