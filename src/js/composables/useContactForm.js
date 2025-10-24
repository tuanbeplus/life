import axios from 'axios'
import autofillVals from '../lib/autofill.js'
import { validationMessageGenericRequired, validationEmail, validationPhone, validationPostcode } from '../lib/validationMessages.js'
// eslint-disable-next-line no-undef
const APP_ENV = __APP_ENV__
// eslint-disable-next-line no-undef
const CONTACT_AUTO_FILL = VITE_CONTACT_AUTO_FILL




class Field {
  constructor(fname, props, form) {
    this.el = null
    this.fname = fname
    this.form = form
    this.val = ''
    this.label = props.label
    this.placeholder = props.placeholder || props.label
    this.required = 'required' in props ? props.required : true
    this.requiredFunc = 'requiredFunc' in props ? props.requiredFunc : false
    this.type = props.type || 'text'
    this.options = props.options
    this.validation = false
    this.vComponentProps = props.vComponentProps || {}
    this.errs = []
    
    if ('validation_macro' in props) {
      if (props.validation_macro === 'phone') {
        this.validation = {
          type: 'number',
          maxlength: 10,
          minlength: 10,
          ...validationPhone(form.lang),
        }
      } else if (props.validation_macro === 'postcode') {
        this.validation = {
          type: 'number',
          maxlength: 4,
          minlength: 4,
          ...validationPostcode(form.lang),
        }
      }
    }
    if (this.type === 'email') {
      this.validation = {
        type_message: validationEmail(form.lang),
      }
    }
    if ('validation' in props) {
      if (this.validation === false) {
        this.validation = props.validation
      } else {
        this.validation = Object.assign(this.validation, props.validation)
      }
    }
    // if (this.form.constructor.name === 'ContactFormProviderSignupEoi') {
    //   console.log(fname, this.validation)
    // }
  }
  isRequired() {
    if (this.requiredFunc) {
      return this.requiredFunc(this)
    } else {
      return this.required
    }
  }
  validate() {
    if (this.fname === 'consent') {
      console.log('consent field')
      console.log('this.validation', this.validation)
    }
    const errs = []
    if (this.isRequired() && !this.val) {
      errs.push(this.validation?.message_required ? this.validation.message_required : this.form.validationMessageGenericRequired)
    } else if (typeof this.validation === 'object') {
      if (this.val) {
        if (this.validation.type) {
          if (this.validation.type === 'number' && isNaN(this.val)) {
            errs.push(this.validation.type_message)
          }
        }
        if (this.validation.maxlength && this.val.length > this.validation.maxlength) {
          errs.push('message_maxlength_over' in this.validation ? this.validation.message_maxlength_over : this.validation.type_message)
        } else if (this.validation.minlength && this.val.length < this.validation.minlength) {
          errs.push('message_minlength_under' in this.validation ? this.validation.message_minlength_under : this.validation.type_message)
        }
      }
    }
    if (this.val && this.type === 'email' && !(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.val))) {
      errs.push(this.validation.type_message)
    }
    // console.log('errs', this.fname, errs)
    this.errs = errs
    return errs
  }
}

const contactFieldModels = (fields, form) => {
  const valObj = {}
  for (const fName in fields) {
    valObj[fName] = new Field(fName, fields[fName], form)
  }
  if (CONTACT_AUTO_FILL) {
    const fillVals = autofillVals
    for (const fName in fillVals) {
      if (fName in fields) {
        valObj[fName].val = fillVals[fName]
      }
    }
    if ('state' in fields && fields.state.type !== 'select') {
      valObj.state.val = 'VIC'
    } else {
      ['state', 'event_type'].forEach((fName) => {
        if (fName in fields) {
          for (let optVal in valObj[fName].options) {
            valObj[fName].val = optVal
            break
          }
        }
      })
    }
  }
  return valObj
}


