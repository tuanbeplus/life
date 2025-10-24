<template>
  <div
    class="top-nav-lang-selector"
    :class="{
      '-desktop': viewType === 'desktop',
      '-mobile': viewType === 'mobile',
      '-is-open': isOpen,
    }"
  >
    <div class="lang-select-field-small">
      <div
        class="-head"
        @click="toggleOpen"
      >
        <SvgIconGlobe />
        <span
          v-if="text !== null"
          class="-text"
        >
          {{ text }}
        </span>
        <div class="-chev">
          <SvgChevDown />
        </div>
      </div>
      <div class="-drop">
        <div>
          <div
            v-for="(opt, i) in options"
            :key="i"
            class="-opt -opt-en"
            @click="selectLang(opt, i)"
          >
            <div class="opt-label">
              <div class="-text">
                {{ opt.label }}
              </div>
            </div>
            <SvgIconCircleTick
              v-if="selectedI === i"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import SvgChevDown from '~/svg/ui/ChevDown.vue'
import SvgIconGlobe from '~/svg/ui/IconGlobe.vue'
import SvgIconCircleTick from '~/svg/ui/IconCircleTick.vue'

const props = defineProps({
  viewType: {
    type: String,
    required: true,
  },
  options: {
    type: Array,
    required: true,
  },
  selectedI: {
    type: Number,
    required: true,
  },
  text: {
    type: String,
    default: null,
  },
})

const isOpen = ref(false)

const toggleOpen = () => {
  isOpen.value = ! isOpen.value
}

const selectLang = (opt, i) => {
  if (props.selectedI === i) {
    isOpen.value = false
  } else {
    location.href = opt.url
  }
}

</script>