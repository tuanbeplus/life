<template>
  <ModalWrap
    class="contact-modal-workplaces"
    :modal="modal"
  >
    <div
      class="modal -contact-workplaces"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2>Request a Workplace Session</h2>
          <form
            action="/"
            method="post"
            novalidate
            @submit.prevent="submitContactForm"
          >
            <ContactFormFieldsWorkplaces
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
import ContactFormFieldsWorkplaces from '~/contact-forms/ContactFormFieldsWorkplaces.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormWorkplace from '#/useContactFormWorkplace.js'
import useModal from '#/useModal.js'



const { ContactFormWorkplace } = useContactFormWorkplace()
const contactForm = reactive(new ContactFormWorkplace())


const { Modal } = useModal()
const modal = new Modal()


const submitContactForm = () => {
  contactForm.validateAndPost()
}



onMounted(() => {
  modal.registerUrlHash('workplace-request')
})



</script>