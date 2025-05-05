<template>
    <button class="save_button">
        <slot>
            {{ $t("Save") }}
        </slot>
    </button>
</template>


<style lang="scss">
    .save_button {
        width: 100%;
        height: 40px;
        text-align: center;
        background: #E97D32;
        color: #FFF;
        text-align: center;

        /* Nexa Bold / 18 */
        font-family: Nexa;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
    }
</style>
