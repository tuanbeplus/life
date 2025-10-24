<template>
  <div
    ref="el"
    class="colored-block"
    :class="{
      '-in-view': inView,
    }"
  >
    <slot />
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useIntersectionObserver } from '@vueuse/core'


const inView = ref(false)
const el = ref(null)

onMounted(() => {
  useIntersectionObserver(
    el,
    ([{ isIntersecting }]) => {
      if (isIntersecting) {
        inView.value = true
      } else {
        inView.value = false
      }
    },
    {
      rootMargin: '300px 0px -100px 0px',
    }
  )
})

</script>