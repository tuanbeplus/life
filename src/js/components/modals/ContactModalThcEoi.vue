<template>
  <ModalWrap
    class="contact-modal-thc-eoi"
    :modal="modal"
  >
    <div
      class="modal -contact-thc-eoi"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2>Become A <em>Life!</em> Tele-Health Coach</h2>
          <form
            action="/"
            method="post"
            novalidate
            @submit.prevent="submitContactForm"
          >
            <ContactFormFieldsThcEoi
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
import ContactFormFieldsThcEoi from '~/contact-forms/ContactFormFieldsThcEoi.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormThcEoi from '#/useContactFormThcEoi.js'
import useModal from '#/useModal.js'



const { ContactFormThcEoi } = useContactFormThcEoi()
const contactForm = reactive(new ContactFormThcEoi())


const { Modal } = useModal()
const modal = new Modal()


const submitContactForm = () => {
  contactForm.validateAndPost()
}



onMounted(() => {
  modal.registerUrlHash('thc-eoi')
})



</script>