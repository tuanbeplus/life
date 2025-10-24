<template>
  <div class="video-slideshow">
    <div
      class="-slide"
      v-for="(slide, i) in slides"
      :key="i"
      :class="{
        '-current': i === currentSlide,
      }"
    >
      <div class="-image">
        <img
          :src="slide['video_thumbnail']['sizes']['large'] ?? ''"
          alt=""
          loading="lazy"
          decoding="async"
        />
        <div class="-overlay">
          <button
            @click="toggler = !toggler"
            aria-label="Play this video"
          >
            <SvgIconPlay />
          </button>
        </div>
      </div>
      <div class="-text">
        <div class="-top">
          <h2
            v-if="'title' in slide"
            class="ssvc__text-h2"
            v-html="slide.title"
          />
          <p v-html="slide.description" />
          <div class="-dots">
            <span
              v-for="(video, ii) in slides"
              :key="ii"
              class="-dot"
              :class="{
                '-current': ii === currentSlide,
              }"
              @click="currentSlide = ii"
            />
          </div>
        </div>
        <button
          @click="toggler = !toggler"
        >
          <span class="-text">Watch video</span>
          <span class="-icon">
            <SvgIconPlay />
          </span>
        </button>
      </div>
    </div>
    <FsLightbox
      :toggler="toggler"
      :sources="sources"
      :slide="currentSlide + 1"
    />
  </div>
</template>
<script setup>
import { ref } from 'vue'
import SvgIconPlay from '~/svg/ui/IconPlay.vue'
import FsLightbox from "fslightbox-vue/v3";


const props = defineProps({
  slides: {
    type: Array,
    required: true,
  },
})

const currentSlide = ref(0)
const toggler = ref(false)


const sources = ref([])


props.slides.forEach(slide => {
  sources.value.push(slide.video_url)
})



</script>