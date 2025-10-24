import { ref } from 'vue'

class SmlTab {
  constructor(data, i, master) {
    this.i = i
    this.master = master
    this.contentEl = ref(null)
    for (const key in data) {
      this[key] = data[key]
    }
  }
}

class GiantTab {
  constructor(data, i, master) {
    this.i = i
    this.master = master
    for (const key in data) {
      this[key] = data[key]
    }
    
    /* for when has sml tabs: */
    this.smlTabs = []
    this.currentSmlTabI = ref(0)
    this.subTabContentHeight = ref(400)
    data._smlTabs.forEach((smlTab, i) => this.smlTabs.push(new SmlTab(smlTab, i, this)))
  }
  setContentHeight() {
    this.subTabContentHeight.value = this.smlTabs[this.currentSmlTabI.value].contentEl.value.clientHeight + 5
  }
  setSmlTabIFromClick(i) {
    this.currentSmlTabI.value = i
    this.setContentHeight()
    window.location.hash = this.smlTabs[i].slug
  }
}


class GiantTabsOverSml {
  constructor(tabs) {
    this.tabs = []
    this.giantTabsBySlug = {}
    this.smlTabsBySlug = {}
    tabs.forEach((tabData, i) => {
      const tab = new GiantTab(tabData, i, this)
      this.tabs.push(tab)
      this.giantTabsBySlug[tab.slug] = tab
      tab.smlTabs.forEach(smlTab => {
        this.smlTabsBySlug[smlTab.slug] = smlTab
      })
    })
    this.currentGiantTabI = ref(0)
    this.tabContentHeight = ref(200)
    this.hashchangePreventTimer = null
    this.giantTabsHeadEl = ref(null)
  }
  startHashChangePreventTimer() {
    // console.log('TIMER start')
    if (this.hashchangePreventTimer !== null) {
      clearTimeout(this.hashchangePreventTimer)
    }
    this.hashchangePreventTimer = setTimeout(() => {
      clearTimeout(this.hashchangePreventTimer)
      this.hashchangePreventTimer = null
      // console.log('TIMER .')
    }, 500)
  }
  setCurrentSlug(slug) {
    const giantTab = this.tabs.find(tab => tab.slug === slug)
    this.currentGiantTabI.value = giantTab.i
    window.location.hash = slug
    if (giantTab.type === 'content') {
      setTimeout(() => {
        giantTab.setContentHeight()
      }, 500)
    }
  }
  setCurrentFromClick(slug) {
    this.setCurrentSlug(slug)
  }
}




export default () => ({
  GiantTabsOverSml,
})