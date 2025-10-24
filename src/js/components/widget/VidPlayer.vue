<template>
  <div
    class="vid-player"
  >
    <div
      v-if="fullSrc"
      ref="el"
      class="plyr__video-embed"
    >
      <iframe
        :src="fullSrc"
        allowfullscreen
        allowtransparency
        allow="autoplay"
      ></iframe>
    </div>
  </div>
</template>

<script setup>
import { onMounted, computed, ref } from 'vue'
import usePlyr from '#/usePlyr.js'

const props = defineProps({
  src: {
    type: String,
    required: true,
  },
})

const el = ref(null)

const fullSrc = computed(() => {
  if (typeof props.src === 'string') {
    if (props.src.startsWith('https://youtu.be/')) {
      const code = props.src.split('youtu.be/')[1].split(/[^a-zA-Z0-9_]/)[0]
      return `https://www.youtube.com/embed/${code}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1`
    }
  }
  return null
})

const { plyrPromise } = usePlyr()

onMounted(() => {
  if (fullSrc.value) {
    plyrPromise().then(() => {
      /* eslint-disable no-undef */
      new Plyr(el.value)
    })
  }
})


</script>