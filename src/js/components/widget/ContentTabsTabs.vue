<template>
  <div class="content-tabs-tabs">
    <section class="giant-tabs bg-white">
      <div class="center-frame">
        <div class="pathway-choices no-separator">
          <ul>
            <li
              v-for="(tab, i) in tabs.tabs"
              :key="i"
            >
              <div
                class="inner"
                :class="{
                  'active': tab.slug === tabs.current.value
                }"
                @click="tabs.setCurrentFromClick(tab.slug)"
              >
                <h3
                  v-if="tab.heading"
                  class="font-md wt-sb lh-std"
                  v-html="tab.heading"
                />
                <div
                  v-if="tab.description"
                  class="content lh-md"
                  v-html="tab.description"
                />
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <div class="-tabtab-panes">
      <div
        v-for="(tab, i) in tabs.tabs"
        :key="i"
        class="-pane"
        :class="{
          '-current': tab.slug === tabs.current.value,
        }"
      >
        <slot
          v-if="tab.type === 'content'"
          name="tabtab-content"
        />
        <OrderResources
          v-if="tab.type === 'resources'"
          :resources="tab.resources"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted } from 'vue'
import useContentTabsTabs from '#/useContentTabsTabs.js'
import OrderResources from '~/contact-forms/OrderResources.vue'

const props = defineProps({
  tabsData: {
    type: Array,
    required: true,
  },
})

const { ContentTabsTabs } = useContentTabsTabs()

const tabs = new ContentTabsTabs(props.tabsData)

onMounted(() => {
  const hash = window.location.hash
  const slug = hash.length > 1 ? hash.substring(1) : null
  tabs.setCurrentSlug(slug, true)

})

</script>