import axios from 'axios'
// eslint-disable-next-line no-undef
const APP_ENV = __APP_ENV__
// eslint-disable-next-line no-undef
const CONTACT_AUTO_FILL = VITE_CONTACT_AUTO_FILL




class ContactFormBase {
  constructor() {
    this.postSuccessful = false
    this.posting = false
    this.posted = false
    this.responseMessage = ''
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
  _post(formData) {
    this._setAsPosting()
    const IS_PRODUCTION = APP_ENV === 'production' || true
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
            } else if ('data' in response && 'validation' in response.data) {
              this._setAsFailed()
              const message = []
              for (const fieldName in response.data.validation) {
                message.push(`${fieldName}: ${response.data.validation[fieldName]}`)
              }
              this.responseMessage = message.join(', ')
            } else {
              this._setAsFailed()
              this.responseMessage = 'Sorry. Something went wrong. Please try again later.'
            }
          }
        })
        .catch((error) => {
          console.log(error)
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



const contactFieldModels = (fields) => {
  const valObj = {}
  for (const fName in fields) {
    valObj[fName] = {
      val: '',
    }
  }
  if (CONTACT_AUTO_FILL) {
    const t = (new Date()).toLocaleString('en-AU')
    const fillVals = {
      full_name: 'Lee test '+t,
      address: '123 Fake Street',
      suburb: 'Melbourne',
      org_name: 'Bright Labs',
      comments: 'This is a test',
      first_name: 'Bright Labs',
      last_name: 'Lee test '+t,
      email: 'lee+test_'+t.replace(/[^a-z0-9]/g, '')+'@brightlabs.com',
      phone: '0415419771',
      postcode: '2042',
      living_with_pcos: 'Yes',
      heard_about_via: 'Other',
      consent: true,
    }
    for (const fName in fillVals) {
      if (fName in fields) {
        valObj[fName].val = fillVals[fName]
      }
    }
  }
  return valObj
}




export default () => ({
  ContactFormBase,
  contactFieldModels,
})