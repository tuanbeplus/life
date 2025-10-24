<template>
  <ModalWrap
    class="contact-modal-facilitator-eoi"
    :modal="modal"
  >
    <div
      class="modal -contact-facilitator-eoi"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2>Deliver the <em>Life!</em> program</h2>
          <form
            action="/"
            method="post"
            novalidate
            @submit.prevent="submitContactForm"
          >
            <ContactFormFieldsFacilitatorEoi
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
import ContactFormFieldsFacilitatorEoi from '~/contact-forms/ContactFormFieldsFacilitatorEoi.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormFacilitatorEoi from '#/useContactFormFacilitatorEoi.js'
import useModal from '#/useModal.js'



const { ContactFormFacilitatorEoi } = useContactFormFacilitatorEoi()
const contactForm = reactive(new ContactFormFacilitatorEoi())


const { Modal } = useModal()
const modal = new Modal()


const submitContactForm = () => {
  contactForm.validateAndPost()
}



onMounted(() => {
  modal.registerUrlHash('facilitator-eoi')
})



</script>