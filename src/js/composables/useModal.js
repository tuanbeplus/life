import { ref } from 'vue'
import useUtils from '#/useUtils.js'

const { eListen } = useUtils()

const currentOpenModal = ref(null)

class Modal {
  constructor(emitter = null) {
    this.isOpen = ref(false)
    this.el = ref(null)
    this.emitter = emitter
  }
  open() {
    this.isOpen.value = true
    if (this.el.value === null) {
      console.error('Modal.el is null. Is the modal in the page?')
      return
    }
    this.el.value.showModal()
  }
  close() {
    history.pushState('', document.title, window.location.pathname + window.location.search)
    this.isOpen.value = false
    setTimeout(() => {
      this.el.value.close()
    }, 400)
    if (this.emitter) {
      this.emitter.emit('close-modal')
    }
  }
  registerUrlHash(frag) {
    eListen({
      selector: `a[href$="#${frag}"]`,
      callback: e => {
        e.preventDefault()
        window.location.hash = `#${frag}`
        this.open()
      },
    })
    if (window.location.hash === `#${frag}`) {
      this.open()
    }
  }
}

export default () => {
  return {
    currentOpenModal, /* needed? */
    Modal,
  }
}