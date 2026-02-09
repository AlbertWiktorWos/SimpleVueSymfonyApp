<template>
  <div class="container py-5">
    <div class="card shadow-sm">
      <div class="card-body">

        <h3 class="text-center mb-4">
          Formularz 3-krokowy
        </h3>

        <!-- krok -->
        <component
            :is="currentStep"
            v-model="store.form"
            :errors="store.errors"
        />

        <!-- błędy globalne (TYLKO po submit) -->
        <div
            v-if="store.allErrorMessages.value.length"
            class="alert alert-danger mt-4"
        >
          <ul class="mb-0">
            <li
                v-for="(msg, i) in store.allErrorMessages.value"
                :key="i"
            >
              {{ msg }}
            </li>
          </ul>
        </div>

        <!-- przesłane dane -->
        <div v-if="store.submitted.value" class="alert alert-success mt-4">
          <h5>Pomyślnie przesłano dane:</h5>
          <p><strong>Imię:</strong> {{ store.form.firstName }}</p>
          <p><strong>Nazwisko:</strong> {{ store.form.lastName }}</p>
          <p><strong>Data urodzenia:</strong> {{ store.form.birthDate }}</p>

          <h6>Dane kontaktowe:</h6>
          <p><strong>Email:</strong> {{ store.form.email }}</p>
          <p><strong>Telefon:</strong> {{ store.form.phone }}</p>

          <h6>Doświadczenie zawodowe:</h6>
          <ul>
            <li v-for="(exp, i) in store.form.experiences" :key="i">
              {{ exp.company }} — {{ exp.position }} od {{ exp.dateFrom }} do {{ exp.dateTo }}
            </li>
          </ul>
        </div>

      </div>

      <!-- nawigacja -->
      <div class="card-footer d-flex justify-content-between">
        <button
            class="btn btn-secondary"
            :disabled="stepIndex === 0"
            @click="prev"
        >
          Wstecz
        </button>

        <button
            v-if="!isLastStep"
            class="btn btn-primary"
            @click="next"
        >
          Dalej
        </button>

        <button
            v-else
            class="btn btn-success"
            @click="submit"
        >
          Wyślij
        </button>
      </div>

    </div>
  </div>
</template>

<script>
import {ref, computed} from 'vue'
import {useFormStore} from '../stores/appFormStore'

import StepBasic from './steps/StepBasic.vue'
import StepContact from './steps/StepContact.vue'
import StepExperience from './steps/StepExperience.vue'

export default {
  name: 'MultiStepForm',
  components: {StepBasic, StepContact, StepExperience},
  setup() {
    const store = useFormStore()

    debugger;
    const steps = [StepBasic, StepContact, StepExperience]
    const stepIndex = ref(0)

    const currentStep = computed(() => steps[stepIndex.value])
    const isLastStep = computed(() => stepIndex.value === steps.length - 1)

    function next() {
      if (!isLastStep.value) stepIndex.value++
    }

    function prev() {
      if (stepIndex.value > 0) stepIndex.value--
    }

    async function submit() {
      const result = await store.submit()

      if (!result) {
        for (const [key, currentStepComponent] of Object.entries(steps)) {
          currentStepComponent.v$?.value?.$touch()
        }
        stepIndex.value = 0;
      }
    }

    return {
      store,
      stepIndex,
      currentStep,
      isLastStep,
      next,
      prev,
      submit
    }
  }
}
</script>

<style scoped>
.card-body {
  min-height: 400px;
  min-width: 600px;
}
</style>
