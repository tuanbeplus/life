<template>
  <section class="get-involved-tabs bg-white overflow-hidden">
    <div class="-main-tabs-section center-frame">
      <ContentTabs
        class="-tablet-head-nav-grid"
        :tabs="tabs"
        :mobile-accordion="true"
        @tabchange="tabChange"
      >
        <template
          v-for="(tab, i) in tabs"
          #[`tab-${i}`]
        >
          <slot
            :name="`tab-${i}`"
          />
        </template>
      </ContentTabs>
    </div>
    <div class="get-involved-register">
      <div
        v-for="(tab, i) in tabs"
        :key="`lower-${i}`"
        class="-lower-content"
        :class="{
          '-current': i === currentI,
        }"
      >
        <slot
          :name="`lower-${i}`"
        />
      </div>
    </div>
  </section>
</template>
<script setup>
import { ref } from 'vue'
import ContentTabs from '~/widget/ContentTabs.vue'

const props = defineProps({
  tabs: {
    type: Array,
    required: true,
  },
})
const currentI = ref(0)

const tabChange = (i) => {
  currentI.value = i
}

</script>