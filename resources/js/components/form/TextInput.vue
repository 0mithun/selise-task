<template>
  <div class="input-element w-full" :class="$attrs.wrapperClass">
    <label
      :for="$attrs.id"
      class="form-label"
      :class="$attrs.labelClass"
      v-if="label"
    >
        {{ label }}{{ $attrs.asterisk ? "*" : "" }}
    </label>

    <div
      class="flex items-center input-group bg-white mb-2"
      :class="{ 'border-error': error || serverError }"
    >
      <div class="pl-3 left" v-if="$slots.left">
        <slot name="left"></slot>
      </div>
      <input
        class="w-full text-input"
        v-bind="$attrs"
        :placeholder="$attrs.placeholder ?? ''"
        :value="$attrs.modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :disabled="disabled"
        :class="[{ 'text-input--disabled': disabled },  $attrs.inputClass]"
        :readonly="readonly"
      />
      <div
        class="pr-6 mt-1 right"
        style="min-width: 150px; text-align: right"
        v-if="$slots.right"
      >
        <slot name="right"></slot>
      </div>
    </div>
    <p
      class="error-box flex p-0 items-center gap-2 mt-[4px] helper-text text-12"
      v-if="helperText"
    >
      <!-- <ErrorCrossIcon />  -->
      {{ helperText }}
    </p>
    <p
      class="error-box flex p-0 items-center gap-2 mt-[4px] text-error text-12"
      v-if="typeof error == 'string' && error && showError"
    >
      <!-- <ErrorCrossIcon />  -->
      {{ error }}
    </p>
  </div>
</template>

<script setup>
// import ErrorCrossIcon from '@/components/icons/ErrorCross.vue'
defineProps({
  label: {
    type: [String],
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
  helperText: {
    type: String,
    default: null,
  },
});
</script>

<script>
export default {
  inheritAttrs: false,
};
</script>


<style lang="scss" scoped>
.form-label {
  color: var(--Primary-Ball-Blue, #16a9b7);
  font-family: Poppins;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;

  margin-bottom: 12px;
  display: inline-block;
}

.text-input {
  background: #fff;
  border: none;
  outline: none;
  color: #063f5f;
  font-family: Poppins;
  font-size: 15px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;

  height: 40px;
  padding: 14px 24px;

  &:focus {
    outline: none;
    border: none;
  }

  &::placeholder {
    color: var(--1-2, #87b1cb);
    font-family: Nexa;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }
}

.text-input--disabled {
  color: #b0b0b0;
  cursor: not-allowed;
}

.border-error {
  border: 1px solid #e97d32;
}

.text-error {
  color: #e97d32;
}
</style>
