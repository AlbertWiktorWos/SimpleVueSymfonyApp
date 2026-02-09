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
      <div v-if="errors?.firstName" class="text-danger mt-1">
        {{ errors.firstName }}
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nazwisko</label>
      <input
          type="text"
          class="form-control"
          v-model="form.lastName"
      />
      <div v-if="errors?.lastName" class="text-danger mt-1">
        {{ errors.lastName }}
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
      <div v-if="errors?.birthDate" class="text-danger mt-1">
        {{ errors.birthDate }}
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

const today = new Date().toISOString().split('T')[0]
</script>

