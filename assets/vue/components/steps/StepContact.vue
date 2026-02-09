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
      <div v-if="errors?.phone" class="text-danger mt-1">
        {{ errors.phone }}
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input
          type="email"
          class="form-control"
          v-model="form.email"
      />
      <div v-if="errors?.email" class="text-danger mt-1">
        {{ errors.email }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Object,
    required: true
  },
  errors: {
    type: Object,
    default: () => ({})
  }
})

const emit = defineEmits(['update:modelValue'])

const form = computed({
  get: () => props.modelValue,
  set: value => emit('update:modelValue', value)
})
</script>
