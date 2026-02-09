<template>
  <div>
    <h2 class="mb-3">Dane podstawowe</h2>

    <div class="mb-3">
      <label class="form-label">Imię</label>
      <input
          type="text"
          class="form-control"
          v-model="form.firstName"
      />
      <div class="text-danger mt-1" v-for="err in v$.firstName.$errors" :key="err.$validator">
        {{ err.$message }}
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nazwisko</label>
      <input
          type="text"
          class="form-control"
          v-model="form.lastName"
      />
      <div class="text-danger mt-1" v-for="err in v$.lastName.$errors" :key="err.$validator">
        {{ err.$message }}
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Data urodzenia</label>
      <input
          type="date"
          class="form-control"
          v-model="form.birthDate"
          :max="yesterday"
      />
      <div class="text-danger mt-1" v-for="err in v$.birthDate.$errors" :key="err.$validator">
        {{ err.$message }}
      </div>
    </div>
  </div>
</template>


<script setup>
import {computed, onMounted} from 'vue'
import {useFormValidation} from '../../validation/appFormValidation'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['update:modelValue'])

const form = computed({
  get: () => props.modelValue,
  set: value => emit('update:modelValue', value)
})

const {v$} = useFormValidation(form)
const yesterdayDate = new Date();
yesterdayDate.setDate(yesterdayDate.getDate() - 1);
const yesterday = yesterdayDate.toISOString().split('T')[0];
onMounted(() => {
  v$.value.$touch()   // wszystkie pola stają się dirty i błędy będą widoczne
})
</script>


