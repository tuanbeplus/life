<template>
  <div
    class="step-one"
    :class="{
      '-completed': qCompleted('exercise'),
    }"
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
          <QuestionOpts
            fieldname="gender"
          />
          <QuestionOpts
            v-if="qCompleted('gender')"
            fieldname="age"
          />
          <QuestionOpts
            v-if="qCompleted('age')"
            fieldname="background"
          />
          <QuestionOpts
            v-if="qCompleted('background')"
            fieldname="birthplace"
          />
          <QuestionOpts
            v-if="qCompleted('birthplace')"
            fieldname="diabetes"
          />
          <QuestionOpts
            v-if="qCompleted('diabetes')"
            fieldname="pregnancy"
          />
          <QuestionOpts
            v-if="qCompleted('pregnancy')"
            fieldname="blood_pressure_medication"
          />
          <QuestionOpts
            v-if="qCompleted('blood_pressure_medication')"
            fieldname="smoker"
          />
          <QuestionOpts
            v-if="qCompleted('smoker')"
            fieldname="vegetables"
          />
          <QuestionOpts
            v-if="qCompleted('vegetables')"
            fieldname="exercise"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import QuestionOpts from './QuestionOpts.vue'
import useHealthCheck from '#/useHealthCheck.js'

const { qCompletedFunc, currentOpenHealthCheck } = useHealthCheck()

const qCompleted = qCompletedFunc('step1')

const step = computed(() => {
  return currentOpenHealthCheck.value.translation().steps.step1
})

</script>