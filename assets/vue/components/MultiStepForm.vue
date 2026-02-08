<template>
  <div class="container py-5 main-container">
    <div class="card shadow-sm">
      <div class="card-body">
        <h3 class="card-title mb-4 text-center">Formularz 3-krokowy</h3>

        <!-- Step component -->
        <component
            :is="currentStepComponent"
            v-model="formData"
            :errors="errors"
        ></component>

                <!-- Response -->
        <div v-if="submitted" class="mt-3 alert alert-success">
          <h5>Pomyślnie przesłano:</h5>

          <p><strong>Imię:</strong> {{ formData.firstName }}</p>
          <p><strong>Nazwisko:</strong> {{ formData.lastName }}</p>
          <p><strong>Data urodzenia:</strong> {{ formData.birthDate }}</p>

          <h6>Dane kontaktowe:</h6>
          <p><strong>Email:</strong> {{ formData.email }}</p>
          <p><strong>Telefon:</strong> {{ formData.phone }}</p>

          <h6>Doświadczenie zawodowe:</h6>
          <ul>
            <li v-for="(exp, i) in formData.experiences" :key="i">
              {{ exp.company }} — {{ exp.position }} od {{ exp.dateFrom }} do {{ exp.dateTo }}
            </li>
          </ul>
        </div>
      </div>

      <div class="p-2">
        <!-- Wyświetlanie wszystkich błędów -->
        <div v-if="hasErrors()" class="alert alert-danger">
          <ul class="mb-0">
            <li v-for="(msg, i) in allErrorMessages" :key="i">{{ msg }}</li>
          </ul>
        </div>

      </div>


      <!-- Navigation -->
      <div class="p-5 d-flex justify-content-between mt-4">
        <button class="btn btn-secondary btn-lg" @click="prevStep" :disabled="currentStep === 0">
          Wstecz
        </button>

        <div>
          <button
              v-if="!isLastStep"
              class="btn btn-primary btn-lg"
              @click="nextStep"
          >
            Dalej
          </button>
          <button
              v-else
              class="btn btn-success btn-lg"
              @click="submitForm"
          >
            Wyślij
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import StepBasic from './steps/StepBasic.vue';
import StepContact from './steps/StepContact.vue';
import StepExperience from './steps/StepExperience.vue';
import { sendForm } from '../services/api';

export default {
  name: 'MultiStepForm',
  components: { StepBasic, StepContact, StepExperience },
  data() {
    return {
      currentStep: 0,
      steps: [StepBasic, StepContact, StepExperience],
      formData: {
        firstName: '',
        lastName: '',
        birthDate: '',
        email: '',
        phone: '',
        experiences: []
      },
      responseData: null,
      submitted: false,
      errors: {
        firstName: null,
        lastName: null,
        birthDate: null,
        email: null,
        phone: null,
        experiences: []
      },
      allErrorMessages: []
    };
  },
  computed: {
    currentStepComponent() {
      return this.steps[this.currentStep];
    },
    isLastStep() {
      return this.currentStep === this.steps.length - 1;
    },
  },
  methods: {
    nextStep() {
      if (this.currentStep < this.steps.length - 1) this.currentStep++;
    },
    prevStep() {
      if (this.currentStep > 0) this.currentStep--;
    },
    hasErrors() {
      debugger;
      // sprawdza, czy są jakieś błędy w głównych polach lub contact lub experiences
      return this.allErrorMessages.length > 0;
    },
    async submitForm() {
      try {

        const payload = {
          firstName: this.formData.firstName,
          lastName: this.formData.lastName,
          birthDate: this.formData.birthDate,
          contact: {
            email: this.formData.email,
            phone: this.formData.phone
          },
          workExperiences: this.formData.experiences
        };

        const res = await sendForm(payload);
        if (res.success) {
          this.responseData = res;
          this.submitted = true;
          this.errors = {}; // czyszczenie błędów przy powodzeniu
          this.allErrorMessages = [];
          debugger;

          this.formData = {
            firstName: res.data.firstName ?? '',
            lastName: res.data.lastName ?? '',
            birthDate: res.data.birthDate?.substring(0, 10) ?? '',

            email: res.data.contact?.email ?? '',
            phone: res.data.contact?.phone ?? '',

            experiences: Array.isArray(res.data.workExperiences)
                ? res.data.workExperiences.map(exp => ({
                  company: exp.company ?? '',
                  position: exp.position ?? '',
                  dateFrom: exp.dateFrom?.substring(0, 10) ?? '',
                  dateTo: exp.dateTo?.substring(0, 10) ?? ''
                }))
                : []
          };
        } else {
          // mapowanie błędów na pola
          this.errors = {
            firstName: null,
            lastName: null,
            birthDate: null,
            email: null,
            phone: null,
            experiences: []
          };
          this.allErrorMessages = [];

          if (Array.isArray(res.errors)) {
            res.errors.forEach(err => {
              debugger;
              // regex dla workExperiences
              const match = err.property.match(/^workExperiences\[(\d+)\](?:\.(\w+))?$/);
              if (match) {
                const index = parseInt(match[1]);
                const field = match[2] || 'global'; // jeśli nie ma pola, używamy "global"
                if (!this.errors.experiences[index]) {
                  this.errors.experiences[index] = {};
                }

                if(field === 'global'){
                  this.errors.experiences[0][field] = err.message;
                  this.allErrorMessages.push("Doświadczenie zawodowe: "+err.message);
                  return;
                }

                this.errors.experiences[index][field] = err.message;
                this.allErrorMessages.push("Doświadczenie zawodowe: "+err.message);
                return;
              }

              // regex dla contact
              const contactMatch = err.property.match(/^contact\.(\w+)$/);
              if (contactMatch) {
                const field = contactMatch[1]; // "phone" lub "email"

                this.errors[field] = err.message;
                this.allErrorMessages.push("Dane kontaktowe: "+err.message);
                return;
              }

              // inne pola globalne, np. birthDate
              this.errors[err.property] = err.message;
              this.allErrorMessages.push("Dane podstawowe: "+err.message);
            });

          }
        }
      } catch (err) {
        console.error('Błąd wysyłki formularza', err);
        alert('Wystąpił błąd przy wysyłce formularza.');
      }
    }
  }
};
</script>

<style scoped>
.card-body {
  min-height: 400px;
  min-width: 600px;
}
</style>
