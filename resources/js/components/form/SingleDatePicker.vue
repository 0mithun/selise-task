<template>
  <div class="input-element w-full" :class="$attrs.wrapperClass">
    <label
      :for="$attrs.id"
      class="text-input block mb-3 form-label"
      :class="$attrs.labelClass"
      v-if="label"
    >
      {{ label }}{{ $attrs.asterisk ? "*" : "" }}
    </label>
    <div class="datepicker" :class="{ 'border-error': error || serverError }">
      <v-date-picker
        v-model="date_value"
        title-position="left"
        @dayclick="dayclick"
        :attributes="datepickerOptions.attrs"
        :select-attribute="{
          highlight: {
            start: { fillMode: 'solid', style: { background: '#e97d32' } },
            base: {
              fillMode: 'light',
              contentStyle: { color: '#ffffff' },
              style: { background: '#F8D3BA' },
            },
            end: { fillMode: 'solid', style: { background: '#e97d32' } },
          },
        }"
        :drag-attribute="{
          highlight: {
            start: {
              fillMode: 'outline',
              contentStyle: { color: '#000000' },
              style: { borderColor: '#e97d32' },
            },
            base: {
              fillMode: 'solid',
              contentStyle: { color: '#FFF' },
              style: { background: '#F8D3BA' },
            },
            end: {
              fillMode: 'outline',
              contentStyle: { color: '#000000' },
              style: { borderColor: '#e97d32' },
            },
          },
        }"
        :key="compoenentKey"
        :masks="{ input: 'DD.MM.YYYY', title: 'MMM YYYY' }"
        :model-config="{
          type: 'string',
          mask: 'YYYY-MM-DD', // Uses 'iso' if missing
        }"
        :min-date="$attrs.min_date"
        :max-date="$attrs.max_date"
      >
        <template v-slot="{ inputValue, inputEvents }">
          <div class="filter-date-range-picker h-10 items-center relative">
            <input
              id="date"
              class="date__input"
              :placeholder="'DD.MM.YYYY'"
              :value="inputValue"
              v-on="inputEvents"
              :readonly="readonly"
            />
            <svg
              width="18"
              height="18"
              viewBox="0 0 18 18"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              class="ml-auto absolute right-0 pointer-events-none"
              @click="focusDateInput"
            >
              <path
                d="M2.67187 17.7188C2.31771 17.7188 1.97917 17.651 1.65104 17.5104C1.32292 17.375 1.03646 17.1823 0.786458 16.9323C0.536459 16.6823 0.34375 16.3906 0.208334 16.0677C0.0677084 15.7396 0 15.3958 0 15.0417V3.92708C0 3.57292 0.0729166 3.22917 0.208334 2.90104C0.34375 2.57813 0.536459 2.28646 0.786458 2.03646C1.03646 1.78646 1.32292 1.59375 1.65104 1.45313C1.97917 1.31771 2.31771 1.25 2.67187 1.25H3.83333V0.755208C3.83333 0.546875 3.91146 0.369792 4.05729 0.223959C4.20312 0.0729167 4.38021 0 4.58854 0C4.79687 0 4.97396 0.0729167 5.11979 0.223959C5.26562 0.369792 5.33854 0.546875 5.33854 0.755208V1.25H12.3281V0.755208C12.3281 0.546875 12.401 0.369792 12.5521 0.223959C12.6979 0.0729167 12.875 0 13.0833 0C13.2865 0 13.4635 0.0729167 13.6146 0.223959C13.7604 0.369792 13.8333 0.546875 13.8333 0.755208V1.25H15.0365C15.3906 1.25 15.7292 1.31771 16.0573 1.45313C16.3802 1.58854 16.6719 1.78646 16.9219 2.03646C17.1719 2.28646 17.3646 2.57292 17.5 2.90104C17.6354 3.22917 17.7031 3.57292 17.7031 3.92708V15.0833C17.6927 15.4323 17.6146 15.7708 17.4687 16.0938C17.3281 16.4167 17.1302 16.6979 16.8802 16.9427C16.625 17.1927 16.3385 17.3802 16.0156 17.5156C15.6875 17.6458 15.349 17.7135 15 17.7188H2.67187ZM1.50521 3.89063V15.0417C1.50521 15.3646 1.61979 15.6406 1.84896 15.8698C2.07292 16.099 2.34896 16.2135 2.67187 16.2135H15.0312C15.3542 16.2135 15.6302 16.099 15.8594 15.8698C16.0833 15.6406 16.1979 15.3646 16.2031 15.0417V3.92708C16.1979 3.60417 16.0833 3.32812 15.8594 3.10417C15.6302 2.875 15.3542 2.76042 15.0312 2.76042H13.8333V3.25C13.8229 3.44792 13.7396 3.61979 13.599 3.75521C13.4531 3.89063 13.2812 3.96354 13.0833 3.96875C12.875 3.96875 12.6979 3.89063 12.5521 3.74479C12.4062 3.59896 12.3333 3.42188 12.3333 3.21354V2.76042H5.33854V3.24479C5.33854 3.44792 5.26041 3.61979 5.11458 3.76042C4.96875 3.90104 4.79167 3.96875 4.58854 3.96354C4.38021 3.95833 4.20312 3.88542 4.05729 3.73958C3.91146 3.59375 3.83854 3.41667 3.83333 3.20833V2.71354H2.67187C2.34896 2.71875 2.07292 2.83333 1.84375 3.0625C1.61979 3.29167 1.50521 3.56771 1.50521 3.89063ZM13.0417 14.4792C12.8333 14.4792 12.6562 14.4063 12.5104 14.2552C12.3646 14.1094 12.2917 13.9323 12.2917 13.724C12.2917 13.5156 12.3646 13.3385 12.5104 13.1927C12.6562 13.0469 12.8333 12.9688 13.0417 12.9688H13.9479C14.151 12.974 14.3281 13.0469 14.474 13.1927C14.6198 13.3385 14.6979 13.5156 14.6979 13.724C14.6823 13.9271 14.6042 14.099 14.4635 14.2396C14.3177 14.3854 14.1458 14.4635 13.9479 14.4792H13.0417ZM8.38021 14.4792C8.17187 14.4792 7.99479 14.4063 7.84896 14.2552C7.70312 14.1094 7.63021 13.9323 7.63021 13.724C7.63021 13.5156 7.70312 13.3385 7.84896 13.1927C7.99479 13.0469 8.17187 12.9688 8.38021 12.9688H9.28646C9.48958 12.9688 9.66666 13.0469 9.81771 13.1927C9.96354 13.3385 10.0365 13.5156 10.0365 13.724C10.0365 13.9323 9.96354 14.1094 9.81771 14.2552C9.66666 14.4063 9.48958 14.4792 9.28646 14.4792H8.38021ZM3.76042 14.4792C3.55208 14.4792 3.375 14.4063 3.22917 14.2552C3.08333 14.1094 3.00521 13.9323 3.00521 13.724C3.00521 13.5156 3.08333 13.3385 3.22917 13.1927C3.375 13.0469 3.55208 12.9688 3.76042 12.9688H4.66146C4.86979 12.974 5.04687 13.0469 5.19271 13.1927C5.33854 13.3385 5.41146 13.5156 5.41146 13.724C5.40104 13.9271 5.32292 14.099 5.17708 14.2396C5.03646 14.3854 4.86458 14.4635 4.66146 14.4792H3.76042ZM13.0469 11.3125C12.8385 11.3125 12.6615 11.2396 12.5156 11.0885C12.3646 10.9427 12.2917 10.7656 12.2917 10.5573C12.2917 10.349 12.3646 10.1719 12.5156 10.026C12.6615 9.88021 12.8385 9.80208 13.0469 9.80208H13.9479C14.1562 9.80729 14.3333 9.88021 14.4792 10.026C14.625 10.1719 14.6979 10.349 14.6979 10.5573C14.6927 10.7656 14.6146 10.9375 14.474 11.0833C14.3281 11.2292 14.151 11.3073 13.9479 11.3125H13.0469ZM8.38541 11.3125C8.17708 11.3125 8 11.2396 7.85416 11.0885C7.70312 10.9427 7.63021 10.7656 7.63021 10.5573C7.63021 10.349 7.70312 10.1719 7.85416 10.026C8 9.88021 8.17708 9.80208 8.38541 9.80208H9.28646C9.49479 9.80729 9.67187 9.88021 9.81771 10.026C9.96354 10.1719 10.0365 10.349 10.0365 10.5573C10.0417 10.7708 9.97396 10.9479 9.82291 11.099C9.67708 11.2448 9.49479 11.3177 9.28646 11.3125H8.38541ZM3.76042 11.3125C3.55208 11.3125 3.375 11.2396 3.22917 11.0885C3.08333 10.9427 3.01042 10.7656 3.01042 10.5573C3.01042 10.349 3.08333 10.1719 3.22917 10.026C3.375 9.88021 3.55208 9.80208 3.76042 9.80208H4.66146C4.86979 9.80729 5.04687 9.88021 5.1875 10.026C5.33333 10.1719 5.40625 10.349 5.41146 10.5573C5.40104 10.7604 5.32812 10.9375 5.18229 11.0833C5.03646 11.2292 4.86458 11.3021 4.65625 11.3125H3.76042ZM13.0469 8.1875C12.8385 8.1875 12.6615 8.10938 12.5156 7.96354C12.3698 7.81771 12.2969 7.64063 12.2969 7.43229C12.2969 7.22396 12.3698 7.04688 12.5156 6.90104C12.6615 6.75 12.8385 6.67708 13.0469 6.67708H13.9479C14.1562 6.67708 14.3333 6.75521 14.4792 6.90104C14.625 7.04688 14.6979 7.22396 14.7031 7.43229C14.6875 7.63542 14.6094 7.80729 14.4687 7.94792C14.3229 8.09375 14.151 8.17188 13.9479 8.1875H13.0469ZM8.38541 8.1875C8.17708 8.1875 8 8.10938 7.85416 7.96354C7.70833 7.81771 7.63541 7.64063 7.63541 7.43229C7.63541 7.22396 7.70833 7.04688 7.85416 6.90104C8 6.75 8.17708 6.67708 8.38541 6.67708H9.28646C9.49479 6.67708 9.67187 6.75 9.81771 6.90104C9.96875 7.04688 10.0417 7.22396 10.0417 7.43229C10.0417 7.64063 9.96875 7.81771 9.81771 7.96354C9.67187 8.10938 9.49479 8.1875 9.28646 8.1875H8.38541ZM3.76562 8.1875C3.55729 8.1875 3.38021 8.10938 3.22917 7.96354C3.08333 7.81771 3.01042 7.64063 3.01042 7.43229C3.01042 7.22396 3.08333 7.04688 3.22917 6.90104C3.38021 6.75 3.55729 6.67708 3.76562 6.67708H4.66667C4.875 6.67708 5.05208 6.75521 5.19792 6.90104C5.34375 7.04688 5.41667 7.22396 5.41667 7.43229C5.40625 7.63542 5.32812 7.80729 5.18229 7.94792C5.04166 8.09375 4.86979 8.17188 4.66667 8.1875H3.76562Z"
                fill="#636363"
              />
            </svg>
          </div>
        </template>
      </v-date-picker>
    </div>

    <p
      class="error-box flex p-0 items-center gap-2 mt-[4px] text-error text-12"
      v-if="typeof error == 'string' && error && showError"
    >
      {{ error }}
    </p>
  </div>
