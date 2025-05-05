<template>
    <div class="flex items-center justify-center h-12 w-full">
        <button
            class="px-8 flex items-center justify-center gap-3 bg-[#e97d32] text-white font-poppins font-bold text-lg leading-6 text-center w-full h-full"
            @click.prevent="addNew"
        >
            <AddIcon class="" /> {{ label }}
        </button>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import AddIcon from '@/components/icons/AddIcon.vue';

const props = defineProps({
    routeName: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        default: '',
    },
});

const router = useRouter();

function addNew() {
    router.push({ name: props.routeName });
}
</script>
