<template>
  <div
    ref="rootEl"
    class="content-tabs-tabs"
  >
    <section class="giant-tabs bg-white">
      <div class="center-frame">
        <div class="pathway-choices no-separator">
          <ul>
            <li
              v-for="tab in tabs.tabs"
              :key="tab.i"
            >
              <div
                class="inner"
                :class="{
                  'active': tab.i === tabs.currentGiantTabI.value
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
        v-for="tab in tabs.tabs"
        :key="tab.i"
        class="-pane"
        :class="{
          '-current': tab.i === tabs.currentGiantTabI.value,
        }"
      >
        <div
          v-if="tab.type === 'content'"
          class="content-tabs"
          :class="{
            '-mobile-accordion': false,
            '-single-tab': tabs.length === 1,
          }"
        >
          <h2
            v-if="heading"
            class="font-lgr"
            v-html="heading"
          />
          <div
            v-if="tab.smlTabs.length > 1"
            :ref="el => tabs.giantTabsHeadEl.value = el"
            class="-head-nav center-frame"
          >
            <div
              v-for="smlTab in tab.smlTabs"
              :key="smlTab.i"
              class="-button"
            >
              <a
                v-if="'type' in smlTab && smlTab.type === 'link'"
                :href="smlTab.href"
                class="button white"
                v-html="smlTab.title"
              />
              <button
                v-else
                :class="{
                  'active': smlTab.i === tab.currentSmlTabI.value,
                }"
                type="button"
                class="button white"
                @click="tab.setSmlTabIFromClick(smlTab.i)"
                v-html="smlTab.title"
              />
            </div>
          </div>
          <div
            class="-content-window"
            :style="`--desktopTabContentHeight: ${tab.subTabContentHeight.value}px`"
          >
            <div
              v-for="smlTab in tab.smlTabs"
              :key="i"
              :ref="el => smlTab.contentEl.value = el"
              class="-slot-outer"
              :class="{
                '-left': smlTab.i < tab.currentSmlTabI.value,
                '-right': smlTab.i > tab.currentSmlTabI.value,
                '-current': smlTab.i === tab.currentSmlTabI.value,
              }"
            >
              <div class="-tab-content">
                <div class="-height">
                  <slot
                    :name="`tab-${tab.i}-smltab-${smlTab.i}`"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <OrderResources
          v-if="tab.type === 'resources'"
          :resources="tab.resources"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import useGiantTabsOverSml from '#/useGiantTabsOverSml.js'
import OrderResources from '~/contact-forms/OrderResources.vue'

const props = defineProps({
  tabsData: {
    type: Array,
    required: true,
  },
})

const { GiantTabsOverSml } = useGiantTabsOverSml()

const tabs = new GiantTabsOverSml(props.tabsData)

const rootEl = ref(null)

onMounted(() => {
  const hash = window.location.hash
  const slug = hash.length > 1 ? hash.substring(1) : null
  if (typeof slug === 'string') {
    let scrollMargin = null
    if (slug in tabs.giantTabsBySlug) {
      tabs.setCurrentSlug(slug, true)
      scrollMargin = -150
    } else if (slug in tabs.smlTabsBySlug) {
      const smlTab = tabs.smlTabsBySlug[slug]
      tabs.setCurrentFromClick(smlTab.master.slug)
      smlTab.master.setSmlTabIFromClick(smlTab.i)
      scrollMargin = 100
    }
    if (scrollMargin !== null) {
      setTimeout(() => {
        const y = rootEl.value.getBoundingClientRect().y + window.scrollY
        window.scrollTo({ top: y + scrollMargin, behavior: 'smooth' })
      }, 500)
    }
  }
  setTimeout(() => {
    tabs.tabs.filter(tab => tab.type === 'content').forEach(tab => {
      tab.setContentHeight()
    })
  }, 500)
})

</script>