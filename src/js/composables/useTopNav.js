import { ref } from 'vue'


const searchIsOpen = ref(false)



export default () => {
  return {
    searchIsOpen,
  }
}