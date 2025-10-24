import { ref } from 'vue'

class FlowStep {
  constructor(i) {
    this.i = i
    this.isShowing = ref(false)
    this.inView = ref(null)
  }
  reset() {
    if (!this.inView.value) {
      this.isShowing.value = false
    }
  }
}

class Flow {
  constructor(flow, i, master) {
    this.i = i
    this.master = master
    this.slug = flow.slug
    this.pathwayEl = ref(null)
    this.steps = []
    for (let i = 0; i < flow.num_of_steps; i++) {
      this.steps.push(new FlowStep(i))
    }
  }
  resetSteps() {
    this.steps.forEach(step => step.reset())
  }
}

class SmlTab {
  constructor(data, i, master) {
    this.i = i
    this.master = master
    for (const key in data) {
      this[key] = data[key]
    }
    this.isFlows = (this.type === 'flows')
    this.slotOuterEl = ref(null)
    
    /* for this.type === 'flows': */
    this.flows = []
    this.flowShowing = ref(null)
    this.giantTabContentHeight = ref(3000)
    if (this.isFlows) {
      this.flows_steps.forEach((flow, i) => this.flows.push(new Flow(flow, i, this)))
      // if (this.flows.length > 0) {
      //   this.flowShowing.value = 0
      // }
    }
  }
  setContentHeight() {
    if (this.flowShowing.value === null) {
      this.giantTabContentHeight.value = 5
    } else {
      this.giantTabContentHeight.value = this.flows[this.flowShowing.value].pathwayEl.value.clientHeight + 5
    }
    setTimeout(() => {
      this.master.setTabContentHeight()
    }, 500)
  }
  setFlowShowing(flowI) {
    if (this.flowShowing.value !== flowI) {
      this.flows.forEach(flow => flow.resetSteps())
      this.flowShowing.value = flowI
      this.setContentHeight()
      this.master.startHashChangePreventTimer()
      setTimeout(() => {
        this.master.setTabContentHeight()
        window.location.hash = this.flows[flowI].slug
      }, 200)
    }
  }
}


class SmlTabsOverGiant {
  constructor(tabs) {
    this.tabs = []
    tabs.forEach((tabData, i) => {
      this.tabs.push(new SmlTab(tabData, i, this))
    })
    this.currentI = ref(0)
    this.slotOuter = ref([])
    this.smlTabContentHeight = ref(0)
    this.tabsWithFlows = []
    this.flowsBySlug = this.findInternalSlugs()
    this.hashchangePreventTimer = null
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
  findInternalSlugs() {
    const index = {}
    this.tabs.forEach((tab, i) => {
      if (tab.isFlows) {
        this.tabsWithFlows.push(tab)
        tab.flows.forEach((flow, j) => {
          if (flow.slug) {
            index[flow.slug] = flow
          }
        })
      }
    })
    return index
  }
  setTabContentHeight() {
    this.smlTabContentHeight.value = this.tabs[this.currentI.value].slotOuterEl.value.clientHeight + 1
  }
}




export default () => ({
  SmlTabsOverGiant,
})