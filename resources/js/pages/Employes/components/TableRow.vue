<template>
  <div class="table-row tr">
    <div class="td" style="width: 15%">
      {{ data.name }}
    </div>
    <div class="td" style="width: 15%">
      {{ data.email }}
    </div>
    <div class="td" style="width: 15%">
        {{ data.department.name }}
    </div>
    <div class="td" style="width: 15%">
      {{ data.detail.designation }}
    </div>
    <div class="td" style="width: 15%">
        {{ data.detail.address }}
    </div>
    <div class="td" style="width: 10%">
        {{ data.detail.salary }}
    </div>
    <div class="td" style="width: 10%">
        {{ data.detail.joined_date }}
    </div>
    <div class="td flex items-center gap-2" style="width: 5%">
        <span class="cursor-pointer" @click="edit">
            <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <g>
                <path d="M20,16v4a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V6A2,2,0,0,1,4,4H8" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                <polygon fill="none" points="12.5 15.8 22 6.2 17.8 2 8.3 11.5 8 16 12.5 15.8" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </g>
            </svg>
        </span>

        <span class="cursor-pointer" @click="deleteEmployee">
            <svg width="26px" height="26px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        </span>
    </div>
  </div>
</template>

<script >
import dayjs from "dayjs";
import axios from 'axios';

export default {
  props: {
    employee: {
      type: Object,
      requied: true,
    },
  },
  data() {
    return {
      data: this.employee,
      componentKey: 0,
    };
  },
  methods: {
    formatDate(date) {
      return dayjs(date).format("DD.MM.YYYY");
    },
    edit() {
        this.$router.push({name:'employees.edit', params: {id: this.data.id}})
    },
    async deleteEmployee() {
        if(confirm("Are you sure?")) {
            try {
                await axios.delete(`/api/employees/${this.data.id}`)
                this.emitter.emit(`show-success-notification`, "Employees successfully deleted");

                this.$router.push({ query: {
                    _hash: new Date().getTime(),
                } });

            } catch (error) {
                console.log(error)
            }
        }

    }
  },
};
</script>

<style lang="scss" scoped>
.table-row.tr {
  padding: 0 20px 0 15px !important;
}
</style>
