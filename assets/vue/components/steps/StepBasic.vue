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
      <div  class="text-danger mt-1" v-for="err in v$.firstName.$errors" :key="err.$validator">
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
      <div  class="text-danger mt-1" v-for="err in v$.lastName.$errors" :key="err.$validator">
        {{ err.$message }}
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Data urodzenia</label>
      <input
          type="date"
          class="form-control"
          v-model="form.birthDate"
          :max="today"
      />
      <div  class="text-danger mt-1" v-for="err in v$.birthDate.$errors" :key="err.$validator">
        {{ err.$message }}
      </div>
    </div>
  </div>
</template>


<script setup>
import { computed } from 'vue'
import { useFormValidation } from '../../validation/appFormValidation'

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

const { v$ } = useFormValidation(form)
const today = new Date().toISOString().split('T')[0]
</script>


