import useContactForm from '#/useContactForm.js'

const fieldsData = {
  xxxx: {
    label: 'Xxxx',
  },
}

const { ContactForm } = useContactForm()

class ContactFormXxxxx extends ContactForm {
  constructor() {
    super(fieldsData)
    this._formId = 'xxxx'
  }
  // appendToFormData(formData) {
  //   return [] /* errors String[] */
  // }
}


export default () => ({
  ContactFormXxxxx,
})