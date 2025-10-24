<template>
  <ModalWrap
    class="contact-modal-gestational"
    :modal="modal"
  >
    <div
      class="modal -contact-gestational"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2 v-html="contactForm.data.modalHeading" />
          <h3
            v-if="lang === 'en'"
            class="font-middling wt-sb lh-tight"
          >
            Submit your details and we will get back to you shortly.
          </h3>
          <form
            action="/"
            method="post"
            novalidate
            @submit.prevent="submitContactForm"
          >
            <ContactFormFieldsGestational
              :contact-form="contactForm"
            />
            <ContactFormActionsAndFeedback
              :contact-form="contactForm"
              :submit-button-text="contactForm.data.submitButtonText"
              :return-to-site-button-text="contactForm.data.returnToSiteButtonText"
            />
          </form>
        </div>
      </div>
    </div>
  </ModalWrap>
</template>
<script setup>
import { reactive, onMounted } from 'vue'
import ModalWrap from '~/widget/ModalWrap.vue'
import ContactFormFieldsGestational from '~/contact-forms/ContactFormFieldsGestational.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormGestational from '#/useContactFormGestational.js'


const props = defineProps({
  lang: {
    type: String,
    required: true,
  },
})


const { ContactFormGestational, modal } = useContactFormGestational()
const contactForm = reactive(new ContactFormGestational(props.lang))



const submitContactForm = () => {
  contactForm.validateAndPost()
}


onMounted(() => {
  modal.registerUrlHash('gdm-form-modal')
})




</script>