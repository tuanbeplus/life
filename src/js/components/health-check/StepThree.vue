<template>
  <div
    class="step-three"
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
          <QuestionCheckboxes
            fieldname="diagnosis"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import useHealthCheck from '#/useHealthCheck.js'
import QuestionCheckboxes from './QuestionCheckboxes.vue'

const { currentOpenHealthCheck } = useHealthCheck()

const step = computed(() => {
  return currentOpenHealthCheck.value.translation().steps.step3
})

</script>