import useContactForm from '#/useContactForm.js'
import useModal from '#/useModal.js'

const { Modal } = useModal()
const modal = new Modal()


const fieldsData = {
  first_name: {
    label: 'First name',
  },
  last_name: {
    label: 'Last name',
  },
  phone: {
    label: 'Phone',
    validation: {
      title: 'Enter 10 digit phone number without spaces',
      type_message: 'Please enter a 10 digit phone number. Numbers only.',
      type: 'number',
      maxlength: '10',
      minlength: '10',
    },
  },
  email: {
    label: 'Email',
    type: 'email',
  },
  living_with_pcos: {
    label: 'Are you currently living with Polycystic Ovary Syndrome?',
    type: 'buttons',
    options: {
      Yes: 'Yes',
      No: 'No',
    },
  },
  heard_about_via: {
    label: 'How did you first hear about us?',
    type: 'select',
    options: {
      '': 'Please select...',
      'Monash PCOS Clinic': 'Monash PCOS Clinic',
      'GP': 'GP',
      'Other': 'Other',
    },
  },
  consent: {
    label: 'I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to contact me regarding the <em>Life!</em> program and for any personal information collected to be used for necessary <em>Life!</em> program administrative operations.',
    validation: {
      message_required: 'Please consent',
    },
  },
  consent_pcos: {
    label: 'I give my consent for Diabetes Victoria staff from the <em>Life!</em> program to provide information such as enrolment status back to referring agency e.g. Monash PCOS Clinic.',
    validation: {
      message_required: 'Please consent',
    },
  },
}

const { ContactForm } = useContactForm()

class ContactFormPcos extends ContactForm {
  constructor() {
    super(fieldsData)
    this._formId = 'pcos'
  }
}


export default () => ({
  ContactFormPcos,
  modal,
})

