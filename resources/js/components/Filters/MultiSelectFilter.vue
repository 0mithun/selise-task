<template>
    <div
      class="multi-select-filter"
      ref="multi_select_filter"
      v-click-away="() => (opened = false)"
    >
      <div class="label">
        <span @click="loadOptions" class="capitalize">{{ (labelText).replace(/[_-]/g, " ") }}</span>
        <span class="ml-[2px]" @click="loadOptions">
          <svg
            width="16"
            height="16"
            viewBox="0 0 22 14"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M2.66406 2.6665L10.9974 10.9998L19.3307 2.6665"
              stroke="#063F5F"
              stroke-width="3"
              stroke-linecap="square"
            />
          </svg>
        </span>
      </div>
      <ul class="options capitalize" v-show="opened">
        <li class="search-box" v-if="isSearchShow">
          <input
            type="text"
            v-model="searchQuery"
            :placeholder="'Search...'"
            class="search-input !ring-0 !focus:ring-0 !focus:outline-none !rounded-[0px]"
          />
        </li>
        <li
          class="option"
          v-for="option in filteredOptions"
          :key="option[valueKey]"
        >
          <label>
            <input
              type="checkbox"
              :value="option[valueKey]"
              v-model="selectedItems"
              class="option_checkbox"
            />

            {{ option[labelKey].replace(/[_-]/g, " ") }}
          </label>
        </li>
      </ul>
    </div>
  </template>

  <script>
  import Checkbox from "./Checkbox.vue";
  import { debounce as _debounce } from "lodash";

  export default {
    props: {
      label: {
        type: String,
        required: true,
      },
      valueKey: {
        type: String,
        default: "id",
      },
      labelKey: {
        type: String,
        default: "name",
      },
      column: {
        type: String,
        required: true,
      },
      routeName: {
        type: String,
        required: true,
      },
      params: {
        type: Object,
       default: {}
      },
      translate: {
        type: Boolean,
        default: true,
      },
      isSearchShow: {
          type: Boolean,
          default: true,
      }
    },
    components: { Checkbox },

    data() {
      return {
        opened: false,
        selectedItems: [],
        options: [],
        searchQuery: "",
      };
    },

    computed: {
      labelText() {
        if (this.selectedItems.length && this.options.length) {
          const option = this.options.find(
            (item) => item[this.valueKey] == this.selectedItems[0]
          );
          if (option) {
            const length = this.selectedItems.length;
            const translatedLabel = option[this.labelKey] ?? "";
            const text = `${translatedLabel} ${
              length > 1 ? ", +" + String(length - 1) : ""
            }`;

            return text;
          }

          return this.label;
        }

        return this.label;
      },
      filteredOptions() {
        if (!this.searchQuery) return this.options;
        const query = this.searchQuery.toLowerCase();
        return this.options.filter((option) =>
          option[this.labelKey]?.toLowerCase().includes(query)
        );
      },
    },
    watch: {
      selectedItems: {
        handler: _debounce(async function (newValue, oldValue) {
          const currentQuery = { ...this.$route.query };
          const updatedQuery = { ...currentQuery };

          if (this.selectedItems.length) {
            updatedQuery[this.column] = this.selectedItems.join(",");
          } else {
            delete updatedQuery[this.column];
          }

          // Compare all keys except 'page' to see if anything else changed
          const keys = new Set([...Object.keys(currentQuery), ...Object.keys(updatedQuery)]);
          let otherParamChanged = false;

          for (const key of keys) {
            if (key === 'page') continue;
            if (currentQuery[key] !== updatedQuery[key]) {
              otherParamChanged = true;
              break;
            }
          }

          if (otherParamChanged && 'page' in updatedQuery) {
            const { page, ...rest } = updatedQuery;
            await this.$router.replace({ query: rest });
          } else {
            await this.$router.push({ query: updatedQuery });
          }

          this.$emit("updateResult");
          this.opened = false;
        }, 500),
        deep: true,
      },
      "$route.fullPath": {
        handler: function (newVal, oldVal) {
          this.getSelectdOptionsFromUrl();
        },
      },
    },
    mounted() {
      this.getSelectdOptionsFromUrl();
      this.getOptions();
    },
    methods: {
      async getOptions() {
        try {
          const res = await axios.get(
            route(this.routeName, { ...this.$route.query,...this.params, column: this.column })
          );
          this.options = res.data;
          // this.opened = true;
        } catch (error) {
          console.log(error);
        }
      },
      loadOptions() {
        if (this.opened) {
          this.opened = false;
        } else {
          this.opened = true;
          // this.getOptions();
          this.searchQuery = "";
        }
      },
      getSelectdOptionsFromUrl() {
        const queries = this.$route.query;
        let selectedItems = [];
        Object.keys(queries).forEach((key) => {
          if (key == this.column && queries[key]) {
            selectedItems = String(queries[key]).split(",");
          }
        });
        this.selectedItems = selectedItems;
      },
    },
  };
  </script>

  <style lang="scss" scoped>
  .multi-select-filter {
    position: relative;
    display: inline-block;

    .label {
      display: flex;
      gap: 10px;
      align-items: center;

      span {
        font-family: "Poppins";
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        color: #4c85a7;
        cursor: pointer;
      }
    }

    .options {
      position: absolute;
      display: flex;
      flex-direction: column;
      list-style: none;
      background-color: white;
      min-width: 268px;
      max-height: 350px;
      overflow: auto;
      left: 0px;
      padding: 0px;
      top: 35px;

      border: 1px solid #fef1e7;
      max-height: 300px;
      overflow-y: auto;
      z-index: 999;

      .search-box {
        padding: 10px;
        background: #f8f8f8;
        position: sticky;
        top: 0;
        z-index: 1;

        .search-input {
          width: 100%;
          padding: 8px;
          border: 1px solid #ddd;
          border-radius: 5px;
          font-size: 14px;

          &:focus {
            outline: none !important;
            border-color: #bee7fb;
            box-shadow: 0 0 3px rgba(76, 133, 167, 0.5);
            background-color: #ffffff;
          }
        }
      }

      .option {
        border-top: 1px solid #fef1e7;

        &:first-child {
          border-top: 0;
        }

        width: 100%;

        label {
          font-family: "Poppins";
          font-style: normal;
          font-weight: 400;
          font-size: 16px;
          line-height: 20px;

          color: #4c85a7;
          cursor: pointer;

          display: flex;
          // align-items: center;
          gap: 10px;
          padding: 10px;

          .option_checkbox {
            appearance: none;

            width: 24px;

            &::before {
              content: "";
              width: 18px;
              height: 18px;
              background-color: #ffffff;
              display: block;
              outline: 1px solid #c8c8c8;
              cursor: pointer;
            }
          }

          .option_checkbox:checked {
            &::before {
              // content: '';
              // width: 30px;
              // height: 30px;
              outline: 1px solid #c8c8c8;
              border: 5px solid #ffffff;
              padding: 4px;
              background-color: #9fdcf8;
              display: block;
            }
          }

          &:hover {
            background-color: #d2eefc;
          }
        }
      }
    }
  }
  </style>
