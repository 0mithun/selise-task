<template>
  <div class="flex flex-col single-select wrapper" :class="$attrs.class">
    <h2
      class="block input-label"
      :class="$attrs.labelClass"
      v-if="$attrs.label"
    >
    {{ $attrs.label ?? ""}}
    <span class="text-danger">{{ $attrs.asterisk ? "*" : "" }} </span>
    </h2>

    <div
      class="relative wrapper"
      :class="$attrs.wrapperClass"
      v-click-away="
        () => {
          expanded = false;
        }
      "
    >
      <div
        class="toggler"
        :class="[
          {
            'border-error': error,
            '!cursor-not-allowed !bg-gray-200': disabled,
          },
          $attrs.togglerClass,
        ]"
        @click="toggle"
      >
        <slot name="placeholder">
          <template v-if="selected_item_label">
            <div
              class="text-[13px] overflow-hidden whitespace-nowrap input-value flex gap-2"
              :class="[disabled ? 'text-[#585858]' : '']"
            >
            {{ selected_item_label.toString() }}
            </div>
          </template>
          <template v-else>
            <div
              class="text-[13px] overflow-hidden whitespace-nowrap placeholder text-[#87B1CB]"
            >
              {{ $attrs.placeholder ?? "" }}
            </div>
          </template>
        </slot>
        <div class="toggle-icon">
          <ToggleUpIcon v-if="expanded" />
          <ToggleDownIcon v-else />
        </div>
      </div>
      <p
        class="text-error"
        v-if="typeof props.error == 'string' && props.error && showError"
      >{{ props.error }}</p>
      <div class="dropdown-options absolute z-10 w-full">
        <slot name="search">
          <input
            v-if="$attrs.searchable && expanded"
            class="search__input"
            ref="search_input"
            v-model="search"
          />
        </slot>
        <div
          class="options bg-white flex flex-col w-full top-[100%] shadow-md shadow-gray-200 border-input max-h-[250px] overflow-y-auto"
          :class="$attrs.optionsClass"
          @scroll="scrollCheck($event.target)"
          v-if="expanded"
          ref="selectDropdown"
        >
          <template
            v-if="options.length"
            v-for="{
              [labelKey]: label,
              [valueKey]: value,
              ...additionals
            } in options"
          >
            <slot
              name="option"
              :option="{
                label,
                value,
                toggle,
                additionals,
                selected: value == $attrs.modelValue,
              }"
              :toggle="toggleSelectedItem"
            >
              <div
                class="option cursor-pointer px-3 py-[5px] hover:bg-[#F4FAFB]"
                :id="`option-${value.toString().toLowerCase()}`"
                :key="value"
                :class="[
                  $attrs.optionClass,
                  value === $attrs.modelValue ? 'active' : '',
                ]"
                @click="toggleSelectedItem(value)"
              >
                <span class="text-[13px]">
                    {{ label.toString() }}
                </span>
              </div>
            </slot>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import ToggleDownIcon from "@/components/icons/ToggleDown.vue";
import ToggleUpIcon from "@/components/icons/ToggleUp.vue";
import { computed, ref } from "@vue/reactivity";
import { useAttrs } from "vue";
import { debounce } from "lodash";

const emit = defineEmits([
  "update:modelValue",
  "onUpdate",
  "scrolled",
  "input",
]);
const selectDropdown = ref(null);

const expanded = ref(false);
const search = ref("");
const search_input = ref("");

