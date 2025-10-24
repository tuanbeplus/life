import { ref } from 'vue'

const openOverlay = ref(null)

function toggleOpenFunc(isOpen) {
  return () => {
    isOpen.value = !isOpen.value
    if (isOpen.value) {
      if (openOverlay.value !== null) {
        openOverlay.value.close()
      }
      openOverlay.value = {
        close: () => {
          isOpen.value = false
        },
      }
    } else {
      openOverlay.value = null
    }
  }
}

export default () => {
  return {
    openOverlay,
    toggleOpenFunc,
  }
}