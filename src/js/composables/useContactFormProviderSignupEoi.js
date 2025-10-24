import useContactForm from '#/useContactForm.js'

const fieldsData = {
  org_name: {
    label: 'Organisation Name',
  },
  building: {
    label: 'Building Name',
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
    validation_macro: 'postcode',
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
  abn: {
    label: 'ABN',
  },
  describe_org: {
    label: 'How would you best describe your provider organisation?',
  },
  first_name: {
    label: 'First name',
  },
  last_name: {
    label: 'Last name',
  },
  phone: {
    label: 'Phone',
    validation_macro: 'phone',
    validation: {
      minlength: 8,
      message_minlength_under: 'This value is too short. It should have 8 characters.',
    },
  },
  mobile: {
    label: 'Mobile',
    validation_macro: 'phone',
    required: false,
  },
  email: {
    label: 'Email',
    type: 'email',
  },
  position: {
    label: 'Position',
    required: false,
  },
  fax: {
    label: 'Fax',
    required: false,
  },
  manager_as_above: {
    label: 'Manager contact details same as above?',
    type: 'select',
    required: false,
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  manager_first_name: {
    label: 'First name',
    required: false,
  },
  manager_last_name: {
    label: 'Last Name',
    required: false,
  },
  manager_phone: {
    label: 'Phone',
    validation_macro: 'phone',
    required: false,
    validation: {
      minlength: 8,
      message_minlength_under: 'This value is too short. It should have 8 characters.',
    },
  },
  manager_mobile: {
    label: 'Mobile',
    validation_macro: 'phone',
    required: false,
  },
  manager_email: {
    label: 'Email',
    required: false,
    type: 'email',
  },
  appropriate_space: {
    label: 'Is there an appropriate space at your organisation or do you have access to an appropriate venue within the community for you to deliver the <em>Life!</em> Program course (i.e. private space for 8-15 people, chairs, computer/laptop and projector/screen)?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  referral_pathways: {
    label: 'What referral pathways or networking opportunities are available to you in order to receive eligible participants for your <em>Life!</em> Program courses?',
    type: 'textarea',
  },
  delivery_areas: {
    label: 'Which area/s would your organisation be interested in delivering the <em>Life!</em> Program course?',
    type: 'textarea',
  },
  data_entry: {
    label: 'Will each facilitator be responsible for entry of participant data assigned to them; or will there be staff (i.e. administration/reception) responsible for this?',
    type: 'textarea',
  },
  community_events: {
    label: 'Is there an appropriate space at your organisation or do you have access to an appropriate venue within the community for you to deliver the <em>Life!</em> Program course (i.e. private space for 8-15 people, chairs, computer/laptop and projector/screen)?',
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
  },
  gst_registration: {
    label: 'Is this organisation registered for GST?',
    type: 'select',
    options: {
      '': 'Please select...',
      Yes: 'Yes',
      No: 'No',
    },
  },
  facilitator_names: {
    label: 'Facilitator’s name (<em>Life!</em> trained facilitator’s or health professional’s to attend <em>Life!</em> facilitator training)',
  },
}

const { ContactForm } = useContactForm()

class ContactFormProviderSignupEoi extends ContactForm {
  constructor() {
    super(fieldsData)
    this._formId = 'providerSignup'
  }
  appendToFormData(formData) {
    // console.log('postal_as_above', this.fields.postal_as_above.val)
    if (this.fields.postal_as_above.val === 'Yes') {
      const { address, suburb, state, postcode } = this.fields
      formData.append('postal_address', address.val + ', ' + suburb.val + ', ' + state.val + ' ' + postcode.val)
    }
    // console.log('this.fields.manager_as_above.val', this.fields.manager_as_above.val)
    if (this.fields.manager_as_above.val === 'Yes') {
      const personalDetailsFields = ['first_name', 'last_name', 'phone', 'mobile', 'email']
      personalDetailsFields.forEach((fName) => {
        const managerFName = 'manager_' + fName
        if (managerFName in this.fields) {
          // console.log('managerFName', managerFName, this.fields[fName].val)
          this.fields[managerFName].val = this.fields[fName].val
          formData.append(managerFName, this.fields[managerFName].val)
        } else {
          console.error(`'${managerFName}' not found`, this.fields)
        }
      })
    }
    return [] /* errors String[] */
  }
}


export default () => ({
  ContactFormProviderSignupEoi,
})