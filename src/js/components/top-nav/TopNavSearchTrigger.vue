<template>
  <div class="top-nav-search-trigger">
    <button
      type="button"
      aria-label="Search"
      @click="searchIsOpen = true"
    >
      <SvgIconSearch />
    </button>
  </div>
</template>
<script setup>
import SvgIconSearch from '~/svg/ui/IconSearch.vue'
import useTopNav from '#/useTopNav.js'

const { searchIsOpen } = useTopNav()


</script>