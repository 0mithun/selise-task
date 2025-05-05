<template>
  <nav
    id="sidebar"
    class="bg-[#063F5F] h-auto ease-in-out duration-300 w-[300px]"
  >
    <div
      class="relative h-screen min-h-content flex flex-col"
      :class="{ 'collapse-nav': !sidebarFullView }"
      style="min-height: 100vh !important"
    >
      <div class="menu flex flex-col justify-between flex-grow">
        <div class="flex-grow overflow-auto mt-5">
          <SidebarLink
            routeName="employees.index"
            :isActive="
              isInclude(['employees.index', 'employees.create', 'employees.edit'])
            "
            :isFullView="sidebarFullView"
          >
            <template #icon>
              <SessionIcon />
            </template>
            {{ "Employee" }}
          </SidebarLink>

        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import SidebarLink from "./SidebarLink.vue";
import SessionIcon from "./Icons/SessionIcon.vue";

import { onBeforeMount, reactive, ref, computed } from "vue";
import { useRoute } from "vue-router";
import { storeToRefs } from "pinia";
const vRoute = useRoute();

const sidebarFullView = ref(true);
const collapseSidebar = () => (sidebarFullView.value = false);
const expandSidebar = () => (sidebarFullView.value = true);
const componentKey = ref(0);

const isInclude = (routeNames = []) => {
  return routeNames.includes(vRoute.name);
};
</script>

<style lang="scss" scoped>
#sidebar {
  box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.25);
  flex: none;
}
.company {
  color: #bee7fb;
  /* Ubuntu / Regular / 22 */
  font-family: Ubuntu;
  font-size: 18px;
  font-style: normal;
  font-weight: 400;
  line-height: normal;
  position: fixed;
  width: 100%;
  bottom: 0;
  left: 0;
  margin: 0;

  width: 275px;
}
</style>
