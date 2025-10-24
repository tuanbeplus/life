<template>
  <div
    class="contact-form-fields"
  >
    <div class="-grid">
      <FieldAndLabel
        :field="f.first_name"
      />
      <FieldAndLabel
        :field="f.last_name"
      />
      <FieldAndLabel
        :field="f.phone"
      />
      <FieldAndLabel
        :field="f.email"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.living_with_pcos"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.heard_about_via"
      />
      <FieldCheckbox
        class="-span-full"
        :field="f.consent"
      />
      <FieldCheckbox
        class="-span-full"
        :field="f.consent_pcos"
      />
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import FieldAndLabel from '~/form-fields/FieldAndLabel.vue'
import FieldCheckbox from '~/form-fields/FieldCheckbox.vue'

const props = defineProps({
  contactForm: {
    type: Object,
    required: true,
  },
})

const f = computed(() => props.contactForm.fields)



</script>