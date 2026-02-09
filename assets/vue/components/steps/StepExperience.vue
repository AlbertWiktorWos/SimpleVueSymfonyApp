<template>
  <div>
    <h2 class="mb-3">Doświadczenie zawodowe</h2>

    <ExperienceTable
        v-model="form.experiences"
        :errors="errors?.experiences || []"
    />
  </div>
</template>

<script setup>
import { computed } from 'vue'
import ExperienceTable from '../ExperienceTable.vue'

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
