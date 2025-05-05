<template>
    <label
        :for="$attrs.id"
        class="form-label"
        :class="$attrs.labelClass"
        v-if="label"
    >
        <template v-if="typeof $attrs.label == 'object'">
            {{ label.text, label.replace }}
        </template>
        <template v-else>
            {{ label }}{{ $attrs.asterisk ? "*" : "" }}
        </template>
    </label>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                default: null
            }
        }
    }
</script>

<style lang="scss" scoped>
    .form-label {
        color: var(--Primary-Ball-Blue, #16A9B7);
        font-family: Poppins;
        font-size: 18px;
        font-style: normal;
        font-weight: 700;
        line-height: normal;

        margin-bottom: 12px;
        display: inline-block;
    }
</style>
