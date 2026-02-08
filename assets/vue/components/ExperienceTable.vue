<template>
  <div>
    <table class="table table-bordered table-striped">
      <thead class="table-light">
      <tr>
        <th class="cell">Firma</th>
        <th class="cell">Stanowisko</th>
        <th class="cell">Data od</th>
        <th class="cell">Data do</th>
        <th class="cell"> Akcje </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(exp, index) in experiences" :key="index">
        <td>
          <input type="text" class="form-control" v-model="exp.company" required />
          <div v-if="errors[index]?.company" class="text-danger mt-1">
            {{ errors[index].company }}
          </div>
        </td>
        <td>
          <input type="text" class="form-control" v-model="exp.position" required />
          <div v-if="errors[index]?.position" class="text-danger mt-1">
            {{ errors[index].position }}
          </div>
        </td>
        <td>
          <input type="date" class="form-control" v-model="exp.dateFrom" required />
          <div v-if="errors[index]?.dateFrom" class="text-danger mt-1">
            {{ errors[index].dateFrom }}
          </div>
        </td>
        <td>
          <input type="date" class="form-control" v-model="exp.dateTo" required />
          <div v-if="errors[index]?.dateTo" class="text-danger mt-1">
            {{ errors[index].dateTo }}
          </div>
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-danger" @click="removeExperience(index)">
            Usuń
          </button>
        </td>
      </tr>
      </tbody>
    </table>

    <div v-if="errors[0]?.global" class="text-danger mt-1">
      {{ errors[0]?.global }}
    </div>

    <button type="button" class="btn btn-sm btn-primary mt-2" @click="addExperience">
      Dodaj doświadczenie
    </button>
  </div>
</template>



<script>
export default {
  name: 'ExperienceTable',
  props: {
    modelValue: {
      type: Array,
      default: () => []
    },
    errors: {
      type: Array,
      default: () => []
    }
  },
  computed: {
    experiences: {
      get() { return this.modelValue; },
      set(value) { this.$emit('update:modelValue', value); }
    }
  },
  methods: {
    addExperience() {
      this.experiences.push({ company: '', position: '', dateFrom: '', dateTo: '' });
    },
    removeExperience(index) {
      this.experiences.splice(index, 1);
    }
  }
};
</script>

<style scoped>
.cell {
  width: 100px;
}
</style>