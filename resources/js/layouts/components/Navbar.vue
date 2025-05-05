<template>
  <div
    class="flex justify-center items-center bg-[#E9F7FE] w-full p-4 h-[64px]"
  >
    <div  class="logo">
      <router-link to="/">
        Dashboard
      </router-link>
    </div>
    <div class="ml-auto">
    </div>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";


const router = useRouter();

</script>

<style lang="scss" scoped>

.logo {

    font-family: Poppins;
    font-size: 22px;
    font-style: normal;
    font-weight: 700;
    line-height: 23px;
    padding: 10px 16px;
    color: #063f5f;
}
.nav_dropdown_items {
  top: 10px;
  right: 0;
  list-style: none;
  background: #ffffff;
  border: 1px solid #e6dee5;
  filter: drop-shadow(-2px 4px 14px rgba(91, 91, 91, 0.25));
  z-index: 99999;

  li {
    padding: 15px 24px;

    font-family: Poppins;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: 23px;
    padding: 10px 16px;
    color: #063f5f;

    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 17px;
    position: relative;

    .sub-dropdown {
      min-width: 150px;
      position: absolute;
      top: 0;
      list-style: none;
      background: #ffffff;
      border: 1px solid #e6dee5;
      border-radius: 10px;
      // filter: drop-shadow(-2px 4px 14px rgba(91, 91, 91, 0.25));
      z-index: 99999;

      li {
        padding: 15px 24px;
        font-family: "Inter";
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 19px;
      }
    }
  }
}
.user_information {
  h4 {
    color: var(--Primary-Astronaut-Blue, #063f5f);
    /* Nexa Bold / 18 */
    font-family: Nexa;
    font-size: 18px;
    font-style: normal;
    font-weight: 700;
    line-height: normal;
  }

  p {
    color: var(--Primary-Astronaut-Blue, #063f5f);
    /* Ubuntu / Regular / 15 */
    font-family: Ubuntu;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
  }
}

.caret {
  margin-top: -10px;
}

.logo {
  // position: absolute;
  // top: 10;
  // left: 50%;
  // transform: translateX(-50%);
  margin-left: 15px;
}
</style>