</template>

<script setup>
import { reactive, ref, computed } from "@vue/reactivity";
import { onMounted, useAttrs, watch } from "@vue/runtime-core";

import dayjs from "dayjs";

const attrs = useAttrs();
const emit = defineEmits(["update:modelValue", "onUpdate"]);
const props = defineProps({
  label: {
    type: [String, Object],
    required: false,
    default: "",
  },
  error: {
    type: [Boolean, String],
    required: false,
  },
  serverError: {
    type: [Boolean, String],
    required: false,
  },
  showError: {
    type: Boolean,
    default: true,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  readonly: {
    type: Boolean,
    default: false,
  },
});

const compoenentKey = ref(0);
const date_value = computed({
  get: () => attrs.modelValue,
  set: (value) => {
    emit("update:modelValue", value);
    emit("onUpdate", value);
  },
});

const datepickerOptions = reactive({
  attrs: [
    {
      key: "today",
      highlight: !attrs.highlight_today ? false : "green",
      dates: new Date(),
    },
  ],
});

const dayclick = (e) => {};
</script>

<style lang="scss" scoped>
.datepicker {
  //   position: absolute;
  //   left: 0;
  //   top: 2.8rem;
  //   width: 245px;
  border: none;
  border-radius: 4px;
  padding: 0px 14px;
  background: #fff;

  &.border-error {
    border: 1px solid #e97d32;
  }
}

.filter-date-range-picker {
  display: flex;

  .middle {
    margin: 0 5px;
    font-family: "Inter";
    font-style: normal;
    font-weight: 400;
    font-size: 13px;
    line-height: 16px;
    letter-spacing: 0.04em;

    color: #636363;
  }

  .date__input {
    width: 100%;
    border: none;
    outline: none;

    font-family: "Poppins";
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 32px;
    color: #585858;

    &:focus {
      border: none;
      outline: none;
    }

    &:active {
      //   color: #e97d32 !important;
    }
  }
}
.form-label {
  color: var(--Primary-Ball-Blue, #16a9b7);
  font-family: Poppins;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 12px;
}

.placeholder {
  color: #063f5f;
  font-family: Poppins;
  font-size: 15px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;

  cursor: pointer;
}

.option {
  border-top: 1px solid #fef1e7;
  color: #2c5b7d;
  display: flex;
  font-family: Poppins;
  font-size: 15px;
  cursor: pointer;
  padding: 10px;

  &:hover {
    background: #e97d32;
    color: white;
  }
}

.option.active {
  background: #e97d32;
  color: white;
}

.border-error {
  border: 1px solid #e97d32;
}

.text-error {
  margin-top: 4px;
  color: #e97d32;
  font-size: 16px;
}
</style>
