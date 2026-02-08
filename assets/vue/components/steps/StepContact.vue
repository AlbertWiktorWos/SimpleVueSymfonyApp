<template>
  <div>
    <h2 class="mb-3">Dane kontaktowe</h2>

    <div class="mb-3">
      <label class="form-label">Telefon</label>
      <input type="text"
             class="form-control"
             v-model="form.phone"
             required
             pattern="^\\+?[0-9]{9,15}$" />
      <div v-if="$parent.errors.phone" class="text-danger mt-1">{{ $parent.errors.phone }}</div>
    </div>

    <div class="mb-3">
      <label class="form-label">E-mail</label>
      <input type="email" class="form-control" v-model="form.email" required />
      <div v-if="$parent.errors.email" class="text-danger mt-1">{{ $parent.errors.email }}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'StepContact',
  props: ['modelValue'],
  computed: {
    form: {
      get() { return this.modelValue; },
      set(value) { this.$emit('update:modelValue', value); }
    }
  }
};
</script>
