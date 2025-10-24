import useGtmDataLayer from '#/useGtmDataLayer.js'
const { gtmEvent } = useGtmDataLayer()

class ShowingHealthCheckPage {
  constructor() {
    this._page = 0
    this._isOpaque = true
  }
  show(num) {
    if (this._page === num) {
      return
    }
    this._page = num
    this._isOpaque = false
    setTimeout(() => {
      this._isOpaque = true
    }, 100)
  }
  isShowing(num, ifOpaque) {
    if (this._page !== num) {
      return false
    }
    return ifOpaque ? this._isOpaque : true
  }
  isShowingTest(ifOpaque) {
    return this.isShowing(0, ifOpaque)
  }
  isShowingResults(ifOpaque) {
    return this.isShowing(1, ifOpaque)
  }
  showResults() {
    this.show(1)
  }
  isShowingContactForm(ifOpaque) {
    return this.isShowing(2, ifOpaque)
  }
  showContactForm(langSlug) {
    // console.log('showContactForm', langSlug)
    // NB. English 'en' is currentlyhandled by 'Contactbutton_English' event (.button.primary.en)
    if (['ar', 'zh_hans', 'zh_hant', 'vi'].includes(langSlug)) {
      gtmEvent(`DL_contact_${langSlug}`)
    }
    this.show(2)
  }
  isfinishedQuestions() {
    return this._page > 0 && this._isOpaque
  }
}


export default () => new ShowingHealthCheckPage()