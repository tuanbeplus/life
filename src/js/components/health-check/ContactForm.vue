<template>
  <div
    class="contact-form"
  >
    <div
      :ref="el => elForResize = el"
      class="-inner"
    >
      <h2
        class="modal-heading"
        v-html="lang.intro.heading"
      />
      <h3
        class="font-middling wt-sb lh-tight lang-text-align"
        v-html="lang.intro.subheading"
      />
      <form
        action="/"
        method="post"
        novalidate
        @submit.prevent="submitContactForm"
      >
        <ContactFormFields
          :fields="currentOpenHealthCheck.contactForm.fields"
        />
        <ContactFormActionsAndFeedback
          :contact-form="currentOpenHealthCheck.contactForm"
          :submit-button-text="lang.submit_button_text"
          :return-to-site-button-text="lang.return_to_site_button_text"
          :lang-str="currentOpenHealthCheck.lang"
        />
      </form>
    </div>
  </div>
</template>
<script setup>
import { computed, onMounted, ref } from 'vue'
import ContactFormFields from './ContactFormFields.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import useHealthCheck from '#/useHealthCheck.js'


const {
  currentOpenHealthCheck,
  langData,
  expanderHeight,
} = useHealthCheck()


const lang = computed(() => {
  return langData[currentOpenHealthCheck.value.lang].translations.contact
})


const submitContactForm = () => {
  // console.log('submitContactForm', currentOpenHealthCheck.value)
  currentOpenHealthCheck.value.contactForm.validateAndPost()
}

const elForResize = ref(null)

const updateHeight = () => {
  setTimeout(() => {
    const h = elForResize.value.clientHeight + 80
    expanderHeight.value = h
  }, 1000)
}

onMounted(() => {
  updateHeight()
  window.addEventListener('resize', updateHeight)
})


</script>