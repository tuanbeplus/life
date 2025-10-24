<template>
  <div
    :ref="el => elForResize = el"
    class="test-results-inner"
  >
    <header :data-temp="programEligibility">
      <div class="-bg">
        <h2>{{ lang.yourScoreIs }} <span id="health-check-risk-score">{{ score }}</span></h2>
        <h3
          v-html="lang.headerEligibility[programEligibility].heading"
          :class="lang.headerEligibility[programEligibility].cssClass"
        />
        <h4
          v-if="'post_heading' in lang.headerEligibility[programEligibility]"
          class="-post-heading"
          v-html="lang.headerEligibility[programEligibility].post_heading"
        />
        <div
          v-if="!('post_heading' in lang.headerEligibility[programEligibility]) || hasPositiveDiagnosis"
          class="-cta"
        >
          <button
            type="button"
            class="button primary en"
            @click="showingPage.showContactForm('en')"
          >
            {{ lang.headerEligibility[programEligibility].register.buttonText }}
          </button>
          <h5
            class="font-mdish wt-bold"
            v-html="lang.headerEligibility[programEligibility].register.orCall"
          />
        </div>
      </div>
      <div class="-wave-graphic">
        <svg
          width="100%"
          height="100%"
          viewBox="0 0 830 40"
          version="1.1"
        >
          <path
            d="M292.126,40C172.186,40 56.736,31.286 0,23.937L0,0L830,0L830,31.811C716.401,17.953 586.164,23.628 478.111,31.811C473.329,32.132 344.24,40 292.126,40Z"
            style="fill:currentColor;fill-rule:nonzero;"
          />
        </svg>
      </div>
    </header>
    <section>
      <div
        v-if="'points' in lang.bodies[programEligibility]"
        class="-breakdown"
      >
        <h3 v-html="lang.body_intro" />
        <div
          v-for="(point, i) in lang.bodies[programEligibility].points"
          :key="i"
          class="-point"
        >
          <div class="-icon">
            <img
              :src="templateDirectoryUri + '/images/' + point.icon"
              loading="lazy"
              decoding="async"
              alt="{{ point.icon_alt }}"
            />
          </div>
          <div class="-text">
            <p>{{ point.text }}</p>
          </div>
        </div>
      </div>
      <div
        v-else-if="'splash_image' in lang.bodies[programEligibility]"
        class="-splash-image"
      >
        <picture>
          <source
            media="(max-width: 800px)"
            type="image/webp"
            :srcset="templateDirectoryUri + lang.bodies[programEligibility].splash_image.mobile"
          />
          <img
            :src="templateDirectoryUri + lang.bodies[programEligibility].splash_image.desktop"
            alt="happy healthy people"
          />
        </picture>
      </div>
    </section>
    <footer>
      <div
        id="tracking-risk-level-en"
      >
        <p
          v-show="programEligibility === 'risk-high-or-diagnosis'"
          :class="`risk-${riskLevel.exact} en`"
          v-html="lang.statistic.replace('_NUMBER_OF_PEOPLE_', numberOfPeople)"
        />
      </div>
      <p
        class="-by-completing"
        v-html="lang.footer_by_completing[programEligibility]"
      />
    </footer>
  </div>
</template>
<script setup>
import { computed, onMounted, ref } from 'vue'
import useHealthCheck from '#/useHealthCheck.js'
import useGtmDataLayer from '#/useGtmDataLayer.js'

const props = defineProps({
  templateDirectoryUri: {
    type: String,
    required: true,
  },
})
const {
  currentOpenHealthCheck,
  langData,
  score,
  riskLevel,
  showingPage,
  hasPositiveDiagnosis,
  programEligibility,
  expanderHeight,
  // emitter,
} = useHealthCheck()


const lang = computed(() => {
  return langData[currentOpenHealthCheck.value.lang].translations.results
})

const numberOfPeople = computed(() => {
  switch (riskLevel.value.exact) {
    case 'low': return 100
    case 'medium-low': return 50
    case 'medium-high': return 30
    case 'high-low': return 14
    case 'high-medium': return 7
    case 'high-high': return 3
    default: return 0
  }
})


const elForResize = ref(null)

const updateHeight = () => {
  setTimeout(() => {
    // console.log(' - ')
    // console.log('elForResize.value', elForResize.value)
    // console.log(' - ')
    if (elForResize.value) {
      const h = elForResize.value.clientHeight
      // resultsHeight.value = h
      expanderHeight.value = h
    }
  }, 1000)
}

// emitter.on('open-modal', () => {
//   updateHeight()
// })

const { gtmEvent } = useGtmDataLayer()

onMounted(() => {
  updateHeight()
  window.addEventListener('resize', updateHeight)
  switch (riskLevel.value.general) {
    case 'low':
      gtmEvent('DL_risk_low_en')
      break
    case 'medium':
      gtmEvent('DL_risk_medium_en')
      break
    case 'high':
      gtmEvent('DL_risk_high_en')
      break
    default:
      console.error('FAILED GTM Datalayer push - unknown risk level', riskLevel.value.general)
  }
  // don't need below cos event `AUSDRISK Score visible` trigger by #health-check-risk-score
  // gtmEvent('DL_score_en', {
  //   'AUSDRISK Score': score.value,
  // })
  if (programEligibility.value === 'risk-high-or-diagnosis') {
    gtmEvent('DL_program_eligible_en')
  } else if (programEligibility.value === 'risk-not-high-no-diagnosis') {
    gtmEvent('DL_program_not_eligible_en')
  } else {
    console.error('invalid programEligibility', programEligibility.value)
  }
})

</script>