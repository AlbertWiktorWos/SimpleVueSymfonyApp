// formStore.js
import { reactive, ref } from 'vue'
import { sendForm } from '../services/api'

const form = reactive({
    firstName: '',
    lastName: '',
    birthDate: '',
    email: '',
    phone: '',
    experiences: []
})

const errors = reactive({})
const allErrorMessages = ref([])
const submitted = ref(false)
const result = ref(null)

function resetErrors() {
    Object.keys(errors).forEach(k => delete errors[k])
    allErrorMessages.value = []
}

async function submit() {
    resetErrors()
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
        allErrorMessages.value.push(err.message)
        debugger;
        const match = err.property.match(/^workExperiences\[(\d+)\]\.(\w+)$/)
        if (match) {
            const [_, index, field] = match
            errors.experiences ??= []
            errors.experiences[index] ??= {}
            errors.experiences[index][field] = err.message
            return
        }

        const contact = err.property.match(/^contact\.(\w+)$/)
        if (contact) {
            errors[contact[1]] = err.message
            return
        }

        errors[err.property] = err.message
    })

    return false
}

// Singleton: zawsze ten sam obiekt
export function useFormStore() {
    return {
        form,
        errors,
        allErrorMessages,
        submitted,
        result,
        submit
    }
}
