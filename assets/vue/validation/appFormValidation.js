import { reactive, computed } from 'vue'
import { useVuelidate } from '@vuelidate/core'
import { required, email, helpers, maxLength } from '@vuelidate/validators'

export function useFormValidation(form) {
    debugger;
    const rules = reactive({
        firstName: { required: helpers.withMessage('Imię jest wymagane', required) },
        lastName: {
            required: helpers.withMessage('Nazwisko jest wymagane', required),
            maxLength: helpers.withMessage('Nazwisko może mieć maksymalnie 255 znaków', maxLength(255))
        },
        birthDate: {
            required: helpers.withMessage('Data urodzenia jest wymagana', required),
            isPast: helpers.withMessage(
                'Data urodzenia musi być w przeszłości',
                value => !value || new Date(value) < new Date()
            )
        },
        phone: {
            required: helpers.withMessage('Telefon jest wymagany', required),
            pattern: helpers.withMessage(
                'Telefon musi być w formacie +48123456789',
                value => !value || /^\+?[0-9]{9,15}$/.test(value)
            )
        },
        email: {
            required: helpers.withMessage('Email jest wymagany', required),
            email: helpers.withMessage('Email ma niepoprawny format', email)
        },
        experiences: {
            // walidacja tablicy dynamicznej
            $each:  helpers.forEach({
                company: { required: helpers.withMessage('Firma jest wymagana', required) },
                position: { required: helpers.withMessage('Stanowisko jest wymagane', required) },
                dateFrom: {
                    required: helpers.withMessage('Data od jest wymagana', required),
                    validRange: helpers.withMessage(
                        'Data od nie może być późniejsza niż Data do',
                        (value, sibling) => !value || !sibling.dateTo || new Date(value) <= new Date(sibling.dateTo)
                    )
                },
                dateTo: {
                    required: helpers.withMessage('Data do jest wymagana', required),
                    validRange: helpers.withMessage(
                        'Data do nie może być wcześniejsza niż Data od',
                        (value, sibling) => !value || !sibling.dateFrom || new Date(value) >= new Date(sibling.dateFrom)
                    )
                }
            })
        }
    })

    const v$ = useVuelidate(rules, form, { $autoDirty: true })

    return { v$, isValid: computed(() => !v$.value.$invalid) }
}
