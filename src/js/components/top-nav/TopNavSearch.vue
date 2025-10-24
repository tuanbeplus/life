<template>
  <div
    class="top-nav-search"
    :class="{
      'visible': searchIsOpen,
    }"
  >
    <div class="inner">
      <form
        action="/"
        method="get"
      >
        <div
          class="form-group placeholder-field"
          :class="{
            'populated': inpVal !== '',
          }"
        >
          <label for="mobile-search-query">Search for...</label>
          <input
            id="mobile-search-query"
            v-model="inpVal"
            type="text"
            name="s"
            class="no-bdr"
            required
          />
        </div>
        <button
          type="submit"
          class="icon"
          aria-label="Submit search"
          @click="search"
        >
          <SvgIconSearch />
        </button>
      </form>
      <button
        type="button" 
        class="icon close-search"
        @click="searchIsOpen = false"
      >
        <SvgIconTimes />
      </button>
    </div>
    <div
      class="mask"
      @click="searchIsOpen = false"
    />
  </div>
</template>
<script setup>
import { ref } from 'vue'
import SvgIconTimes from '~/svg/ui/IconTimes.vue'
import SvgIconSearch from '~/svg/ui/IconSearch.vue'
import useTopNav from '#/useTopNav.js'

const { searchIsOpen } = useTopNav()
const inpVal = ref('')

const search = () => {
  console.log('search todo')
}

</script>