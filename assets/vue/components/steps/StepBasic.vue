<template>
  <div>
    <h2 class="mb-3">Dane podstawowe</h2>

    <div class="mb-3">
      <label class="form-label">Imię</label>
      <input type="text" class="form-control" v-model="form.firstName" required />
      <div v-if="$parent.errors.firstName" class="text-danger mt-1">{{ $parent.errors.firstName }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Nazwisko</label>
      <input type="text" class="form-control" v-model="form.lastName" required />
      <div v-if="$parent.errors.lastName" class="text-danger mt-1">{{ $parent.errors.lastName }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Data urodzenia</label>
      <input type="date" class="form-control" v-model="form.birthDate" :max="today" required />
      <div v-if="$parent.errors.birthDate" class="text-danger mt-1">{{ $parent.errors.birthDate }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'StepBasic',
  props: {
    modelValue: Object
  },
  computed: {
    form: {
      get() { return this.modelValue; },
      set(value) { this.$emit('update:modelValue', value); }
    },
    today() {
      return new Date().toISOString().split('T')[0];
    }
  }
};
</script>
