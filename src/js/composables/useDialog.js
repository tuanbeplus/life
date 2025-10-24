import { ref } from 'vue'



class Dialog {
  constructor() {
    this.dialogEl = ref(null)
  }
  open() {
    this.dialogEl.value.showModal()
    this.dialogEl.value.classList.add('-open')
  }
  close() {
    this.dialogEl.value.classList.remove('-open')
    setTimeout(() => {
      this.dialogEl.value.close()
    }, 200)
  }
}


export default () => ({
  Dialog,
})

