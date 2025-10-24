<template>
  <div
    ref="rootEl"
    class="sml-tabs-over-giant content-tabs"
    :class="{
      '-mobile-accordion': mobileAccordion,
      '-single-tab': tabs.length === 1,
    }"
  >
    <h2
      v-if="heading"
      class="font-lgr"
      v-html="heading"
    />
    <div
      v-if="tabs.length > 1"
      class="-head-nav"
    >
      <div
        v-for="(tab, i) in smlTabsOverGiant.tabs"
        :key="i"
        class="-button"
      >
        <a
          v-if="'type' in tab && tab.type === 'link'"
          :href="tab.href"
          class="button white"
          v-html="tab.title"
        />
        <button
          v-else
          :class="{
            'active': i === smlTabsOverGiant.currentI.value,
          }"
          type="button"
          class="button white"
          @click="setIFromClick(i)"
          v-html="tab.title"
        />
      </div>
    </div>
    <div
      class="-content-window"
      :style="`--desktopTabContentHeight: ${smlTabsOverGiant.smlTabContentHeight.value}px`"
    >
      <div
        v-for="(smlTab, i) in smlTabsOverGiant.tabs"
        :key="i"
        :ref="el => smlTab.slotOuterEl.value = el"
        class="-slot-outer"
        :class="{
          '-left': i < smlTabsOverGiant.currentI.value,
          '-right': i > smlTabsOverGiant.currentI.value,
          '-current': i === smlTabsOverGiant.currentI.value,
        }"
      >
        <div class="-tab-content">
          <a
            v-if="mobileAccordion && 'type' in smlTab && smlTab.type === 'link'"
            class="-mobile-accordion-head"
            :href="smlTab.href"
          >
            <span>{{ smlTab.title }}</span>
          </a>
          <div
            v-else-if="mobileAccordion"
            class="-mobile-accordion-head"
            @click="toggleFromClick(i)"
          >
            <span>{{ smlTab.title }}</span>
          </div>
          <div
            v-if="smlTab.type === 'flows'"
            class="-height"
          >
            <div class="inner-giant-tabs">
              <slot
                :name="`tab-${i}-intro`"
              />
              <div class="giant-tabs">
                <ul>
                  <GiantButton
                    :sml-tab="smlTab"
                    :flow-i="0"
                  >
                    <slot :name="`tab-${i}-flow-0-tab`" />
                  </GiantButton>
                  <li class="-separator">
                    OR
                  </li>
                  <GiantButton
                    :sml-tab="smlTab"
                    :flow-i="1"
                  >
                    <slot :name="`tab-${i}-flow-1-tab`" />
                  </GiantButton>
                </ul>
              </div>
              <div
                class="-content-port"
                :style="`--desktopGiantTabContentHeight: ${smlTab.giantTabContentHeight.value}px`"
              >
                <div
                  v-for="(flow, flowI) in smlTab.flows"
                  :key="flowI"
                  class="-slot"
                  :class="{
                    '-current': flowI === smlTab.flowShowing.value,
                  }"
                >
                  <div
                    :ref="el => flow.pathwayEl.value = el"
                    class="pathway"
                  >
                    <PathwayStep
                      v-for="(step, stepI) in flow.steps"
                      :key="stepI"
                      :step="step"
                    >
                      <slot :name="`tab-${i}-flow-${flowI}-step-${stepI}`" />
                    </PathwayStep>
                    <slot :name="`tab-${i}-flow-${flowI}-outro`" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            v-else
            class="-height"
          >
            <slot
              :name="`tab-${i}`"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import GiantButton from './SmlTabsOverGiant/GiantButton.vue'
import PathwayStep from './SmlTabsOverGiant/PathwayStep.vue'
import useSmlTabsOverGiant from '#/useSmlTabsOverGiant.js'

const props = defineProps({
  tabs: {
    type: Array,
    required: true,
  },
  mobileAccordion: {
    type: Boolean,
    default: false,
  },
})

const { SmlTabsOverGiant } = useSmlTabsOverGiant()
const smlTabsOverGiant = new SmlTabsOverGiant(props.tabs)



const rootEl = ref(null)


const _setI = (i) => {
  if (i === smlTabsOverGiant.currentI.value) return
  smlTabsOverGiant.currentI.value = i
  smlTabsOverGiant.setTabContentHeight()
}

const setIFromSlug = (slug, autoScroll) => {
  if (!slug) return
  const i = props.tabs.findIndex(s => s.slug === slug)
  if (i !== -1) {
    _setI(i)
  } else if (slug in smlTabsOverGiant.flowsBySlug) {
    const flow = smlTabsOverGiant.flowsBySlug[slug]
    const tab = flow.master
    _setI(tab.i)
    tab.setFlowShowing(flow.i)
  }
  
  if (autoScroll) {
    setTimeout(() => {
      const y = rootEl.value.getBoundingClientRect().y + window.scrollY
      window.scrollTo({ top: y - 200, behavior: 'smooth' })
    }, 500)
  }
}
const setIFromClick = (i) => {
  smlTabsOverGiant.startHashChangePreventTimer()
  _setI(i)
  setTimeout(() => {
    window.location.hash = props.tabs[i].slug
  }, 200)
}
const toggleFromClick = (i) => {
  smlTabsOverGiant.startHashChangePreventTimer()
  if (i === smlTabsOverGiant.currentI.value) {
    _setI(null)
    window.location.hash = ''
  } else {
    _setI(i)
    setTimeout(() => {
      window.location.hash = props.tabs[i].slug
    }, 200)
  }
}



onMounted(() => {
  const hash = window.location.hash
  const slug = hash.length > 1 ? hash.substring(1) : null
  setIFromSlug(slug, true)

  setTimeout(() => {
    smlTabsOverGiant.setTabContentHeight()
    smlTabsOverGiant.tabsWithFlows.forEach(tab => {
      tab.setContentHeight()
    })
  }, 100)
  addEventListener('hashchange', (event) => {
    const split = event.newURL.split('#')
    const slug = split.length > 1 ? split[1] : null
    if (smlTabsOverGiant.hashchangePreventTimer === null) {
      if (slug.indexOf('health-check') === -1) {
        setIFromSlug(slug, true)
      }
    }
  });
  
  let resizeTimeout = null
  addEventListener('resize', () => {
    if (resizeTimeout !== null) {
      clearTimeout(resizeTimeout)
    }
    resizeTimeout = setTimeout(() => {
      smlTabsOverGiant.setTabContentHeight()
      smlTabsOverGiant.tabsWithFlows.forEach(tab => {
        tab.setContentHeight()
      })
    }, 100)
  })
})


</script>