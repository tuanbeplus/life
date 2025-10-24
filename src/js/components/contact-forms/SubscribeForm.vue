<template>
  <div class="subscribe-form">
    <form
      action="/"
      method="post"
      @submit.prevent="submitContactForm"
    >
      <div class="-fields">
        <ComponentField
          v-for="(field, fName) in contactForm.fields"
          :key="fName"
          :field="field"
        />
      </div>
      <ContactFormActionsAndFeedback
        :contact-form="contactForm"
        :submit-button-text="subscribeButtonText"
        :has-return-to-site-button="false"
      />
    </form>
  </div>
</template>
<script setup>
import { reactive } from 'vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormSubscribe from '#/useContactFormSubscribe.js'
import ComponentField from '~/form-fields/ComponentField.vue'

const props = defineProps({
  subscribeButtonText: {
    type: String,
    required: true,
  },
})

const { ContactFormSubscribe  } = useContactFormSubscribe()
const contactForm = reactive(new ContactFormSubscribe())





const submitContactForm = () => {
  contactForm.validateAndPost()
}



</script>