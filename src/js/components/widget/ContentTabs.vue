<template>
  <div
    ref="rootEl"
    class="content-tabs"
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
      ref="navEl"
      class="-head-nav"
    >
      <div
        v-for="(tab, i) in tabs"
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
            'active': i === currentI,
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
      :style="`--desktopTabContentHeight: ${tabContentHeight}px`"
    >
      <div
        v-for="(tab, i) in tabs"
        :key="i"
        ref="slotOuter"
        class="-slot-outer"
        :class="{
          '-left': i < currentI,
          '-right': i > currentI,
          '-current': i === currentI,
        }"
      >
        <div class="-tab-content">
          <div class="-height">
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

const props = defineProps({
  tabs: {
    type: Array,
    required: true,
  },
  updateHeightEvent: {
    type: Object,
    default: null,
  },
  mobileAccordion: {
    type: Boolean,
    default: false,
  },
  heading: {
    type: String,
    default: null,
  },
})
const emit = defineEmits(['tabchange'])


const currentI = ref(0)
const slotOuter = ref([])
const tabContentHeight = ref(0)
const rootEl = ref(null)
const navEl = ref(null)

let hashchangePreventTimer = null
const startHashChangePreventTimer = () => {
  if (hashchangePreventTimer !== null) {
    clearTimeout(hashchangePreventTimer)
  }
  hashchangePreventTimer = setTimeout(() => {
    clearTimeout(hashchangePreventTimer)
    hashchangePreventTimer = null
  }, 200)
}

const setTabContentHeight = () => {
  setTimeout(() => {
    tabContentHeight.value = slotOuter.value[currentI.value].clientHeight + 1
  }, 500)
}

const _setI = (i) => {
  if (i === currentI.value) return
  currentI.value = i
  setTabContentHeight()
  window.location.hash = props.tabs[i].slug
  emit('tabchange', i)
}

const setIFromSlug = (slug, autoScroll) => {
  if (slug === null) return
  const i = props.tabs.findIndex(s => s.slug === slug)
  if (i !== -1) {
    _setI(i)
  } else {
  }
  if (autoScroll) {
    setTimeout(() => {
      rootEl.value.scrollIntoView({ behavior: 'smooth' });
    }, 500)
  }
}
const setIFromClick = (i) => {
  startHashChangePreventTimer()
  _setI(i)
}


onMounted(() => {
  const hash = window.location.hash
  const slug = hash.length > 1 ? hash.substring(1) : null
  setIFromSlug(slug, true)

  setTimeout(setTabContentHeight, 100)
  setTimeout(setTabContentHeight, 500)
  if (props.updateHeightEvent !== null) {
    props.updateHeightEvent.on('update', e => {
      tabContentHeight.value += 500
      setTimeout(() => {
        setTabContentHeight()
      }, 1000)
    })
  }

  addEventListener('hashchange', (event) => {
    const split = event.newURL.split('#')
    const slug = split.length > 1 ? split[1] : null
    if (hashchangePreventTimer === null) {
      if (slug.indexOf('health-check') === -1) {
        // console.log('hashchange not preventTimer')
        setIFromSlug(slug, true)
      } else {
        // console.log('health-check fragment')
      }
    }
  });
})



window.addEventListener('resize', setTabContentHeight)

</script>