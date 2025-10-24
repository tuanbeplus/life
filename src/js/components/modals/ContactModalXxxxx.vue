<template>
  <ModalWrap
    class="contact-modal-xxxx"
    :modal="modal"
  >
    <div
      class="modal -contact-xxxx"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2>Request a Xxxx Session</h2>
          <form
            action="/"
            method="post"
            novalidate
            @submit.prevent="submitContactForm"
          >
            <ContactFormFieldsXxxxx
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
import ContactFormFieldsXxxxx from '~/contact-forms/ContactFormFieldsXxxxx.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormXxxxx from '#/useContactFormXxxxx.js'
import useModal from '#/useModal.js'



const { ContactFormXxxxx } = useContactFormXxxxx()
const contactForm = reactive(new ContactFormXxxxx())


const { Modal } = useModal()
const modal = new Modal()


const submitContactForm = () => {
  contactForm.validateAndPost()
}



onMounted(() => {
  modal.registerUrlHash('XXX')
})



</script>