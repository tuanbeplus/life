<template>
  <a
    href="#"
    @click.prevent="modal.open()"
    v-html="buttonText"
  />
</template>
<script setup>
import useContactFormPcos from '#/useContactFormPcos.js'

const props = defineProps({
  buttonText: {
    type: String,
    required: true,
  },
})

const {
  modal,
} = useContactFormPcos()



</script>