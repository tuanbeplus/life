import { ref } from 'vue'


const mobileNavIsOpen = ref(false)

export default () => {
  return {
    mobileNavIsOpen,
  }
}