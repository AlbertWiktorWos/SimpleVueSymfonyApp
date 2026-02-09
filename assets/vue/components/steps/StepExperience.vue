<template>
  <div>
    <h2 class="mb-3">Doświadczenie zawodowe</h2>

    <div>
      <table class="table table-bordered table-striped">
        <thead class="table-light">
        <tr>
          <th>Firma</th>
          <th>Stanowisko</th>
          <th>Data od</th>
          <th>Data do</th>
          <th>Akcje</th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="(exp, index) in form.experiences" :key="index">
          <td>
            <input type="text" v-model="exp.company" class="form-control"/>
            <div v-if="v$.experiences && v$.experiences.$each.$response && v$.experiences.$each.$response.$errors[index].company" class="text-danger mt-1">
              <div
                  v-for="error in v$.experiences.$each.$response.$errors[index].company"
                  :key="error"
              >
                {{ error.$message }}
              </div>
            </div>
          </td>

          <td>
            <input type="text" v-model="exp.position" class="form-control"/>
            <div v-if="v$.experiences && v$.experiences.$each.$response && v$.experiences.$each.$response.$errors[index].position" class="text-danger mt-1">
              <div
                  v-for="error in v$.experiences.$each.$response.$errors[index].position"
                  :key="error"
              >
                {{ error.$message }}
              </div>
            </div>
          </td>

          <td>
            <input type="date" v-model="exp.dateFrom" class="form-control"/>
            <div v-if="v$.experiences && v$.experiences.$each.$response && v$.experiences.$each.$response.$errors[index].dateFrom" class="text-danger mt-1">
              <div
                  v-for="error in v$.experiences.$each.$response.$errors[index].dateFrom"
                  :key="error"
              >
                {{ error.$message }}
              </div>
            </div>
          </td>

          <td>
            <input type="date" v-model="exp.dateTo" class="form-control"/>
            <div v-if="v$.experiences && v$.experiences.$each.$response && v$.experiences.$each.$response.$errors[index].dateTo" class="text-danger mt-1">
              <div
                  v-for="error in v$.experiences.$each.$response.$errors[index].dateTo"
                  :key="error"
              >
                {{ error.$message }}
              </div>
            </div>
          </td>

          <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger" @click="remove(index)">
              Usuń
            </button>
          </td>
        </tr>
        </tbody>
      </table>

      <button
          type="button"
          class="btn btn-sm btn-primary mt-2"
          @click="add"
      >
        Dodaj doświadczenie
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import {useFormValidation} from "../../validation/appFormValidation";

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  }
})

function add() {
  form.value.experiences.push({
    company: '',
    position: '',
    dateFrom: null,
    dateTo: null
  })
}

function remove(index) {
  form.value.experiences.splice(index, 1)
}

const emit = defineEmits(['update:modelValue'])

const form = computed({
  get: () => props.modelValue,
  set: value => emit('update:modelValue', value)
})
const { v$ } = useFormValidation(form)

</script>
