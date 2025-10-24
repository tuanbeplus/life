<template>
  <div
    :ref="el => contentHeightEl = el"
    class="health-check-loaded"
  >
    <h2 class="modal-heading">
      {{ trans.general.heading }}
      <span v-if="trans.general.subHeading">{{ trans.general.subHeading }}</span>
    </h2>
    <StepOne />
    <StepTwo
      v-if="currentOpenHealthCheck.completed('step1', 'exercise')"
    />
    <StepThree
      v-if="currentOpenHealthCheck.completed('step2', 'waist_range') && score < 12"
    />
    <div
      v-if="currentOpenHealthCheck.completed('step3', 'diagnosis') || (score >= 12 && currentOpenHealthCheck.completed('step2', 'waist_range'))"
      class="-confirm"
    >
      <div
        class="-button"
        @click="confirm"
      >
        {{ trans.confirm }}
      </div>
    </div>
  </div>
</template>
<script setup>
import StepOne from './StepOne.vue'
import StepTwo from './StepTwo.vue'
import StepThree from './StepThree.vue'
import useHealthCheck from '#/useHealthCheck.js'

const props = defineProps({
  trans: {
    type: Object,
    required: true,
  },
})

const {
  emitter,
  contentHeightEl,
  currentOpenHealthCheck,
  confirmClicked,
  score,
} = useHealthCheck()

emitter.on('selected', ({ fieldname }) => {
  let delay = 50
  if (fieldname === 'gender') {
    delay = 500
  } else if (fieldname === 'age') {
    delay = 200
  }
  setTimeout(() => {
    contentHeightEl.value.scrollIntoView({
      behavior: 'smooth',
      block: 'end',
    })
  }, delay)
})

const confirm = () => {
  confirmClicked.value = true
}


</script>