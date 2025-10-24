import { ref, reactive, computed } from 'vue'
import useModal from '#/useModal.js'
import axios from 'axios'
import mitt from 'mitt'
import useHealthCheckCalc from '#/useHealthCheckCalc.js'
import useShowingHealthCheckPage from '#/useShowingHealthCheckPage.js'
import useContactFormHealthCheck from '#/useContactFormHealthCheck.js'
import useGtmDataLayer from '#/useGtmDataLayer.js'

// eslint-disable-next-line no-undef
const APP_ENV = __APP_ENV__
// eslint-disable-next-line no-undef
const TEST_TEST_SCORE = VITE_TEST_TEST_SCORE

const { Modal } = useModal()
const emitter = mitt()
const contentHeightEl = ref(null)
const confirmClicked = ref(false)

const showingPage = reactive(useShowingHealthCheckPage())


const stepNames = ['step1', 'step2', 'step3']

const currentOpenHealthCheck = ref(null)
const modal = new Modal(emitter)
const langData = reactive({
  en: null,
  vi: null,
  ar: null,
  'zh-Hans': null,
  'zh-Hant': null,
})
const healthCheckTriggers = [
  {
    frag: 'health-check',
    lang: 'en',
  },
  {
    frag: 'health-check-arabic',
    lang: 'ar',
  },
  {
    frag: 'health-check-vietnamese',
    lang: 'vi',
  },
  {
    frag: 'health-check-chinese-traditional',
    lang: 'zh-Hant',
  },
  {
    frag: 'health-check-chinese-simplified',
    lang: 'zh-Hans',
  },
]
const { scoreInc } = useHealthCheckCalc()
const score = computed(() => {
  let score = 0;
  if (currentOpenHealthCheck.value == null || langData[currentOpenHealthCheck.value.lang] === null) {
    return null
  }
  const steps = langData[currentOpenHealthCheck.value.lang].translations.steps;
  stepNames.forEach(stepName => {
    for (const fieldName in steps[stepName].questions) {
      const val = steps[stepName].questions[fieldName].selected
      if (val !== null) {
        score += scoreInc(fieldName, val)
      }
    }
  })
  if (APP_ENV === 'dev') {
    console.log(score)
  }
  return score
})
const riskLevel = computed(() => {
  let general = 'low'
  let exact = 'low'
  if (score.value >= 6 && score.value <= 11) {
    general = 'medium'
    if (score.value < 9) {
      exact = 'medium-low'
    } else {
      exact = 'medium-high'
    }
  } else if (score.value > 11) {
    general = 'high'
    if (score.value < 16) {
      exact = 'high-low'
    } else if (score.value < 20) {
      exact = 'high-medium'
    } else {
      exact = 'high-high'
    }
  }
  return {
    general,
    exact,
  }
})

const { ContactFormHealthCheck  } = useContactFormHealthCheck()
const { gtmEvent, langToSlug } = useGtmDataLayer()


