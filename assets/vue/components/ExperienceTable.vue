<template>
  <div>
    <table class="table table-bordered table-striped">
      <thead class="table-light">
      <tr>
        <th>Firma</th>
        <th>Stanowisko</th>
        <th>Data od</th>
        <th>Data do</th>
        <th>Akcje</th>
      </tr>
      </thead>

      <tbody>
      <tr v-for="(exp, index) in experiences" :key="index">
        <td>
          <input
              type="text"
              class="form-control"
              v-model="exp.company"
          />
          <div v-if="errors[index]?.company" class="text-danger mt-1">
            {{ errors[index].company }}
          </div>
        </td>

        <td>
          <input
              type="text"
              class="form-control"
              v-model="exp.position"
          />
          <div v-if="errors[index]?.position" class="text-danger mt-1">
            {{ errors[index].position }}
          </div>
        </td>

        <td>
          <input
              type="date"
              class="form-control"
              v-model="exp.dateFrom"
          />
          <div v-if="errors[index]?.dateFrom" class="text-danger mt-1">
            {{ errors[index].dateFrom }}
          </div>
        </td>

        <td>
          <input
              type="date"
              class="form-control"
              v-model="exp.dateTo"
          />
          <div v-if="errors[index]?.dateTo" class="text-danger mt-1">
            {{ errors[index].dateTo }}
          </div>
        </td>

        <td class="text-center">
          <button
              type="button"
              class="btn btn-sm btn-danger"
              @click="remove(index)"
          >
            Usuń
          </button>
        </td>
      </tr>
      </tbody>
    </table>

    <!-- błąd globalny doświadczenia -->
    <div v-if="errors && errors[0]?.global" class="text-danger mt-2">
      {{ errors[0].global }}
    </div>

    <button
        type="button"
        class="btn btn-sm btn-primary mt-2"
        @click="add"
    >
      Dodaj doświadczenie
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: {
    type: Array,
    required: true
  },
  errors: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['update:modelValue'])

const experiences = computed({
  get: () => props.modelValue,
  set: value => emit('update:modelValue', value)
})

function add() {
  experiences.value.push({
    company: '',
    position: '',
    dateFrom: '',
    dateTo: ''
  })
}

function remove(index) {
  experiences.value.splice(index, 1)
}
</script>

<style scoped>
th, td {
  vertical-align: top;
}
</style>
