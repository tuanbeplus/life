<template>
  <ModalWrap
    class="contact-modal-pcos"
    :modal="modal"
  >
    <div
      class="modal -contact-pcos"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2>Register for the <em>Life!</em> program</h2>
          <h3
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
            <ContactFormFieldsPcos
              :contact-form="contactForm"
            />
            <ContactFormActionsAndFeedback
              :contact-form="contactForm"
            />
          </form>
        </div>
      </div>
    </div>
  </ModalWrap>
</template>
<script setup>
import { reactive } from 'vue'
import ModalWrap from '~/widget/ModalWrap.vue'
import ContactFormFieldsPcos from '~/contact-forms/ContactFormFieldsPcos.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormPcos from '#/useContactFormPcos.js'


const { ContactFormPcos, modal } = useContactFormPcos()
const contactForm = reactive(new ContactFormPcos())

const submitContactForm = () => {
  contactForm.validateAndPost()
}



</script>