<template>
  <div class="back flex gap-3 items-center cursor-pointer mb-5 w-[100px]" @click="redirect">
    <svg
        width="26.67px" height="20px"   viewBox="0 0 31 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-3"
    >
        <path
            d="M2.66602 12L29.3327 12M2.66602 12L12.666 2M2.66602 12L12.666 22"
            stroke="#2C5B7D"
            stroke-width="2.5"
            stroke-linecap="square"
        />
    </svg>

    <span class="back-text">{{
      "Back"
    }}</span>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";
import { defineProps, inject } from "vue";


const router = useRouter();
const props = defineProps({
  target: {
    requred: false,
  },
  back_prev: {
    type: Boolean,
    default: false,
  },
  body: {
    type: String,
    default: "",
  },
  title: {
    type: String,
    default: "",
  },
  showPopup: {
    type: Boolean,
    default: false,
  },
});

const emitter = inject("emitter");
const redirect = () => {
    if(props.back_prev) {
        router.back()
    }else {
        props.target ? router.push(props.target) : router.back();
    }

};
</script>


<style lang="scss" scoped>
    .back-text {
        color: var(--1-4, #2C5B7D);
        font-family: Nexa;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
</style>
