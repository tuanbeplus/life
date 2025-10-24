<template>
  <div
    class="story-container"
    :class="{
      '-expanded': isExpanded,
    }"
  >
    <div class="story">
      <slot name="head" />
      <div
        v-if="hasStory"
        class="-expander"
      >
        <div class="-height">
          <div class="content formatted">
            <slot />
          </div>
        </div>
      </div>
      <div
        v-if="hasStory"
        class="toggle-content"
      >
        <button
          class="button primary sm show"
          @click="isExpanded = !isExpanded"
        >
          <SvgFourBars />
          <span>Read more</span>
        </button>
        <button
          class="button grey sm hide"
          @click="isExpanded = !isExpanded"
        >
          <SvgIconTimes />
          <span>Close story</span>
        </button>
      </div>
    </div>
    <div
      v-if="typeof image === 'object' && 'sizes' in image"
      class="image"
      :class="`fg-${fg}`"
    >
      <div class="inner masked">
        <img
          :src="image.sizes.testimonial" 
          class="cover"
        />
        <div class="mask">
          <SvgTestimonialMask />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import SvgFourBars from '~/svg/ui/FourBars.vue'
import SvgIconTimes from '~/svg/ui/IconTimes.vue'
import SvgTestimonialMask from '~/svg/clip-path/TestimonialMask.vue'

const props = defineProps({
  hasStory: {
    type: Boolean,
    required: true,
  },
  image: {
    type: Object,
    default: null,
  },
  fg: {
    type: String,
    required: true,
  },
})

const isExpanded = ref(false)

</script>