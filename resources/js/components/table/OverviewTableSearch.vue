<template>
    <div class="search__container relative">
        <input
          type="text"
          class="search__input"
          :placeholder="placeholder"
          v-model="form.search"
          @keypress="() => (deletePage = true)"
        />
        <div class="close absolute right-1 top-0 cursor-pointer bg-white p-1" @click="clearSearch" v-if="form.search && form.search.length>0">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0,0,300,150">
                <g fill="#063f5f" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M9.15625,6.3125l-2.84375,2.84375l15.84375,15.84375l-15.9375,15.96875l2.8125,2.8125l15.96875,-15.9375l15.9375,15.9375l2.84375,-2.84375l-15.9375,-15.9375l15.84375,-15.84375l-2.84375,-2.84375l-15.84375,15.84375z"></path></g></g>
            </svg>
        </div>
    </div>
</template>

<script>
import { onBeforeUnmount, reactive, ref } from "vue";
import { onMounted, watch } from "@vue/runtime-core";
import { debounce as _debounce } from "lodash";

import { useRoute, useRouter } from "vue-router";

export default {
  props: {
    placeholder: {
      type: String,
      default: "",
    },
  },
  setup(props, ctx) {
    const route = useRoute();
    const router = useRouter();

    const form = reactive({
      search: "",
    });

    const deletePage = ref(false);
    const clearSearch = ()=> {
        form.search = ''
    }


    onMounted(() => {
      form.search = route.query.search;
    });
    watch(
      () => form.search,
      _debounce(function (newValue) {
        const queries = route.query;
        if (deletePage.value) {
          delete queries.page;
        }

        const routeObj = { query: { ...queries, search: newValue } };

        router.push(routeObj);
      }, 500)
    );

    return {
      form,
      deletePage,
      clearSearch
    };
  },
};
</script>

<style lang="scss" scoped>
.search__input {
  background: white;
  outline: none;
  display: flex;
  width: 100%;
  align-items: center;

    color: var(--1-3, #4C85A7);
    font-family: Nexa;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    height: 48px;



  &:focus {
    outline: none;
    border: none;
  }

  &::placeholder {
    color: var(--1-3, #4C85A7);
    font-family: Nexa;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
  }
}


.search__input {
    @apply px-4 py-3 outline-none hover:outline-none focus:outline-none placeholder:text-[#525F7F] w-full;
    padding-left: 35px;
    height: 46px;
    color: #000000;

    background-image: url("data:image/svg+xml,%3Csvg width='33' height='33' viewBox='0 0 33 33' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M29.2727 31.394L30.3333 32.4547L32.4547 30.3333L31.394 29.2727L29.2727 31.394ZM24.3995 22.2782L23.3388 21.2175L21.2175 23.3388L22.2782 24.3995L24.3995 22.2782ZM14.5 25.5C8.42487 25.5 3.5 20.5751 3.5 14.5H0.5C0.5 22.232 6.76801 28.5 14.5 28.5V25.5ZM3.5 14.5C3.5 8.42487 8.42487 3.5 14.5 3.5V0.5C6.76801 0.5 0.5 6.76801 0.5 14.5H3.5ZM14.5 3.5C20.5751 3.5 25.5 8.42487 25.5 14.5H28.5C28.5 6.76801 22.232 0.5 14.5 0.5V3.5ZM25.5 14.5C25.5 20.5751 20.5751 25.5 14.5 25.5V28.5C22.232 28.5 28.5 22.232 28.5 14.5H25.5ZM31.394 29.2727L24.3995 22.2782L22.2782 24.3995L29.2727 31.394L31.394 29.2727Z' fill='%23063F5F'/%3E%3C/svg%3E%0A");
    background-repeat: no-repeat no-repeat;
    background-position: 10px center;
    background-size: 28px 28px;
    padding-left: 52px;
    padding-top: 15px;
}

</style>
