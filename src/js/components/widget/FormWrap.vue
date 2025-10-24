<template>
  <div
    ref="formWrapEl"
    class="form-wrap"
  >
    <slot />
  </div>
</template>
<script setup>
import { onMounted, ref } from 'vue'


const formWrapEl = ref(null)


onMounted(() => {
  const form = formWrapEl.value.querySelector('form')
  if (form) {
    console.log('form', form)
    form.addEventListener('submit', (e) => {
      console.log('submit yo')
      e.preventDefault()
    })
  }
})

</script>