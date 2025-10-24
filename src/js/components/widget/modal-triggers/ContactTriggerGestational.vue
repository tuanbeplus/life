<template>
  <a
    href="#"
    @click.prevent="modal.open()"
    v-html="buttonText"
  />
</template>
<script setup>
import useContactFormGestational from '#/useContactFormGestational.js'

const props = defineProps({
  buttonText: {
    type: String,
    required: true,
  },
})

const {
  modal,
} = useContactFormGestational()



</script>