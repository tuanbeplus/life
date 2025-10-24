<template>
  <dialog
    :ref="el => modal.el.value = el"
    class="modal-wrap"
    :class="{ '-open': modal.isOpen.value }"
    @click="modal.close()"
  >
    <div
      class="-modal-window"
      @click.stop
    >
      <div class="-content">
        <slot />
      </div>
      <div
        class="-close"
        @click="modal.close()"
      >
        <SvgIconTimes />
      </div>
    </div>
  </dialog>
</template>
<script setup>
import { onMounted } from 'vue'
import SvgIconTimes from '~/svg/ui/IconTimes.vue'
import dialogPolyfill from 'dialog-polyfill'

const props = defineProps({
  modal: {
    type: Object,
    required: true,
  },
})

onMounted(() => {
  dialogPolyfill.registerDialog(props.modal.el.value)
})




</script>