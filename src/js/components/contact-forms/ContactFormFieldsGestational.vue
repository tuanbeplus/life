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
        :field="f.email"
      />
      <FieldAndLabel
        :field="f.phone"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.currently_gdm"
      />
      <FieldAndLabel
        v-if="f.currently_gdm.val === 'Yes'"
        class="-span-full"
        :field="f.due_date"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.heard_about_via"
      />
      <FieldAndLabel
        v-if="'Do_you_need_an_interpreter__c' in f"
        class="-span-full"
        :field="f.Do_you_need_an_interpreter__c"
      />
      <FieldCheckbox
        v-if="'Vietnamese_woman__c' in f"
        class="-span-full"
        :field="f.Vietnamese_woman__c"
      />
      <FieldAndLabel
        v-if="'Program_to_be_deliver_Vietnamese__c' in f"
        class="-span-full"
        :field="f.Program_to_be_deliver_Vietnamese__c"
      />
      <FieldCheckbox
        class="-span-full"
        :field="f.consent"
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

const f = computed(() => {
  if (!props.contactForm || !props.contactForm.fields) {
    console.error('ContactFormFieldsGestational: contactForm.fields is undefined', props.contactForm)
    return {}
  }
  return props.contactForm.fields
})



</script>