<template>
  <ModalWrap
    class="contact-modal-provider-signup-eoi"
    :modal="modal"
  >
    <div
      class="modal -contact-provider-signup-eoi"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2>Become a <em>Life!</em> Program Provider</h2>
          <form
            action="/"
            method="post"
            novalidate
            @submit.prevent="submitContactForm"
          >
            <ContactFormFieldsProviderSignupEoi
              :contact-form="contactForm"
            />
            <ContactFormActionsAndFeedback
              :contact-form="contactForm"
              submit-button-text="Submit Enquiry"
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
import ContactFormFieldsProviderSignupEoi from '~/contact-forms/ContactFormFieldsProviderSignupEoi.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormProviderSignupEoi from '#/useContactFormProviderSignupEoi.js'
import useModal from '#/useModal.js'



const { ContactFormProviderSignupEoi } = useContactFormProviderSignupEoi()
const contactForm = reactive(new ContactFormProviderSignupEoi())


const { Modal } = useModal()
const modal = new Modal()


const submitContactForm = () => {
  contactForm.validateAndPost()
}



onMounted(() => {
  modal.registerUrlHash('provider-eoi')
})



</script>