<template>
  <div>
    <h2 class="mb-3">Doświadczenie zawodowe</h2>
    <experience-table
        v-model="form.experiences"
        :errors="$parent.errors.experiences || {}"
    ></experience-table>
  </div>
</template>


<script>
import ExperienceTable from '../ExperienceTable.vue';

export default {
  name: 'StepExperience',
  components: { ExperienceTable },
  props: ['modelValue'],
  computed: {
    form: {
      get() { return this.modelValue; },
      set(value) { this.$emit('update:modelValue', value); }
    }
  }
};
</script>