const props = defineProps({
  options: {
    type: Array,
    requried: true,
  },
  valueKey: {
    type: String,
    default: "value",
  },
  labelKey: {
    type: String,
    default: "label",
  },
  searchables: {
    type: Array,
    required: false,
    default: [],
  },
  error: {
    type: [Boolean, String],
    required: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  showError: {
    type: Boolean,
    default: true,
  },
});

const attrs = useAttrs();

const selectedItem = computed(() => {
  return props.options.find((item) => {
    if (
      typeof attrs.modelValue == "string" &&
      typeof item[props.valueKey] == "string"
    ) {
      return (
        item[props.valueKey].toLowerCase() === attrs.modelValue.toLowerCase()
      );
    }
    return item[props.valueKey] === attrs.modelValue;
  });
});

const selected_item_label = computed(() => {
  return selectedItem.value ? selectedItem.value[props.labelKey] : null;
});

const options = computed(() => {
  if (!search.value) {
    return props.options;
  }

  return props.options.filter((option) => {
    if (typeof props.searchables == "object") {
      return props.searchables.some((searchKey) =>
        option[searchKey].toLowerCase().includes(search.value.toLowerCase())
      );
    } else {
      return option[props.valueKey]
        .toLowerCase()
        .includes(search.value.toLowerCase());
    }
  });
});

const toggle = () => {
  if (props.disabled) return;
  expanded.value = !expanded.value;
  if (attrs.searchable && expanded.value) {
    setTimeout(() => {
      search_input.value.focus();

      if (selectedItem.value) {
        const item = document.getElementById(
          `option-${attrs.modelValue.toString().toLowerCase()}`
        );
        selectDropdown.value.scrollTop = item.offsetTop - 110;
      }
    }, 100);
  }
};

const toggleSelectedItem = (value) => {
  if (value === attrs.modelValue) return;
  emit("update:modelValue", value);
  emit(
    "onUpdate",
    props.options.find((o) => o.value == value)
  );
  emit("input", value);
  toggle();
};

const scrollCheck = debounce((el) => {
  const { scrollTop, scrollHeight, clientHeight } = el;

  if (scrollTop + clientHeight >= scrollHeight - 100) {
    emit("scrolled");
  }
}, 200);
</script>

<script>
export default {
  inheritAttrs: false,
};
</script>

<style lang="scss" scoped>
.input-label {
  color: var(--Primary-Ball-Blue, #16a9b7);
  font-family: Poppins;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  margin-bottom: 12px;
}

.input-value {
  color: #063f5f;
  font-family: Poppins;
  font-size: 15px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;
}

.toggler {
  height: 40px;
  background: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
  padding: 0px 12px;
  cursor: pointer;
}

.search__input {
  width: 100%;
  height: 40px;
  border: none;
  outline: none;
  padding: 10px 12px;
  border: 1px solid #fef1e7;
  display: block;

  background-image: url("data:image/svg+xml,%3Csvg width='19' height='19' viewBox='0 0 19 19' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M18.6937 17.4023L12.607 11.3156C13.5516 10.0945 14.0625 8.60156 14.0625 7.03125C14.0625 5.15156 13.3289 3.38906 12.0023 2.06016C10.6758 0.73125 8.90859 0 7.03125 0C5.15391 0 3.38672 0.733594 2.06016 2.06016C0.73125 3.38672 0 5.15156 0 7.03125C0 8.90859 0.733594 10.6758 2.06016 12.0023C3.38672 13.3312 5.15156 14.0625 7.03125 14.0625C8.60156 14.0625 10.0922 13.5516 11.3133 12.6094L17.4 18.6937C17.4178 18.7116 17.439 18.7258 17.4624 18.7354C17.4857 18.7451 17.5107 18.7501 17.5359 18.7501C17.5612 18.7501 17.5862 18.7451 17.6095 18.7354C17.6328 18.7258 17.654 18.7116 17.6719 18.6937L18.6937 17.6742C18.7116 17.6564 18.7258 17.6352 18.7354 17.6119C18.7451 17.5885 18.7501 17.5635 18.7501 17.5383C18.7501 17.513 18.7451 17.488 18.7354 17.4647C18.7258 17.4414 18.7116 17.4202 18.6937 17.4023ZM10.7438 10.7438C9.75 11.7352 8.43281 12.2812 7.03125 12.2812C5.62969 12.2812 4.3125 11.7352 3.31875 10.7438C2.32734 9.75 1.78125 8.43281 1.78125 7.03125C1.78125 5.62969 2.32734 4.31016 3.31875 3.31875C4.3125 2.32734 5.62969 1.78125 7.03125 1.78125C8.43281 1.78125 9.75234 2.325 10.7438 3.31875C11.7352 4.3125 12.2812 5.62969 12.2812 7.03125C12.2812 8.43281 11.7352 9.75234 10.7438 10.7438Z' fill='%23ADB5BD'/%3E%3C/svg%3E%0A");
  background-repeat: no-repeat no-repeat;
  background-position: 10px center;
  padding-left: 35px;

  &:focus {
    outline: none;
  }
}

.placeholder {
  color: var(--1-2, #87b1cb);
  font-family: Nexa;
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
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
  text-align: left;
}
</style>
