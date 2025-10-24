<template>
  <div
    class="mobile-nav-accordion"
    :class="{
      'expanded': isOpen,
    }"
  >
    <span
      class="-head"
      :class="item.classes.join(' ')"
      @click="isOpen = !isOpen"
    >
      <span
        class="-title"
        v-html="item.title"
      />
      <span class="-chev">
        <SvgChevDown />
      </span>
    </span>
    <ul class="submenu">
      <li
        v-for="childItem in item.childItems"
        :key="childItem.id"
        :class="childItem.classes.join(' ')"
      >
        <a
          :href="childItem.url"
          v-html="childItem.title"
        />
      </li>
    </ul>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import SvgChevDown from '~/svg/ui/ChevDown.vue'

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
})

const isOpen = ref(false)


</script>