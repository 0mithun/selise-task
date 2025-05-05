<template>
    <div class="content px-8 py-10">
      <div class="card">
        <BackButton />
        <h3 class="card__title">{{ "Edit employee" }}</h3>
        <div class="form-row flex-wrap mt-8">
          <div class="form-column w-[31%]">
            <TextInput
              label="Name"
              :asterisk="true"
              placeholder="Enter name"
              v-model="form.name"
              :error="v$.name.$errors[0]?.$message"
              maxLength="51"
              :showError="true"
              @input="
                () => {
                  v$.name.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Email"
              :asterisk="true"
              placeholder="Enter email"
              v-model="form.email"
              :error="v$.email.$errors[0]?.$message"
              maxLength="51"
              :showError="true"
              @input="
                () => {
                  v$.email.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <SingleSelect
              label="Department"
              :asterisk="true"
              :options="department_lists"
              v-model="form.department_id"
              labelKey="name"
              valueKey="id"
              placeholder="Select Department"
              :searchable="false"
              :searchables="['label']"
              @input="() => {}"
              :error="v$.department_id.$errors[0]?.$message"
            />

          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Designation"
              :asterisk="true"
              placeholder="Enter designation"
              v-model="form.designation"
              :error="v$.designation.$errors[0]?.$message"
              maxLength="51"
              :showError="true"
              @input="
                () => {
                  v$.designation.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Address"
              :asterisk="true"
              placeholder="Enter address"
              v-model="form.address"
              :error="v$.address.$errors[0]?.$message"
              maxLength="51"
              :showError="true"
              @input="
                () => {
                  v$.address.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <TextInput
              label="Salary"
              :asterisk="true"
              placeholder="Enter salary"
              v-model="form.salary"
              :error="v$.salary.$errors[0]?.$message"
              maxLength="51"
              :showError="true"
              @input="
                () => {
                  v$.salary.$touch();
                }
              "
            />
          </div>
          <div class="form-column w-[31%]">
            <SingleDatePicker
              label="Joined Date"
              :asterisk="true"
              v-model="form.joined_date"
              :error="v$.joined_date.$errors[0]?.$message"
              :showError="true"
              :readonly="true"
            />
          </div>


        </div>
        <div class="form-row">
          <div class="form-column w-[31%]">
            <SubmitButton
              @click.prevent="update"
              :class="{ 'btn-disabled': loading } "
          >
            Update
          </SubmitButton>
          </div>
        </div>
      </div>

    </div>
  </template>

  <script setup>
  import TextInput from "@/components/form/TextInput.vue";
  import SingleDatePicker from "@/components/form/SingleDatePicker.vue";

  import SubmitButton from "@/components/Button/SubmitButton.vue";
  import BackButton from "@/components/Button/BackButton.vue";
  import SingleSelect from "@/components/form/SingleSelect.vue";


  import Form from "vform";
  import { useVuelidate } from "@vuelidate/core";
  import { computed, inject, reactive, ref } from "@vue/runtime-core";
  import { useRoute, useRouter } from "vue-router";
  import dayjs from "dayjs";
  const vRoute = useRoute()
  const router = useRouter();
  const emitter = inject("emitter");

  import { required, maxLength, helpers, email, numeric } from "@vuelidate/validators";
  import axios from "axios";


  const componentKey = ref(0);
  const loading = ref(false)

  const form = reactive(
    new Form({
      name: null,
      email: null,
      department_id: null,
      designation: null,
      salary: null,
      address: null,
      joined_date: "",
    })
  );

  const department_lists= ref([])


  const rules = computed(()=> {
      return {
          name: {
              required: helpers.withMessage("Value Required", required),
          },
          email: {
              required: helpers.withMessage("Value Required", required),
              email: helpers.withMessage("Invalid email format", email),
          },
          department_id: {
              required: helpers.withMessage("Value Required", required),
          },
          designation: {
              required: helpers.withMessage("Value Required", required),
          },
          salary: {
              required: helpers.withMessage("Value Required", required),
              number: helpers.withMessage("Please input number", numeric),
          },
          address: {
              required: helpers.withMessage("Value Required", required),
          },
          joined_date: {
              required: helpers.withMessage("Value Required", required),
          },
      };
  })


  const v$ = useVuelidate(rules, form);

  const getDepartments = async ()=> {
      try {
          const {data} = await axios.get('/api/departments');

          department_lists.value = data.data
      } catch (error) {

      }
  }

  const getEmployee = async ()=> {
      try {
        const {data} = await axios.get(`/api/employees/${vRoute.params.id}`);

        const employee = data.data

        form.name = employee.name
        form.email = employee.email
        form.department_id = employee.department_id
        form.designation = employee.detail.designation
        form.salary = employee.detail.salary
        form.address = employee.detail.address
        form.joined_date = employee.detail.joined_date

      } catch (error) {
        console.log(error)
      }
  }

  const update = async () => {
    v$.value.$touch();
    if (v$.value.$invalid) {
      return;
    }
    try {
      loading.value = true
      form.joined_date = dayjs(form.joined_date).format("YYYY-MM-DD");
      const res = await axios.put(`/api/employees/${vRoute.params.id}`, form);
      emitter.emit(`show-success-notification`, "Employees successfully updated");
      vRouter.push({ name: "employees.index" });
    } catch (error) {
      emitter.emit(`show-fail-notification`, "Something went wrong please try again");
      console.log(error);
    } finally {
      loading.value = false
    }
  };


  getDepartments()
  getEmployee()
  </script>

  <style lang="scss" scoped>
  </style>

