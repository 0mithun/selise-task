<template>
  <div
    class="sort flex items-center"
    @mouseover="hover = true"
    @mouseleave="hover = false"
  >
    <span @click="sort" class="label" :class="{ disabled: !enable }">
        {{ label }}
    </span>
    <span
      class="icon"
      :class="{
        visible: enable && (hover || columnName == $route.query.order_by),
      }"
      @click="sort"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 32 32"
        fill="none"
        class="sort-icon -ml-3"
        :class="{ 'mt-3': direction == 'ASC', 'mb-1': direction == 'DESC' }"
        v-if="enable"
      >
        <path
          v-if="direction == 'ASC'"
          d="M16 10L11 16H21L16 10Z"
          fill="#42BEAF"
        />
        <path v-else d="M16 22L11 16H21L16 22Z" fill="#42BEAF" />
      </svg>
    </span>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: [String, Object],
      required: true,
    },
    columnName: {
      type: String,
      required: true,
    },
    enable: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      direction: null,
      hover: false,
    };
  },
  created() {
    const order_by = this.$route.query.order_by;
    const direction = this.$route.query.direction;
    if (this.columnName == order_by) this.direction = direction;
  },
  watch: {
    direction(newValue, oldValue) {
      const queries = this.$route.query;
      delete queries.page;
      const routeObj = {
        name: route.name,
        params: { ...this.$route.params },
        query: {
          ...queries,
          order_by: this.columnName,
          direction: this.direction,
        },
      };

      // console.log('sort')

      this.$router.push(routeObj);
    },
  },
  methods: {
    sort() {
      if (!this.enable) return;

      const direction = this.direction ? this.direction : "DESC";
      this.direction = direction.toUpperCase() == "ASC" ? "DESC" : "ASC";
    },
  },
};
</script>

<style lang="scss" scoped>
.sort {
  color: var(--Secondary-Dark-turquoise, #42beaf);

  font-family: Nexa;
  font-size: 18px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;

  align-items: center;

  .label {
    cursor: pointer;
    &.disabled {
      cursor: default;
    }
  }
  .icon {
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    // opacity: 0;
    // visibility: hidden;
    // pointer-events: none;

    transition: opacity 0.2s ease-in-out, visibility 0.2s ease-in-out;

    svg.sort-icon {
      width: 48px;
      display: block;
      margin-bottom: 4px;
    }

    &.visible {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }
  }
}
</style>
