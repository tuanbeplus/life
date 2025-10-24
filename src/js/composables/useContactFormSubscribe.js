import useContactForm from '#/useContactForm.js'

const fieldsData = {
  first_name: {
    label: 'First name',
    placeholder: 'First name',
  },
  email: {
    label: 'Email',
    placeholder: 'Email address',
  },
}

const { ContactForm } = useContactForm()

class ContactFormSubscribe extends ContactForm {
  constructor() {
    super(fieldsData)
    this._formId = 'newsletter_subscribe'
  }
}


export default () => ({
  ContactFormSubscribe,
})