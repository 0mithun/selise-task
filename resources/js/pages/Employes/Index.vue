<template>
  <div class="px-8 py-6 content">
    <h3 class="overview__title">{{ "Employees" }}</h3>
    <OverviewTable
      :search_enabled="true"
      :footer_enabled="false"
      :paginationData="paginationData"
      class="!border-t-0"
      bodyClass=""
      headerClass=""
      headerTopClass="!py-0 !border-t-0"
      placeholder="Search by employee name"
    >
      <template #filter>
        <Filter filterClass="w-[90%]">
          <div style="width: 10%;"></div>
          <MultiSelectFilter
            column="department"
            label="Department"
            routeName="employee-get-filter-dropdown-data"
            valueKey="id"
            labelKey="name"
            style="width: 30%"
          />
        </Filter>
      </template>

      <template #overview-top-right>
        <AddNewButton label="Add new employee" routeName="employees.create" />
      </template>

      <template #header>
        <SortTableColumn
          label="Name"
          columnName="name"
          style="width: 15%"
        />
        <SortTableColumn
          label="email"
          columnName="email"
          style="width: 15%"
        />
        <SortTableColumn
          label="Department"
          columnName="department"
          style="width: 15%"
        />
        <SortTableColumn
          label="Designation"
          columnName="designation"
          style="width: 15%"
        />
        <SortTableColumn
          label="Address"
          columnName="address"
          style="width: 15%"
        />
        <SortTableColumn
          label="Salary"
          columnName="salary"
          style="width: 10%"
        />
        <SortTableColumn
          label="Joined Date"
          columnName="joined_date"
          style="width: 10%"
          :enable="true"
        />
        <div style="width: 5%"></div>
      </template>
      <template #body>
        <TableRow v-for="row in overviewData" :key="row.id" :employee="row" />
      </template>
    </OverviewTable>
  </div>
</template>

<script setup>
import { onMounted, ref, watch, reactive } from "@vue/runtime-core";
import { storeToRefs } from "pinia";
import { useRoute, useRouter } from "vue-router";
import OverviewTable from "@/components/table/OverviewTable.vue";
import TableRow from "./components/TableRow.vue";
import SortTableColumn from "@/components/sort/SortTableColumn.vue";

import axios from "axios";
import { isNumber } from "lodash";

import AddNewButton from "@/components/Button/AddNewButton.vue";

import Filter from "@/components/Filters/Filter.vue";
import MultiSelectFilter from "@/components/Filters/MultiSelectFilter.vue";

const overviewData = ref([]);
const paginationData = ref({});

const vRoute = useRoute();
const router = useRouter();

const loading = ref(false);

async function getData() {
  const queryParams = { ...vRoute.query };
  try {
    const { data } = await axios.get(
      route("employees.index", { _query: queryParams })
    );
    overviewData.value = data.data;
    paginationData.value = data.meta;
  } catch (error) {
  } finally {
    loading.value = false;
  }
}
getData();

watch(
  () => vRoute.fullPath,
  async () => {
    getData();
  }
);
</script>

<style lang="scss" scoped>
//
</style>
