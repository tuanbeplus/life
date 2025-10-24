<template>
  <div class="pathway-steps">
    <div
      v-for="i in numSteps"
      :key="i"
      ref="stepEls"
      class="step"
    >
      <slot :name="`step-${i}`" />
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useIntersectionObserver } from '@vueuse/core'

const props = defineProps({
  numSteps: {
    type: Number,
    required: true,
  },
})

const stepEls = ref([])
// let eventBus = null
// if (props.nqrEventBusName === 'pathways-tabs') {
//   eventBus.on('updateContentTabs', (i) => {
//     stepEls.value.forEach((el, i) => {
//       if (i > 0) {
//         if (el.classList.contains('-off-screen')) {
//           el.classList.remove('-showing')
//           el.classList.remove('-off-screen')
//         }
//       }
//     })
//   })
// }

console.log('numSteps', props.numSteps)

onMounted(() => {
  stepEls.value.forEach((el, i) => {
    useIntersectionObserver(
      el,
      ([{ isIntersecting }]) => {
        if (isIntersecting) {
          el.classList.add('-showing')
        } else {
          el.classList.add('-off-screen')
        }
      },
      {
        rootMargin: '-100px 0px -200px 0px',
      }
    )
  })
})


</script>