<template>
  <div
    ref="el"
    class="step"
    :class="{
      '-showing': step.isShowing.value || step.i === 0,
    }"
  >
    <slot />
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useIntersectionObserver } from '@vueuse/core'

const props = defineProps({
  step: {
    type: Object,
    required: true,
  },
})

const el = ref(null)

onMounted(() => {
  setTimeout(() => {
    useIntersectionObserver(
      el,
      ([{ isIntersecting }]) => {
        if (isIntersecting) {
          props.step.isShowing.value = true
        }
      },
      {
        rootMargin: '0px 0px -160px 0px',
      }
    )
  }, 2000)
  useIntersectionObserver(
    el,
    ([{ isIntersecting }]) => {
      if (isIntersecting) {
        props.step.inView.value = true
      } else {
        props.step.inView.value = false
      }
    },
    {
      rootMargin: '50px 0px 50px 0px',
    }
  )
})

</script>