<template>
  <div
    :ref="el => elForResize = el"
    class="test-results-inner-old"
  >
    <div
      class="screening-results"
      :class="`-lang-${currentOpenHealthCheck.lang}`"
    >
      <div class="inner font-middling wt-sb lh-std">
        <p>{{ lang.yourScoreIs }}</p>
        <div
          class="score font-huge"
        >
          {{ score }}
        </div>
        <p>{{ lang.yourRiskLevelIs }}</p>
        <div
          class="risk-level font-md wt-bold"
        >
          {{ currentOpenHealthCheck.translation().riskLevels[riskLevel.general].t }}
        </div>
        <!-- <div class="logo-minimal">
          <SvgLifeMinimal />
        </div> -->
      </div>
    </div>
    <div class="screening-grades">
      <ul>
        <li
          v-for="(riskL, generalRiskStr) in currentOpenHealthCheck.translation().riskLevels"
          :key="generalRiskStr"
          :class="{
            '-current': riskLevel.general === generalRiskStr,
          }"
        >
          <div class="range font-mdish wt-sb">
            {{ riskL.desc }}
          </div>
          <div class="tier font-md wt-bold">
            {{ riskL.t }}
          </div>
        </li>
      </ul>
    </div>
    <div
      v-if="programEligibility === 'risk-high-or-diagnosis'"
      class="eligibility formatted"
    >
      <h6
        style="text-align: center; text-wrap: balance"
        v-html="lang.youMayBeEligible"
      />
    </div>
    <div
      v-if="programEligibility === 'risk-high-or-diagnosis'"
      class="-contact-options"
    >
      <ul
        class="contact-options mobile-contact-options"
        style="justify-content: center; text-align: center"
      >
        <li class="-button">
          <button
            type="button"
            class="button primary"
            @click="showingPage.showContactForm(langSlug)"
          >
            {{ lang.contactUsAboutJoining }}
          </button>
        </li>
        <li class="-or-call">
          <h5
            class="font-mdish wt-bold fg-dark-grey"
            v-html="lang.contactOptions.orCall"
          />
        </li>
      </ul>
    </div>
    <div
      v-show="riskLevel.general === 'high'"
      class="screening-legend"
    >
      <ul>
        <li
          class="bg-off-white"
          :class="currentOpenHealthCheck.lang"
          style="justify-content: center; text-align: center"
        >
          <div class="details">
            <h5
              v-if="currentOpenHealthCheck.lang === 'zh-Hans'"
              class="font-middling wt-md align-center"
            >
              {{ currentOpenHealthCheck.translation().riskLevels[riskLevel.general].t }}
            </h5>
            <p
              :class="`risk-${riskLevel.exact} ${currentOpenHealthCheck.lang}`"
              v-html="currentOpenHealthCheck.translation().riskLevels[riskLevel.general].statistic"
            />
          </div>
        </li>
      </ul>
    </div>
    <div
      v-if="programEligibility === 'risk-high-or-diagnosis'"
      class="content formatted"
    >
      <p
        style="text-align: center"
        v-html="lang.lifeHasHelpedOver"
      />
    </div>
    <div
      v-if="programEligibility === 'risk-not-high-no-diagnosis'"
    >
      <div class="content formatted">
        <h6
          style="text-align: center; text-wrap: balance"
          v-html="lang.youAreNotEligible"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed, onMounted, ref } from 'vue'
// import SvgLifeMinimal from '~/svg/logo/LifeMinimal.vue'
import useHealthCheck from '#/useHealthCheck.js'
import useGtmDataLayer from '#/useGtmDataLayer.js'

const {
  currentOpenHealthCheck,
  langData,
  score,
  riskLevel,
  showingPage,
  programEligibility,
  expanderHeight,
} = useHealthCheck()

const lang = computed(() => {
  return langData[currentOpenHealthCheck.value.lang].translations.results.oldLayout
})

// console.log('currentOpenHealthCheck.value.lang', currentOpenHealthCheck.value.lang)

// const numberOfPeople = computed(() => {
//   switch (riskLevel.value.exact) {
//     case 'low': return 100
//     case 'medium-low': return 30 // 50
//     case 'medium-high': return 30
//     case 'high-low': return 3 // 14
//     case 'high-medium': return 3 // 7
//     case 'high-high': return 3
//     default: return 0
//   }
// })

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

const { gtmEvent, langToSlug } = useGtmDataLayer()

const langSlug = computed(() => langToSlug(currentOpenHealthCheck.value.lang))


const sendGtmEvent = (risk, lang) => {
  if (!['low', 'medium', 'high'].includes(risk)) {
    console.error('FAILED GTM Datalayer push - unknown risk', risk)
    return
  }
  if (!['ar', 'zh_hans', 'zh_hant', 'vi'].includes(lang)) {
    console.error('FAILED GTM Datalayer push - unknown lang', lang)
    return
  }
  gtmEvent(`DL_risk_${risk}_${lang}`)
}

onMounted(() => {
  updateHeight()
  window.addEventListener('resize', updateHeight)
  // gtmEvent('DL_score_en', {
  //   'AUSDRISK Score': score.value,
  // })
  sendGtmEvent(
    riskLevel.value.general,
    langSlug.value,
  )
})

</script>