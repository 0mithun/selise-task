<template>
    <input
        class="search__input text-[16px] w-full py-2.5 px-5 pl-[50px] placeholder-shown:overflow-ellipsis"
        type="text"
        minlength="1"
        :placeholder="$t(placeholder)"
        v-model="form.search"
    />
</template>

<script>
import { onBeforeUnmount, reactive, ref } from "vue";
import { onMounted, watch } from "@vue/runtime-core";
import { debounce as _debounce } from "lodash";

import {useRoute, useRouter} from 'vue-router'

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

        onMounted(() => {
            form.search = route.query.search
        });
        watch(
            () => form.search,
            _debounce(function (newValue) {
               const queries = route.query
                delete queries.page;

               const routeObj = {query:{...queries, search: newValue}}

                router.push(routeObj)
            }, 500)
        );

        watch(() => form.search, () => {
            ctx.emit('update', form.search)
        })

        return {
            form,
        };
    },
};
</script>

<style lang="scss" scoped>
.search__input {
    background: #F9FAFB;
    border: 1px solid #E6DEE5;
    border-radius: 7px;
    height: 48px;
    outline: none;
    background-image: url("data:image/svg+xml,%3Csvg width='19' height='19' viewBox='0 0 19 19' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M18.6937 17.4023L12.607 11.3156C13.5516 10.0945 14.0625 8.60156 14.0625 7.03125C14.0625 5.15156 13.3289 3.38906 12.0023 2.06016C10.6758 0.73125 8.90859 0 7.03125 0C5.15391 0 3.38672 0.733594 2.06016 2.06016C0.73125 3.38672 0 5.15156 0 7.03125C0 8.90859 0.733594 10.6758 2.06016 12.0023C3.38672 13.3312 5.15156 14.0625 7.03125 14.0625C8.60156 14.0625 10.0922 13.5516 11.3133 12.6094L17.4 18.6937C17.4178 18.7116 17.439 18.7258 17.4624 18.7354C17.4857 18.7451 17.5107 18.7501 17.5359 18.7501C17.5612 18.7501 17.5862 18.7451 17.6095 18.7354C17.6328 18.7258 17.654 18.7116 17.6719 18.6937L18.6937 17.6742C18.7116 17.6564 18.7258 17.6352 18.7354 17.6119C18.7451 17.5885 18.7501 17.5635 18.7501 17.5383C18.7501 17.513 18.7451 17.488 18.7354 17.4647C18.7258 17.4414 18.7116 17.4202 18.6937 17.4023ZM10.7438 10.7438C9.75 11.7352 8.43281 12.2812 7.03125 12.2812C5.62969 12.2812 4.3125 11.7352 3.31875 10.7438C2.32734 9.75 1.78125 8.43281 1.78125 7.03125C1.78125 5.62969 2.32734 4.31016 3.31875 3.31875C4.3125 2.32734 5.62969 1.78125 7.03125 1.78125C8.43281 1.78125 9.75234 2.325 10.7438 3.31875C11.7352 4.3125 12.2812 5.62969 12.2812 7.03125C12.2812 8.43281 11.7352 9.75234 10.7438 10.7438Z' fill='%23ADB5BD'/%3E%3C/svg%3E%0A");
    background-repeat: no-repeat no-repeat;
        /* background-size: cover; */
    background-position: 20px center;

    font-family: 'Roboto';
    font-style: normal;
    font-weight: 400;
    line-height: 27px;
    color: #ADB5BD;

    &:focus {
        outline: none;
    }
}
</style>
