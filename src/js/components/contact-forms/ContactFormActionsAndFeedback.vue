<template>
  <div
    class="form-feedback"
    :class="{
      '-populated': contactForm.responseMessage !== ''
    }"
  >
    <div
      v-if="contactForm.responseMessage !== ''"
      class="alert lang-text-align"
      :class="{
        success: contactForm.postSuccessful,
        error: !contactForm.postSuccessful,
      }"
    >
      <p v-html="contactForm.responseMessage" />
    </div>
  </div>
  <div
    v-if="hasReturnToSiteButton && contactForm.postSuccessful"
    class="-field close-modal lang-flex-direction-row"
  >
    <button
      type="button"
      name="submit_signup"
      class="button grey"
      aria-label="Return to site"
      @click="refreshPage"
    >
      <span>{{ returnToSiteButtonText }}</span>
    </button>
  </div>
  <div
    v-if="!contactForm.posted"
    class="-action lang-flex-direction-row"
    :class="`tracking-contact-submit-${langStr}`"
  >
    <button
      type="submit"
      name="send_enquiry"
      class="button grey loader en"
      :class="{
        '-loading': contactForm.posting
      }"
      aria-label="Submit details"
    >
      <SvgLoadingSpinner />
      <span>{{ submitButtonText }}</span>
    </button>
  </div>
</template>
<script setup>
import SvgLoadingSpinner from '~/svg/ui/LoadingSpinner.vue'


defineProps({
  contactForm: {
    type: Object,
    required: true,
  },
  submitButtonText: {
    type: String,
    default: 'Submit details',
  },
  returnToSiteButtonText: {
    type: String,
    default: 'Return to Site',
  },
  hasReturnToSiteButton: {
    type: Boolean,
    default: true,
  },
  langStr: {
    type: String,
    default: 'en',
  },
})

const refreshPage = () => {
  window.location.href = window.location.href.split('#')[0]
}


</script>