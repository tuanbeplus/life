import useHealthCheck from '#/useHealthCheck.js'
import useContactForm from '#/useContactForm.js'


const {
  ContactForm,
} = useContactForm()



class ContactFormHealthCheck extends ContactForm {
  constructor(formData, lang) {
    super(formData.fields, lang)
    this._formId = 'ausdrisk'
  }
  appendToFormData(formData) {
    const {
      currentOpenHealthCheck,
      score,
      waistForPost,
    } = useHealthCheck()
    
    let evidenceForCvdGdmFh = 'No'
    Object.keys(currentOpenHealthCheck.value.translation().steps.step3.questions.diagnosis.options).forEach((fieldName) => {
      if (fieldName) {
        const field = currentOpenHealthCheck.value.translation().steps.step3.questions.diagnosis.options[fieldName]
        formData.append(fieldName, field.isSelected ? 'Yes' : 'No')
      }
      // NB. evidenceForCvdGdmFh is a hack to make salesforce accept the submission
      // at some point, Diabetes-Victoria asked us to remove 'I_can_provide_evidence_for_CVD_GDM_FH__c'
      // but did not remove that from Salesforce. Khurram advised to just fudge it
      if (['History_of_CVD__c', 'Had_GDM__c', 'Serum_total_cholesterol_7_5mmol_L__c'].includes(fieldName)) {
        const field = currentOpenHealthCheck.value.translation().steps.step3.questions.diagnosis.options[fieldName]
        if (field.isSelected) {
          evidenceForCvdGdmFh = 'Yes'
        }
      }
    })
    // console.log('evidenceForCvdGdmFh', evidenceForCvdGdmFh)
    formData.append('I_can_provide_evidence_for_CVD_GDM_FH__c', evidenceForCvdGdmFh)
    // console.log('steps', currentOpenHealthCheck.value.translation().steps.step3.questions.diagnosis)

    formData.append('risk_score', score.value)
    for (const fieldName in currentOpenHealthCheck.value.translation().steps.step1.questions) {
      const field = currentOpenHealthCheck.value.translation().steps.step1.questions[fieldName]
      formData.append(fieldName, field.selected)
    }
    formData.append('waist_atsi', waistForPost(true))
    formData.append('waist_other', waistForPost())
    formData.append('Waist_Circumference_meets_criteria__c', 'Yes') /* todo - check how this gets set */
    formData.append('health_professional', '') /* todo - check if this ever not empty */
    formData.append('workplace', '') /* todo - check if this ever not empty */
    formData.append('eligible_for_flex', 'No')
    return []
  }
}




export default () => {
  return {
    ContactFormHealthCheck,
  }
}