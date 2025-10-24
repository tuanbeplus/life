<template>
  <div class="testimonials-slideshow">
    <div
      class="-slides"
      :style="`height: ${slideHeight}px`"
    >
      <div
        ref="slideEls"
        class="-slide"
        v-for="(slide, i) in slides"
        :key="i"
        :class="{
          '-current': i === currentSlide,
        }"
      >
        <slot :name="`slide-${i}`" />
      </div>
    </div>
    <div
      v-if="slides.length > 1"
      class="pagination"
    >
      <ul>
        <li
          v-for="(slide, i) in slides"
          @click="setSlide(i)"
          :class="{
            '-current': i === currentSlide,
          }"
        />
      </ul>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'


const props = defineProps({
  slides: {
    type: Array,
    required: true,
  },
})
const slideEls = ref([])
const slideHeight = ref(100)

const currentSlide = ref(0)

const setSlideHeight = () => {
  slideHeight.value = slideEls.value[currentSlide.value].offsetHeight
}

const setSlide = (i) => {
  currentSlide.value = i
  setSlideHeight()
  setAutoTimeout()
}

let autoTimeout = null
const setAutoTimeout = () => {
  if (autoTimeout !== null) {
    clearTimeout(autoTimeout)
  }
  autoTimeout = setTimeout(() => {
    autoTimeout = null
    setSlide((currentSlide.value + 1) % props.slides.length)
  }, 5000)
}

onMounted(() => {
  setTimeout(() => {
    setSlideHeight()
  }, 200)

  window.addEventListener('resize', setSlideHeight)

  setAutoTimeout()
})
</script>