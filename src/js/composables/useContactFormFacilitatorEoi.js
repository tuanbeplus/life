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
    validation: {
      type_message: 'Please enter a valid postcode.',
      type: 'number',
      maxlength: 4,
      minlength: 4,
    },
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
  work_experience: {
    label: 'General work experience',
    type: 'textarea',
  },
  facilitation_experience: {
    label: 'Group facilitation work experience',
    type: 'textarea',
  },
  cultural_experience: {
    label: 'Experience working with people from culturally and linguistically diverse backgrounds',
    type: 'textarea',
  },
  langauges_other_than_en: {
    label: 'Do you speak a language other than English?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  languages: {
    label: 'Which languages?',
    required: false,
  },
  deliver_cald_q: {
    label: 'Are you interested in delivering the CALD <em>Life!</em> program?',
    type: 'select',
    required: false,
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  deliver_cald: {
    label: 'In which language?',
    type: 'select',
    required: false,
    options: {
      '': 'Please select...',
      'Chinese - Mandarin': 'Chinese - Mandarin',
      'Chinese - Cantonese': 'Chinese - Cantonese',
      Vietnamese: 'Vietnamese',
      Arabic: 'Arabic',
    },
  },
  computer_access: {
    label: 'Do you have regular access to a computer?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  internet_access: {
    label: 'Do you have broadband internet connection?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  org_name: {
    label: 'Name of organisation',
  },
  existing_provider: {
    label: 'Is the organisation an existing <em>Life!</em> provider?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  comments: {
    label: 'Comments',
    type: 'textarea',
    required: false,
  },
}

const { ContactForm } = useContactForm()

class ContactFormFacilitatorEoi extends ContactForm {
  constructor() {
    super(fieldsData)
    this._formId = 'facilitatorEoi'
  }
  appendToFormData(formData) {
    // console.log('postal_as_above', this.fields.postal_as_above.val)
    if (this.fields.postal_as_above.val === 'Yes') {
      const { address, suburb, state, postcode } = this.fields
      formData.append('postal_address', address.val + ', ' + suburb.val + ', ' + state.val + ' ' + postcode.val)
    }
    return []
  }
}


export default () => ({
  ContactFormFacilitatorEoi,
})