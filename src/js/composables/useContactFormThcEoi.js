import useContactForm from '#/useContactForm.js'

const fieldsData = {
  first_name: {
    label: 'First name',
  },
  last_name: {
    label: 'Last name',
  },
  gender: {
    label: 'What gender do you identify as?',
    type: 'select',
    options: {
      '': 'Please select...',
      Female: 'Female',
      Male: 'Male',
      Indeterminate: 'Indeterminate',
      Intersex: 'Intersex',
      Other: 'Other',
    },
  },
  address: {
    label: 'Street address',
  },
  suburb: {
    label: 'Suburb',
  },
  state: {
    label: 'State',
  },
  postcode: {
    label: 'Postcode',
  },
  postal_as_above: {
    label: 'Postal address same as above?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  postal_address: {
    label: 'Postal Address',
    type: 'textarea',
    required: false,
  },
  email: {
    label: 'Email address',
    type: 'email',
  },
  mobile: {
    label: 'Mobile',
    validation_macro: 'phone',
    validation: {
      message_maxlength_over: 'This phone number is too long. It should have 10 characters.',
      message_minlength_under: 'This phone number is too short. It should have 10 characters.',
    },
  },
  phone: {
    label: 'Business hours phone',
    validation_macro: 'phone',
    validation: {
      minlength: 8,
      message_minlength_under: 'This value is too short. It should have 8 characters.',
    },
  },
  contact_method: {
    label: 'Preferred method of contact',
    type: 'select',
    options: {
      '': 'Please select...',
      Email: 'Email',
      Phone: 'Phone call',
    },
  },
  qualification: {
    label: 'Qualification',
    type: 'select',
    options: {
      '': 'Please select...',
      'Bachelor of Applied Science - Human Movement': 'Bachelor of Applied Science - Human Movement',
      'Bachelor of Nutrition and Dietetics': 'Bachelor of Nutrition and Dietetics',
      'Bachelor of Science - Nursing': 'Bachelor of Science - Nursing',
      'Bachelor of Science - Physiotherapy': 'Bachelor of Science - Physiotherapy',
      'Bachelor of Sports Science': 'Bachelor of Sports Science',
      'Master of Nutrition and Dietetics': 'Master of Nutrition and Dietetics',
      'Master of Public Health': 'Master of Public Health',
      'Master of Science - Nursing': 'Master of Science - Nursing',
      'Master of Science - Physiotherapy': 'Master of Science - Physiotherapy',
      'Masters of Exercise Physiology': 'Masters of Exercise Physiology',
      Other: 'Other',
    },
  },
  other_qualification: {
    label: 'Other qualification',
    required: false,
  },
  professional_accreditation: {
    label: 'Professional Accreditation',
    type: 'select',
    options: {
      '': 'Please select...',
      ESSA: 'ESSA',
      APHRA: 'APHRA',
      DAA: 'DAA',
    },
  },
  hca_model_training: {
    label: 'Certification of the Health Change Australia model trainings:',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  motivational_interviewing: {
    label: 'Certification of Motivational Interviewing:',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  pl_insurance: {
    label: 'Do you have Professional Indemnity Insurance coverage for at least $1,000,000 for any one claim and will this continue to be maintained for at least two years after the End Date* stated in the PSA?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  pl_insurer: {
    label: 'What is the name of the company you have Public Liability Insurance with?',
    required: false,
    validation: {
      maxlength: 25,
      message_maxlength_over: 'Please use 25 characters or less.',
    },
  },
  pi_insurance: {
    label: 'Do you have Professional Indemnity Insurance coverage for at least $1,000,000 for any one claim and will this continue to be maintained for at least two years after the End Date* stated in the PSA?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  pi_insurer: {
    label: 'What is the name of the company you have Professional Indemnity Insurance with?',
    required: false,
    validation: {
      maxlength: 25,
      message_maxlength_over: 'Please use 25 characters or less.',
    },
  },
}

const { ContactForm } = useContactForm()

class ContactFormThcEoi extends ContactForm {
  constructor() {
    super(fieldsData)
    this._formId = 'thcEoi'
  }
  appendToFormData(formData) {
    // console.log('postal_as_above', this.fields.postal_as_above.val)
    if (this.fields.postal_as_above.val === 'Yes') {
      const { address, suburb, state, postcode } = this.fields
      formData.append('postal_address', address.val + ', ' + suburb.val + ', ' + state.val + ' ' + postcode.val)
    }
    return [] /* errors String[] */
  }
}


export default () => ({
  ContactFormThcEoi,
})