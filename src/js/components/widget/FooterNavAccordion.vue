<template>
  <div class="footer-nav-accordion">
    <div
      v-for="(col, i) in cols"
      :key="i"
      class="-group"
      :class="{
        '-is-open': openGroup === i
      }"
    >
      <div
        class="-title"
        @click="toggle(i)"
      >
        <slot :name="`title-${i}`" />
        <div class="-icon">
        </div>
      </div>
      <div class="-links">
        <div class="-links-inner">
          <slot :name="`links-${i}`" />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'

const props = defineProps({
  cols: {
    type: Array,
    required: true,
  },
})

const openGroup = ref(null)

const toggle = (i) => {
  if (openGroup.value === i) {
    openGroup.value = null
  } else {
    openGroup.value = i
  }
}

</script>