<template>
  <div class="filters h-12" :class="filterClass">
    <div class="filter-btn">
      <button
        class="flex items-center justify-center gap-2.5 h-12 w-[130px] bg-[#BEE7FB]"
      >
        <svg
          width="40"
          height="40"
          viewBox="0 0 40 40"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M6.66797 6.66666L15.0013 20V30L25.0013 35V20L33.3346 6.66666H6.66797Z"
            stroke="#063F5F"
            stroke-width="2.5"
            stroke-linecap="round"
          />
        </svg>
        {{ "Filter" }}
      </button>
    </div>
    <div class="filter-content">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    filterClass: {
      type: String,
      default: "",
    },
  },
};
</script>

<style lang="scss" scoped>
.filters {
  display: flex;
  align-items: center;
  // width: 90%;
}
.filter-content {
  width: 100%;
  background: white;
  height: 48px;
  padding: 12px 24px;
  display: flex;
  align-items: center;
  gap: 12px;
}
</style>
