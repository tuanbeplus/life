<template>
  <div
    class="test-results"
    :class="{
      '-old-layout': currentOpenHealthCheck.translation().results.oldLayout !== false,
    }"
  >
    <TestResultsInner
      v-if="currentOpenHealthCheck.translation().results.oldLayout === false"
      :template-directory-uri="templateDirectoryUri"
    />
    <TestResultsInnerOld v-else />
  </div>
</template>
<script setup>
import useHealthCheck from '#/useHealthCheck.js'
import TestResultsInner from './TestResultsInner.vue'
import TestResultsInnerOld from './TestResultsInnerOld.vue'

const props = defineProps({
  templateDirectoryUri: {
    type: String,
    required: true,
  },
})
const {
  currentOpenHealthCheck,
} = useHealthCheck()






</script>