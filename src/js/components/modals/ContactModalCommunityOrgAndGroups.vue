<template>
  <ModalWrap
    class="contact-modal-community-org-and-groups"
    :modal="modal"
  >
    <div
      class="modal -contact-community-org-and-groups"
    >
      <div class="-expanding">
        <div class="-padded">
          <h2>Request a Community Session</h2>
          <form
            action="/"
            method="post"
            novalidate
            @submit.prevent="submitContactForm"
          >
            <ContactFormFieldsCommunityOrgAndGroups
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
import ContactFormFieldsCommunityOrgAndGroups from '~/contact-forms/ContactFormFieldsCommunityOrgAndGroups.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useContactFormCommunityOrgAndGroups from '#/useContactFormCommunityOrgAndGroups.js'
import useModal from '#/useModal.js'



const { ContactFormCommunityOrgAndGroups } = useContactFormCommunityOrgAndGroups()
const contactForm = reactive(new ContactFormCommunityOrgAndGroups())


const { Modal } = useModal()
const modal = new Modal()


const submitContactForm = () => {
  contactForm.validateAndPost()
}



onMounted(() => {
  modal.registerUrlHash('community-request')
})



</script>