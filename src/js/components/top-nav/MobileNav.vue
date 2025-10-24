<template>
  <div
    class="mobile-nav"
    :class="{
      'visible': mobileNavIsOpen,
    }"
  >
    <div class="inner">
      <div class="-close">
        <div
          class="-icon"
          @click="mobileNavIsOpen = false"
        >
          <SvgIconTimes />
        </div>
      </div>
      <form
        action="/"
        method="get"
        class="mobile-search-form"
      >
        <div
          class="form-group placeholder-field"
          :class="{
            'populated': inpVal !== '',
          }"
        >
          <label for="search-query">Search for...</label>
          <input
            id="search-query"
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
          aria-label="Search"
        >
          <SvgIconSearch />
        </button>
      </form>
      <nav class="primary-nav">
        <ul>
          <li
            v-for="item in linksPrimary"
            :key="item.id"
            :class="{
              'has-children': item.childItems.length,
            }"
          >
            <MobileNavAccordion
              v-if="item.childItems.length"
              :item="item"
            />
            <a
              v-else
              :href="item.url"
              :class="item.classes.join(' ')"
              v-html="item.title"
            />
          </li>
        </ul>
      </nav>
      <nav class="secondary-nav">
        <ul>
          <li
            v-for="item in linksUpper"
            :key="item.id"
          >
            <a
              :href="item.url"
              :class="item.classes.join(' ')"
              v-html="item.title"
            />
          </li>
        </ul>
      </nav>
      <div class="contact">
        <ul class="wt-sb">
          <li>
            <a
              href="tel:137475"
              class="fg-primary risk-13-wcag"
            >13 RISK</a>
          </li>
          <li>
            <a
              href="tel:137475"
              class="fg-near-black"
            >13 74 75</a>
          </li>
        </ul>
      </div>
      <nav class="-primary-nav-buttons">
        <div
          v-for="item in linksPrimaryButtons"
          :key="item.id"
        >
          <a
            :href="item.url"
            :class="item.classes.join(' ')"
            v-html="item.title"
          />
        </div>
      </nav>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'
import SvgIconTimes from '~/svg/ui/IconTimes.vue'
import SvgIconSearch from '~/svg/ui/IconSearch.vue'
import useMobileNav from '#/useMobileNav.js'
import MobileNavAccordion from './MobileNavAccordion.vue'


const props = defineProps({
  linksPrimary: {
    type: Array,
    required: true,
  },
  linksUpper: {
    type: Array,
    required: true,
  },
  linksPrimaryButtons: {
    type: Array,
    required: true,
  },
})

const { mobileNavIsOpen } = useMobileNav()

const inpVal = ref('')


</script>