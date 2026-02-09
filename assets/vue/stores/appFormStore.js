// formStore.js
import { reactive, ref } from 'vue'
import { sendForm } from '../services/api'
import {useFormValidation} from "../validation/appFormValidation";

const form = reactive({
    firstName: '',
    lastName: '',
    birthDate: null,
    email: '',
    phone: '',
    experiences: []
})

const allErrorMessages = ref([])
const submitted = ref(false)
const result = ref(null)

function resetErrors() {
    allErrorMessages.value = []
}

async function submit() {

    resetErrors()
    const v$ = useFormValidation(form)
    if(!v$.isValid.value) {
        allErrorMessages.value.push("Formularz jest niepoprawny. Popraw błędy przed wysłaniem.");
        return false;
    }

    const payload = {
        firstName: form.firstName,
        lastName: form.lastName,
        birthDate: form.birthDate,
        contact: {
            email: form.email,
            phone: form.phone
        },
        workExperiences: form.experiences
    }

    const res = await sendForm(payload)

    if (res.success) {
        result.value = res.data
        submitted.value = true
        return true
    }

    // mapowanie błędów z backendu
    res.errors.forEach(err => {
        if (err.property.startsWith("workExperiences")) {
            allErrorMessages.value.push("Doświadczenie zawodowe: "+err.message);
            return;
        }

        if (err.property.startsWith("contact")) {
            allErrorMessages.value.push("Dane kontaktowe: "+err.message);
            return;
        }
        // inne pola globalne, np. birthDate
        allErrorMessages.value.push("Dane podstawowe: "+err.message);
    })

    return false
}

// Singleton
export function useFormStore() {
    return {
        form,
        allErrorMessages,
        submitted,
        result,
        submit
    }
}
