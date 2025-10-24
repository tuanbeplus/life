<template>
  <div
    class="health-check-trigger"
    :class="{
      '-is-min': minimized,
      '-is-trans': inTransition,
      [`-lang-${lang}`]: true,
    }"
  >
    <div class="-pos">
      <div class="-bg">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <div class="-content">
        <div
          class="-close"
          @click="toggle"
        >
          <SvgIconTimesBold />
        </div>
        <div
          v-for="(l, i) in translatedText"
          :key="i"
          class="-lang"
        >
          <div class="-text">
            <h2>{{ l.takeTheHealthCheck }}</h2>
          </div>
          <div
            class="-button"
            @click="trigger('precise' in l ? l.precise : lang)"
          >
            {{ l.startNow }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import SvgIconTimesBold from '~/svg/ui/IconTimesBold.vue'
import useHealthCheck from '#/useHealthCheck.js'

const props = defineProps({
  lang: {
    type: String,
    required: true,
  },
  translatedText: {
    type: Array,
    required: true,
  },
})
const { healthCheck } = useHealthCheck()

const minimized = ref(false)
const inTransition = ref(false)
const STORAGE_KEY = 'health-check-trigger-minimized'

const toggle = () => {
  if (inTransition.value) return
  inTransition.value = true
  minimized.value = !minimized.value
  sessionStorage.setItem(STORAGE_KEY, minimized.value ? '1' : '0')
  setTimeout(() => {
    inTransition.value = false
  }, 400)
}

const trigger = (lang) => {
  healthCheck(lang).open()
}

onMounted(() => {
  minimized.value = (sessionStorage.getItem(STORAGE_KEY) == '1')
})

</script>