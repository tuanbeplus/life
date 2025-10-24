<template>
  <div
    class="contact-form-fields"
  >
    <div class="-grid">
      <div class="-field">
        <label v-html="contactForm.fields.first_name.label" />
        <ComponentField
          :field="contactForm.fields.first_name"
        />
      </div>
      <div class="-field">
        <label v-html="contactForm.fields.last_name.label" />
        <ComponentField
          :field="contactForm.fields.last_name"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.gender.label" />
        <ComponentField
          :field="contactForm.fields.gender"
        />
      </div>
      <div class="-field">
        <label v-html="contactForm.fields.address.label" />
        <ComponentField
          :field="contactForm.fields.address"
        />
      </div>
      <div class="-field">
        <label v-html="contactForm.fields.suburb.label" />
        <ComponentField
          :field="contactForm.fields.suburb"
        />
      </div>
      <div class="-field">
        <label v-html="contactForm.fields.state.label" />
        <ComponentField
          :field="contactForm.fields.state"
        />
      </div>
      <div class="-field">
        <label v-html="contactForm.fields.postcode.label" />
        <ComponentField
          :field="contactForm.fields.postcode"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.postal_as_above.label" />
        <ComponentField
          :field="contactForm.fields.postal_as_above"
        />
      </div>
      <div
        v-if="contactForm.fields.postal_as_above.val !== 'Yes'"
        class="-field -span-full"
      >
        <label v-html="contactForm.fields.postal_address.label" />
        <ComponentField
          :field="contactForm.fields.postal_address"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.email.label" />
        <ComponentField
          :field="contactForm.fields.email"
        />
      </div>
      <div class="-field">
        <label v-html="contactForm.fields.mobile.label" />
        <ComponentField
          :field="contactForm.fields.mobile"
        />
      </div>
      <div class="-field">
        <label v-html="contactForm.fields.phone.label" />
        <ComponentField
          :field="contactForm.fields.phone"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.contact_method.label" />
        <ComponentField
          :field="contactForm.fields.contact_method"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.qualification.label" />
        <ComponentField
          :field="contactForm.fields.qualification"
        />
      </div>
      <div
        v-if="contactForm.fields.qualification.val === 'Other'"
        class="-field -span-full"
      >
        <label v-html="contactForm.fields.other_qualification.label" />
        <ComponentField
          :field="contactForm.fields.other_qualification"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.professional_accreditation.label" />
        <ComponentField
          :field="contactForm.fields.professional_accreditation"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.work_experience.label" />
        <ComponentField
          :field="contactForm.fields.work_experience"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.facilitation_experience.label" />
        <ComponentField
          :field="contactForm.fields.facilitation_experience"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.cultural_experience.label" />
        <ComponentField
          :field="contactForm.fields.cultural_experience"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.langauges_other_than_en.label" />
        <ComponentField
          :field="contactForm.fields.langauges_other_than_en"
        />
      </div>
      <div
        v-if="contactForm.fields.langauges_other_than_en.val === 'Yes'"
        class="-field -span-full"
      >
        <label v-html="contactForm.fields.languages.label" />
        <ComponentField
          :field="contactForm.fields.languages"
        />
      </div>
      <div
        v-if="contactForm.fields.langauges_other_than_en.val === 'Yes'"
        class="-field -span-full"
      >
        <label v-html="contactForm.fields.deliver_cald_q.label" />
        <ComponentField
          :field="contactForm.fields.deliver_cald_q"
        />
      </div>
      <div
        v-if="contactForm.fields.deliver_cald_q.val === 'Yes'"
        class="-field -span-full"
      >
        <label v-html="contactForm.fields.deliver_cald.label" />
        <ComponentField
          :field="contactForm.fields.deliver_cald"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.computer_access.label" />
        <ComponentField
          :field="contactForm.fields.computer_access"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.internet_access.label" />
        <ComponentField
          :field="contactForm.fields.internet_access"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.org_name.label" />
        <ComponentField
          :field="contactForm.fields.org_name"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.existing_provider.label" />
        <ComponentField
          :field="contactForm.fields.existing_provider"
        />
      </div>
      <div class="-field -span-full">
        <label v-html="contactForm.fields.comments.label" />
        <ComponentField
          :field="contactForm.fields.comments"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import ComponentField from '~/form-fields/ComponentField.vue'

const props = defineProps({
  contactForm: {
    type: Object,
    required: true,
  },
})






</script>