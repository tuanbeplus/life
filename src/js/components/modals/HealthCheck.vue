<template>
  <ModalWrap
    class="contact-modal-health-check"
    :modal="modal"
  >
    <div
      class="modal -health-check"
      :data-score="score"
      :data-lang="currentOpenHealthCheck !== null ? currentOpenHealthCheck.lang : 'null'"
      :class="{
        '-test-showing': showingPage.isShowingTest(true),
        '-results-showing': showingPage.isShowingResults(true),
        '-contact-form-showing': showingPage.isShowingContactForm(true),
        '-finished-questions': showingPage.isfinishedQuestions(),
      }"
    >
      <template
        v-if="currentOpenHealthCheck !== null"
      >
        <div
          class="-expanding"
          :style="`height: ${expanderHeight}px`"
        >
          <div
            v-if="langData[currentOpenHealthCheck.lang] === null"
            class="-loading"
          ></div>
          <HealthCheckLoaded
            v-else
            :trans="currentOpenHealthCheck.translation()"
          />
        </div>
        <TestResults
          v-if="showingPage.isShowingResults(false)"
          :template-directory-uri="templateDirectoryUri"
        />
        <ContactForm
          v-if="showingPage.isShowingContactForm(false)"
        />
      </template>
    </div>
  </ModalWrap>
</template>
<script setup>
import { onMounted, watch } from 'vue'
import ModalWrap from '~/widget/ModalWrap.vue'
import HealthCheckLoaded from '~/health-check/HealthCheckLoaded.vue'
import TestResults from '~/health-check/TestResults.vue'
import ContactForm from '~/health-check/ContactForm.vue'
import useHealthCheck from '#/useHealthCheck.js'

const props = defineProps({
  defaultLang: {
    type: String,
    required: true,
  },
  templateDirectoryUri: {
    type: String,
    required: true,
  },
})

const {
  currentOpenHealthCheck,
  modal,
  langData,
  healthCheck,
  emitter,
  contentHeightEl,
  score,
  confirmClicked,
  showingPage,
  expanderHeight,
  updateExpanderHeight,
} = useHealthCheck()



onMounted(() => {
  setTimeout(() => { /* pre-load after 2s to seem quicker on open */
    if (props.defaultLang === 'zh') {
      healthCheck('zh-Hant')
      healthCheck('zh-Hans')
    } else {
      healthCheck(props.defaultLang)
    }
    updateExpanderHeight()
  }, 1000)
  let resizeTimeout = null
  window.addEventListener('resize', () => {
    if (resizeTimeout !== null) {
      clearTimeout(resizeTimeout)
    }
    resizeTimeout = setTimeout(() => {
      updateExpanderHeight()
      resizeTimeout = null
    }, 500)
  })
})

emitter.on('selected', () => {
  setTimeout(() => {
    updateExpanderHeight()
  }, 100)
})
emitter.on('open-modal', () => {
  if (showingPage.isShowingTest()) {
    setTimeout(() => {
      updateExpanderHeight()
    }, 100)
  }
})

watch(confirmClicked, (v) => {
  if (v) {
    contentHeightEl.value.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    })
    showingPage.showResults()
  } else {
    console.error('cant unconfirm test')
  }
})


</script>