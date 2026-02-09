<template>
  <div>
    <h2 class="mb-3">Dane kontaktowe</h2>

    <div class="mb-3">
      <label class="form-label">Telefon</label>
      <input
          type="text"
          class="form-control"
          v-model="form.phone"
      />
      <div  class="text-danger mt-1" v-for="err in v$.phone.$errors" :key="err.$validator">
        {{ err.$message }}
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input
          type="email"
          class="form-control"
          v-model="form.email"
      />
      <div  class="text-danger mt-1" v-for="err in v$.email.$errors" :key="err.$validator">
        {{ err.$message }}
      </div>
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

const emit = defineEmits(['update:modelValue'])

const form = computed({
  get: () => props.modelValue,
  set: value => emit('update:modelValue', value)
})
const { v$ } = useFormValidation(form)
</script>