class HealthCheck {
  constructor(lang) {
    this.lang = lang
    this.stepsByFieldname = {}
    this.fieldByName = {}
    this.contactForm = null
    axios.get('/wp-json/health-check/v1/' + lang)
      .then(response => {
        const steps = {}
        stepNames.forEach(stepName => {
          steps[stepName] = this._stepWithState(response.data.translations.steps[stepName], stepName)
        })
        langData[lang] = {
          ...response.data,
          translations: {
            ...response.data.translations,
            steps,
          },
        }
        this.contactForm = reactive(new ContactFormHealthCheck(langData[lang].translations.contact, lang))
      })
    emitter.on('close-modal', () => {
      if (this.contactForm.posted) {
        window.location.href = window.location.href.split('#')[0]
      }
    })
  }
  translation() {
    return langData[this.lang].translations
  }
  _anyOfMultiselect(options) {
    for (const optionName in options) {
      if (options[optionName].isSelected) {
        return true
      }
    }
    return false
  }
  completed(step, fieldName) {
    if ('multiselect' in this.fieldByName[fieldName]) {
      return this._anyOfMultiselect(langData[this.lang].translations.steps[step].questions[fieldName].options)
    } else {
      return langData[this.lang].translations.steps[step].questions[fieldName].selected
    }
  }
  _stepWithState(data, stepName) {
    const questions = {}
    for (const fieldName in data.questions) {
      if ('multiselect' in data.questions[fieldName]) {
        const options = {}
        for (const optionName in data.questions[fieldName].options) {
          options[optionName] = {
            ...data.questions[fieldName].options[optionName],
            isSelected: false,
          }
        }
        questions[fieldName] = {
          ...data.questions[fieldName],
          options,
        }
      } else {
        questions[fieldName] = {
          ...data.questions[fieldName],
          selected: null,
        }
      }
    }
    if (stepName === 'step1' && TEST_TEST_SCORE !== null) {
      questions.gender.selected = 'Male'
      questions.age.selected = '35 - 44 years'
      questions.background.selected = 'No'
      questions.birthplace.selected = 'Australia'
      questions.diabetes.selected = 'No'
      questions.pregnancy.selected = 'No'
      questions.blood_pressure_medication.selected = 'No'
      questions.smoker.selected = 'No'
      questions.vegetables.selected = 'Everyday'
      questions.exercise.selected = 'Yes'
      switch (TEST_TEST_SCORE) {
        case 12:
          questions.age.selected = '65 years or over'
          questions.vegetables.selected = 'Not everyday'
          break
        case 11:
          questions.age.selected = '65 years or over'
          questions.gender.selected = 'Female'
          questions.background.selected = 'Yes'
        case 6:
          questions.vegetables.selected = 'Not everyday'
      }
    }
    const step = {
      ...data,
      questions,
    }
    for (const fieldName in data.questions) {
      this.stepsByFieldname[fieldName] = step
      this.fieldByName[fieldName] = step.questions[fieldName]
    }
    return step
  }
  open() {
    if (this.lang !== 'en') {
      const langSlug = langToSlug(this.lang)
      gtmEvent(`DL_test_${langSlug}`)
    }
    currentOpenHealthCheck.value = this
    emitter.emit('open-modal')
    modal.open()
    window.location.hash = healthCheckTriggers.find(trigger => trigger.lang === this.lang).frag
  }
  isOpen() {
    return currentOpenHealthCheck.value !== null && currentOpenHealthCheck.value === this
  }
}

const qCompletedFunc = (step) => (fieldName) => {
  return currentOpenHealthCheck.value.completed(step, fieldName)
}

const _healthCheck = {}
function healthCheck(lang) {
  if (!(lang in _healthCheck)) {
    _healthCheck[lang] = new HealthCheck(lang)
  }
  return _healthCheck[lang]
}

const isAtsi = () => {
  const background = langData[currentOpenHealthCheck.value.lang].translations.steps.step1.questions.background
  const birthplace = langData[currentOpenHealthCheck.value.lang].translations.steps.step1.questions.birthplace
  return background.selected === 'Yes' || birthplace.selected === 'Asia (including the Indian sub-continent)'
}

const waistForPost = (forIsAtsi = false) => {
  if (forIsAtsi !== isAtsi()) {
    return ''
  }
  const field = langData[currentOpenHealthCheck.value.lang].translations.steps.step2.questions.waist_range
  const gender = langData[currentOpenHealthCheck.value.lang].translations.steps.step1.questions.gender.selected
  const table = forIsAtsi ? 'measurement-table-two' : 'measurement-table-one'
  return field.ranges[gender][table].waist_ranges[field.selected].postVal
}


const expanderHeight = ref(0)
const updateExpanderHeight = () => {
  if (!contentHeightEl.value) return
  expanderHeight.value = contentHeightEl.value.clientHeight
}

// const resultsHeight = ref(0)

const hasPositiveDiagnosis = computed(() => {
  let positiveDiagnosis = false
  for (const field in currentOpenHealthCheck.value.fieldByName.diagnosis.options) {
    const option = currentOpenHealthCheck.value.fieldByName.diagnosis.options[field]
    if (option.isSelected && option.is_positive) {
      positiveDiagnosis = true
    }
  }
  return positiveDiagnosis
})
const programEligibility = computed(() => {
  return (riskLevel.value.general === 'high' || hasPositiveDiagnosis.value)
    ? 'risk-high-or-diagnosis'
    : 'risk-not-high-no-diagnosis'
})


export default () => {
  return {
    currentOpenHealthCheck,
    healthCheck,
    modal,
    langData,
    emitter,
    contentHeightEl,
    qCompletedFunc,
    confirmClicked,
    score,
    riskLevel,
    showingPage,
    waistForPost,
    healthCheckTriggers,
    expanderHeight,
    updateExpanderHeight,
    hasPositiveDiagnosis,
    programEligibility,
  }
}

