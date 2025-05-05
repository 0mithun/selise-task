<template>
    <div class="sidebar__link">
        <RouterLink :to="{ name: routeName }">
            <div
                v-bind="$attrs"
                class="flex items-center hover:cursor-pointer py-3 px-5"
                :class="{ active: isActive }"
            >
                <div class="icon">
                    <slot name="icon" />
                </div>
                <div
                    class="link sm:hidden md:block ml-4 font-poppins font-medium link"
                    :class="{ active: isActive }"
                    v-if="isFullView"
                >
                    <slot></slot>
                </div>
                <!-- <div class="badge justify-end">
                </div> -->
                <slot name="badge"></slot>
            </div>
        </RouterLink>
    </div>
</template>

<script>
export default {
    props: {
        routeName: {
            type: String,
            require: true,
        },
        isActive: {
            type: Boolean,
            default: false,
        },
        isFullView: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style lang="scss" scoped>
.sidebar__link {
    color: #BEE7FB;
}
.link {
    color: #BEE7FB;
    /* Ubuntu / Regular / 22 */
    font-family: Ubuntu;
    font-size: 22px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}
.active {
    color:  #E97D32;
    // background: #f6f9fc;
}

.sidebar__link {
}
</style>
