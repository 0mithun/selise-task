<template>
    <svg
        width="11"
        height="7"
        viewBox="0 0 11 7"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M1 5.54688L5.5 1.54134L10 5.54688"
            :stroke="fill"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </svg>
</template>



<script>
    export default {
        props: {
            fill: {
                type: String,
                default: '#636363'
            }
        }
    }
</script>
