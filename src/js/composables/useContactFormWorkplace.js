import useContactForm from '#/useContactForm.js'

const fieldsData = {
  Company: {
    label: 'Name of your workplace',
    validation: {
      type_message: 'Please use 255 characters or less.',
      maxlength: 255,
    },
  },
  Street: {
    label: 'Street number / name',
    validation: {
      type_message: 'Please use 255 characters or less.',
      maxlength: 255,
    },
  },
  City: {
    label: 'Suburb',
    validation: {
      type_message: 'Please use 40 characters or less.',
      maxlength: 40,
    },
  },
  PostalCode: {
    label: 'Postcode',
    validation_macro: 'postcode',
  },

  Number_of_sites__c: {
    label: 'Number of sites',
    validation: {
      type_message: 'Please enter a number less than 1000.',
      type: 'number',
      maxlength: 3,
    },
  },
  Number_of_employees_across_all_sites__c: {
    label: 'Number of employees (across all sites)',
    validation: {
      type_message: 'Please enter a number less than 10000.',
      type: 'number',
      maxlength: 4,
    },
  },

  FirstName: {
    label: 'Contact person – first name',
    validation: {
      type_message: 'Please use 40 characters or less.',
      maxlength: 40,
    },
  },
  LastName: {
    label: 'Contact person – last name',
    validation: {
      type_message: 'Please use 80 characters or less.',
      maxlength: 80,
    },
  },
  How_did_you_hear_about_the_Life_program__c: {
    label: 'How did you hear about the <em>Life!</em> program?',
    validation: {
      type_message: 'Please use 255 characters or less.',
      maxlength: 255,
    },
  },
  Position__c: {
    label: 'Role of contact person in organisation',
  },

  Phone: {
    label: 'Phone number',
    validation_macro: 'phone',
  },
  Email: {
    label: 'Email',
    type: 'email',
  },
  Healthy_Living_Session_delivery_method__c: {
    label: 'Healthy Living Session preferred delivery method',
    type: 'select',
    placeholder: 'Delivery method',
    options: {
      'Face to face': 'Face-to-face',
      'Webinar': 'Webinar',
      'Either': 'Either',
    },
  },
  NO_POST_session_at_org_address: {
    label: 'Will the session be delivered at your organisation address?',
    type: 'select',
    required: false,
    placeholder: 'Location',
    options: {
      'Yes': 'Yes',
      'No': 'No',
    },
  },
  StreetAddress__c: {
    label: 'Street number / name',
    required: false,
    validation: {
      type_message: 'Please use 255 characters or less.',
      maxlength: 255,
    },
  },
  Suburb__c: {
    label: 'Suburb',
    required: false,
    validation: {
      type_message: 'Please use 40 characters or less.',
      maxlength: 40,
    },
  },
  Postcode__c: {
    label: 'Postcode',
    required: false,
    validation: {
      type_message: 'Please enter a valid postcode.',
      type: 'number',
      maxlength: 4,
      minlength: 4,
    },
  },
  Do_you_have_a_projector_screen__c: {
    label: 'Do you have a projector / screen to support a power-point presentation?',
    type: 'select',
    required: false,
    placeholder: 'Please select...',
    options: {
      'Yes': 'Yes',
      'No': 'No',
    },
  },
  First_preferred_session_date_time_HLS__c: {
    label: 'First preferred session date and time',
    type: 'datetimepicker',
    vComponentProps: {
      minTime: { hours: 9, minutes: 0 },
      maxTime: { hours: 21, minutes: 0 },
      startTime: { hours: 9, minutes: 0 },
    },
  },
  Second_preferred_session_date_time_HLS__c: {
    label: 'Second preferred session date and time',
    type: 'datetimepicker',
    vComponentProps: {
      minTime: { hours: 9, minutes: 0 },
      maxTime: { hours: 21, minutes: 0 },
      startTime: { hours: 9, minutes: 0 },
    },
  },
}

const { ContactForm } = useContactForm()

class ContactFormWorkplace extends ContactForm {
  constructor() {
    super(fieldsData)
    this._formId = 'workplaceRequest'
  }
}


export default () => ({
  ContactFormWorkplace,
})