<template>
    <div class="bg-[#F8F8F8]">
        <Navbar @toggleNavbar="navbarCollapse = !navbarCollapse" :collapse="navbarCollapse" />
        <div class="w-full flex">
            <Sidebar :collapse="navbarCollapse" />
            <router-view> </router-view>
        </div>
    </div>
    <SuccessNotification />
    <FailNotification />
</template>

<script setup>
import { inject, onMounted, ref } from 'vue'

import { storeToRefs } from 'pinia'
import { notificationShowStore } from '@/store/notification'
import { watch } from '@vue/runtime-core'

import Sidebar from './components/Sidebar.vue'
import Navbar from './components/Navbar.vue'
import SuccessNotification from '@/components/Notification/SuccessNotification.vue'
import FailNotification from '@/components/Notification/FailNotification.vue'

const navbarCollapse = ref(false)

</script>

<style lang="scss" scoped>
.inpersonate {
    display: flex;
    align-items: center;
    // position: absolute;
    // top: 0;
    width: 100%;
    // height: 50px;
    background: #2cb7c6;
    padding: 10px 30px;
    color: #fff;

    padding: 8px 24px;

    color: #fff;
    font-family: Poppins;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;

    position: fixed;
    z-index: 99999;
    top: 0;

    .exit-btn {
        margin-left: 20px;
        text-align: center;
        outline: none;
        background: rgb(14 135 153);
        min-width: 100px;
        padding: 4px 10px;
        border-radius: 5px;
    }
}
</style>