class ContactForm {
  constructor(fieldsData, lang = 'en') {
    this.postSuccessful = false
    this.posting = false
    this.posted = false
    this.responseMessage = ''
    this.lang = lang
    this.fields = contactFieldModels(fieldsData, this)
    this.validationMessageGenericRequired = validationMessageGenericRequired(lang)
  }
  _setAsPosting() {
    this.posting = true
  }
  _setAsSuccessful() {
    this.posting = false
    this.postSuccessful = true
    this.posted = true
  }
  _setAsFailed() {
    this.posting = false
    this.posted = true
  }
  validateAndPost() {
    let firstFieldWithErr = null
    for (const fName in this.fields) {
      const field = this.fields[fName]
      const errsOnField = field.validate()
      if (firstFieldWithErr === null && errsOnField.length > 0) {
        firstFieldWithErr = field
      }
    }
    if (firstFieldWithErr === null) {
      this.post()
    } else {
      if (firstFieldWithErr.el) {
        firstFieldWithErr.el.scrollIntoView({ behavior: 'smooth', block: 'center' })
      } else {
        console.error('error on field: `' + firstFieldWithErr.fname + '` but no dom element found')
        console.log(firstErr)
      }
    }
  }
  post() {
    const formData = new FormData()
    const extraFields = [
      {
        name: 'action',
        val: 'life_ajax_submit_form',
      },
      {
        name: 'form_id',
        val: this._formId,
      },
      {
        name: 'language',
        val: this.lang,
      },
    ]
    extraFields.forEach(({ name, val }) => {
      formData.append(name, val)
    })
    for (const fName in this.fields) {
      const val = this.fields[fName].val
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
    if ('appendToFormData' in this) {
      const errs = this.appendToFormData(formData)
      if (errs.length > 0) {
        this._setAsFailed()
        this.responseMessage = errs.join('\n')
        if (APP_ENV === 'dev') {
          console.log(this.fields)
          formData.entries().forEach(([name, val]) => {
            console.log(name, val)
          })
        }
        return
      }
    }
    if (APP_ENV === 'dev') {
      formData.entries().forEach(([name, val]) => {
        console.log(name, val)
      })
    }
    this._post(formData)
  }
  _post(formData) {
    this._setAsPosting()
    const IS_PRODUCTION = APP_ENV === 'production' || true // change the boolean for testing
    const SEND_TO_SERVER = IS_PRODUCTION ? true : false
    const PRETEND_SUCCESS = IS_PRODUCTION ? false : true
    const ALLOW_RECURRENT_SUBMISSION = IS_PRODUCTION ? false : false
    if (SEND_TO_SERVER) {
      axios({
        method: 'post',
        url: '/',
        data: formData,
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Accept': 'application/json, text/javascript, */*; q=0.01',
        },
      })
        .then((response) => {
          if (PRETEND_SUCCESS) {
            this._setAsSuccessful()
            this.responseMessage = 'PRETEND_SUCCESS.data.message'
          } else if (ALLOW_RECURRENT_SUBMISSION) {
            this.responseMessage = 'GO AGAIN'
            this.posting = false
          } else {
            if (response.status === 200 && response.data.status === 'ok') {
              this._setAsSuccessful()
              this.responseMessage = response.data.messages.join(', ')
            } else if ('data' in response && typeof response.data === 'object' && 'validation' in response.data) {
              this._setAsFailed()
              const message = []
              for (const fieldName in response.data.validation) {
                message.push(`${fieldName}: ${response.data.validation[fieldName]}`)
              }
              this.responseMessage = message.join(', ')
            } else {
              console.log(response)
              console.log(response.data)
              this._setAsFailed()
              this.responseMessage = 'Sorry. Something went wrong. Please try again later.'
            }
          }
        })
        .catch((error) => {
          console.log(error)
          const validationErrs = error.response?.data?.validation
          if (validationErrs && Array.isArray(validationErrs)) {
            console.log('validationErrs', validationErrs)
            this.responseMessage = validationErrs.map((err) => err.message).join(', ')
          }
          console.log(error.response?.data?.validation)
          this.posting = false
        })
    } else {
      setTimeout(() => {
        if (PRETEND_SUCCESS) {
          this._setAsSuccessful()
          this.responseMessage = 'Thank you for your enquiry. One of our friendly staff will be in contact with you within the next 24-48 hours.'
        } else {
          this.responseMessage = 'GO AGAIN'
          this.posting = false
        }
      }, 1200)
    }
  }
}






export default () => ({
  ContactForm,
})