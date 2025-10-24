import { slugify } from '#/useHelpers.js'
import { ref } from 'vue'

class TabTab {
  constructor(d, i) {
    this.i = i
    this.slug = slugify(d.heading)
    this.heading = d.heading
    this.description = d.description
    this.type = d.type
    this.resources = 'resources' in d ? d.resources : null
    console.log('tabtab', this)
  }
}

class ContentTabsTabs {
  constructor(tabsData) {
    this.tabs = []
    tabsData.forEach((tabData, i) => {
      this.tabs.push(new TabTab(tabData, i))
    })
    this.current = ref(this.tabs.length ? this.tabs[0].slug : null)
    // console.log('current', this.current)
  }
  setCurrentSlug(slug) {
    this.current.value = slug
  }
  setCurrentFromClick(slug) {
    this.setCurrentSlug(slug)
    window.location.hash = slug
  }
}




export default () => ({
  ContentTabsTabs,
})