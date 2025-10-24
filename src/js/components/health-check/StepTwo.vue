<template>
  <div
    class="step-two"
  >
    <div class="-questions-outer">
      <div class="-left-bordered">
        <div class="-step-header">
          <div>
            <h3 class="-number">
              <span>{{ step.title }}</span>
            </h3>
          </div>
        </div>
        <div class="-questions">
          <QuestionWaistRange
            fieldname="waist_range"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import QuestionWaistRange from './QuestionWaistRange.vue'
import useHealthCheck from '#/useHealthCheck.js'

const { currentOpenHealthCheck } = useHealthCheck()

const step = computed(() => {
  return currentOpenHealthCheck.value.translation().steps.step2
})

</script>