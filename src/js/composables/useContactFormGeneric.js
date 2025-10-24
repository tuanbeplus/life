import useContactFormBase from '#/useContactFormBase.js'


const {
  contactFieldModels,
  ContactFormBase,
} = useContactFormBase()


class ContactFormGeneric extends ContactFormBase {
  constructor() {
    super()
  }
  post(contactFields, formId) {
    const formData = new FormData()
    const extraFields = [
      {
        name: 'action',
        val: 'life_ajax_submit_form',
      },
      {
        name: 'form_id',
        val: formId,
      },
      {
        name: 'language',
        val: 'english',
      },
    ]
    extraFields.forEach(({ name, val }) => {
      formData.append(name, val)
    })
    for (const fName in contactFields) {
      const val = contactFields[fName].val
      if (fName === 'consent') {
        formData.append(fName, val ? 'yes' : 'no')
      } else {
        if (typeof val === 'object') {
          for (const nestedFName in val) {
            formData.append(`${fName}[${nestedFName}]`, val[nestedFName])
          }
        } else {
          formData.append(fName, val)
        }
      }
    }
    formData.append('recaptcha', 'TOKEN_FOOBAR')
    this._post(formData)
  }
}




export default () => {
  return {
    ContactFormGeneric,
    contactFieldModels,
  }
}