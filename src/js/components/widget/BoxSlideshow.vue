<template>
  <ul class="box-slideshow blocks transition">
    <li
      v-for="(slide, i) in slides"
      class="-box colored-block"
      :class="{
        'current': i === currentI,
        [slide.color]: true,
      }"
    >
      <h3 v-html="slide.header" />
      <div
        v-if="slide.content"
        v-html="slide.content"
      />
    </li>
  </ul>
</template>
<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
  slides: {
    type: Array,
    required: true,
  },
  interval: {
    type: Number,
    default: 5000,
  },
})

const currentI = ref(0)

onMounted(() => {
  setInterval(() => {
    currentI.value = (currentI.value + 1) % props.slides.length
  }, props.interval)
})


</script>