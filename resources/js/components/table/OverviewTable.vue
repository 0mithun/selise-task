<template>
  <div class="overview__table">
    <div
      class="overview__table--header__top flex items-center h-[70px] gap-10"
      :class="[$attrs.headerTopClass]"
      v-if="headerTop"
    >
      <slot name="header-top">
        <div class="overview__top--search min-w-[50%]" v-if="search_enabled">
          <slot name="overview-search">
            <OverviewTableSearch :placeholder="placeholder" />
          </slot>
        </div>
        <div class="overview__top--right ml-auto" style="margin-left: auto;width: fit-content;">
          <slot name="overview-top-right"> </slot>
        </div>
      </slot>
    </div>
    <div
      class="overview__table--filter flex items-center h-[70px]"
      :class="[$attrs.filterClass]"
    >
      <slot name="filters">
        <div class="filter w-full">
          <slot name="filter" />
        </div>
        <div class="ml-auto min-w-fit">
          <EntriesPerPage />
        </div>
      </slot>
    </div>
    <div class="flex flex-col w-full header-body-wrapper">
      <div
        class="flex overview__table--header"
        :class="[$attrs.headerClass]"
        ref="header"
      >
        <slot name="header" />
      </div>
      <div
        class="overview__table--body"
        :class="[$attrs.bodyClass]"
        ref="overview__table__body"
      >
        <slot name="body" v-if="paginationData.total>0" />
        <NoResoultFound v-else-if="paginationData && paginationData.total==0" />
      </div>
    </div>

    <div class="flex justify-between overview__table--footer" v-if="paginationData.total>0">
      <div class="pagination">
        <Pagination :pagination="paginationData" />
      </div>
    </div>
  </div>
</template>

<script>
import EntriesPerPage from "./EntriesPerPage.vue";
// import DownArrowIcon from '@/components/icons/DownArrowIcon.vue'
// import UpArrowIcon from '@/components/icons/UpArrowIcon.vue'
import Pagination from "./Pagination.vue";
import OverviewTableSearch from "./OverviewTableSearch.vue";
import NoResoultFound from "@/components/NoResoultFound.vue";

export default {
  components: { Pagination, EntriesPerPage, OverviewTableSearch, NoResoultFound },
  props: {
    paginationData: {
      type: Object,
      required: true,
    },
    headerTop: {
      type: Boolean,
      default: true,
    },
    filter: {
      type: Boolean,
      default: true,
    },
    search_enabled: {
      type: Boolean,
      default: true,
    },
    placeholder: {
      type: String,
      default: "Search...",
    },
  },
  data() {
    return {
      openPerPageDropdown: false,
      per_page: null,
    };
  },
  created() {
    const per_page = this.$route.query.per_page;
    this.per_page = per_page ?? 25;
  },

  methods: {
    setPerPage(perPage) {
      this.openPerPageDropdown = false;
      this.per_page = perPage;

      const queries = this.$route.query;

      delete queries.page;
      this.$router.push({ query: { ...queries, per_page: perPage } });
    },
  },
};
</script>

<style lang="scss">
.overview__table--header {
  // @apply !pl-4 !pr-5;
  border-bottom: 1px solid #e3e3e3;
  width: 100%;
  height: 55px;
  padding-left: 16px;
  padding-right: 20px;
//   gap: 12px;
}
.overview__table--header__top {
  @apply w-full justify-between bg-[#E9F7FE] px-4 py-4;
  // border-bottom: 1px solid #E3E3E3;
}
.overview__table--filter {
  @apply w-full justify-between bg-[#E9F7FE] px-4 pb-3;
  // border-bottom: 1px solid #E3E3E3;
}

.overview__table--footer {
  @apply px-[30px] py-6 pb-0;
  border-top: 1px solid #e3e3e3;
}

.overview__table--body .tr {
  @apply flex items-center  min-h-[55px] border-b border-[#D3E3EC] last:border-b-0 px-6 bg-[#E9F7FE];

  color: var(--1-4, #2c5b7d);
  font-family: Nexa;
  font-size: 18px;
  font-style: normal;
  font-weight: 400;
  line-height: 33px;

  &:hover {
    background: #d2eefc;
  }
}

.td {
  @apply text-[#636363] break-words;

  font-style: normal;
  font-weight: 400;
  font-size: 16px;
  line-height: 19px;
}

.td-link {
  @apply text-[#E97D32] font-semibold;
}

.table__menubar {
  @apply relative flex justify-end;
}
.table__menubar .bar-icon {
  @apply cursor-pointer;
}

.table__menubar__dropdown {
  @apply absolute list-none bg-white min-w-[160px]   top-0 right-0 z-[99];
}
.overview__table--body
  .tr:last-child
  .td
  .table__menubar
  .table__menubar__dropdown {
  /* bottom: 0;
        top: auto; */
}

.table__menubar__dropdown:last-of-type {
  /* bottom: 0;
        top: auto; */
}

.table__menubar__dropdown li {
  color: var(--Tints-5, #135f84);
  font-family: Nexa;
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
  line-height: 20px;
  border-bottom: 1px solid #fef1e7;
  &:hover {
    background: #bee7fb;
  }
  &:last-child {
    border: none;
  }
}

.table__menubar__dropdown a {
  @apply block hover:cursor-pointer;
  padding: 8px 16px;
}

.pagination {
  width: 100%;
}

.per__page--input {
  font-family: "Inter";
  font-style: normal;
  font-weight: 500;
  font-size: 14px;
  line-height: 17px;
  color: #636363;

  svg {
    // margin-left: 14px;
  }
}

.per__page--dropdown {
  list-style: none;
  width: 65px;
  top: 28px;
  right: 0;
  //   width: 100%;
  background: #ffffff;
  //   border: 1px solid #FEF1E7;
  //   border-radius: 0px 0px 2px 2px;
  li {
    color: var(--1-5, #093e60);

    /* Nexa Reg / 13 */
    font-family: Nexa;
    font-size: 13px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;

    padding: 10px 16px;

    border-bottom: 1px solid #fef1e7;

    &:last-child {
      border-bottom: none;
    }
  }
}

.entries_per_page {
  color: var(--Primary-Astronaut-Blue, #063f5f);

  /* Nexa Reg/18 */
  font-family: Nexa;
  font-size: 18px;
  font-style: normal;
  font-weight: 400;
  line-height: 33px; /* 183.333% */
}
</style>
