<template>
  <div
    class="single-accordion section-pad-y"
    :class="{
      '-open': isOpen,
    }"
  >
    <div class="-head">
      <button
        type="button"
        @click="isOpen = !isOpen"
      >
        <h3
          class="font-md wt-sb lh-std"
        >
          {{ heading }}
        </h3>
      </button>
    </div>
    <div
      class="-expander"
    >
      <div class="-height">
        <div class="-inner">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'

defineProps({
  heading: {
    type: String,
    default: null,
  },
})

const isOpen = ref(false)

onMounted(() => {
  const hash = window.location.hash
  const slug = hash.length > 1 ? hash.substring(1) : null
  if (slug) { // nqr
    isOpen.value = true
  }
})
</script>