<template>
  <div class="content-giant-tabs">
    <slot name="intro" />
    <div class="giant-tabs">
      <ul>
        <template
          v-for="(tab, i) in tabs"
        >
          <li
            v-if="i !== 0"
            :key="`sep-${i}`"
            class="-separator"
          >
            OR
          </li>
          <li
            @click.prevent.stop="setIFromClick(i)"
          >
            <div
              class="inner"
              :class="{
                'active': i === currentI,
              }"
            >
              <h3
                v-if="tab.title"
                class="font-md wt-sb lh-std"
              >
                {{ tab.title }}
              </h3>
              <div
                class="content lh-md"
                v-html="tab.description"
              />
            </div>
          </li>
        </template>
      </ul>
    </div>
    <div
      class="-content-port"
      :style="`--desktopGiantTabContentHeight: ${tabContentHeight}px`"
    >
      <div
        v-for="(tab, i) in tabs"
        :key="i"
        ref="slotOuter"
        class="-slot"
        :class="{
          '-current': i === currentI,
        }"
      >
        <slot
          :name="`tab-${i}`"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue'

const props = defineProps({
  tabs: {
    type: Array,
    required: true,
  },
})

const slotOuter = ref([])
const tabContentHeight = ref(0)

const currentI = ref(0)


const setTabContentHeight = () => {
  setTimeout(() => {
    // console.log('ContentGiantTabs setTabContentHeight', slotOuter.value[currentI.value].clientHeight)
    tabContentHeight.value = slotOuter.value[currentI.value].clientHeight + 1
  }, 100)
}

const _setI = (i) => {
  if (i === currentI.value) return
  currentI.value = i
  setTabContentHeight()
  window.location.hash = props.tabs[i].slug
}

// const setIFromSlug = (slug, autoScroll) => {
//   if (slug === null) return
//   const i = props.tabs.findIndex(s => s.slug === slug)
//   if (i !== -1) {
//     _setI(i)
//   } else {
//   }
//   if (autoScroll) {
//     setTimeout(() => {
//       rootEl.value.scrollIntoView({ behavior: 'smooth' });
//     }, 500)
//   }
// }
const setIFromClick = (i) => {
  // startHashChangePreventTimer()
  _setI(i)
}

</script>