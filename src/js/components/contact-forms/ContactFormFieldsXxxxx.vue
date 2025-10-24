<template>
  <div
    class="contact-form-fields"
  >
    <div class="-grid">
      <FieldAndLabel
        class="-span-full"
        :field="f.xxxx"
      />
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import FieldAndLabel from '~/form-fields/FieldAndLabel.vue'

const props = defineProps({
  contactForm: {
    type: Object,
    required: true,
  },
})

const f = computed(() => props.contactForm.fields)



</script>