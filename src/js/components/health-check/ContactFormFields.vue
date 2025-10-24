<template>
  <div
    class="contact-form-fields"
  >
    <div class="-grid">
      <div class="-field">
        <label for="send-contact-first-name">{{ fields.first_name.label }}</label>
        <ComponentField
          :field="fields.first_name"
        />
      </div>
      <div class="-field">
        <label for="send-contact-last-name">{{ fields.last_name.label }}</label>
        <ComponentField
          :field="fields.last_name"
        />
      </div>
      <div class="-field">
        <label for="send-contact-email">{{ fields.email.label }}</label>
        <ComponentField
          :field="fields.email"
        />
      </div>
      <div class="-field">
        <label for="send-contact-phone">{{ fields.phone.label }}</label>
        <ComponentField
          :field="fields.phone"
        />
      </div>
      <div class="-field">
        <label for="send-contact-postcode">{{ fields.postcode.label }}</label>
        <ComponentField
          :field="fields.postcode"
        />
      </div>
      <div class="-field">
        <label for="send-contact-via">{{ fields.heard_about_via.label }}</label>
        <ComponentField
          :field="fields.heard_about_via"
        />
      </div>
      <div
        v-if="'speaks_english' in fields"
        class="-field -radios -span-full"
      >
        <p>{{ fields.speaks_english.label }}</p>
        <ComponentField
          :field="fields.speaks_english"
        />
      </div>
      <FieldCheckbox
        :field="fields.consent"
        class="-span-full"
      />
    </div>
  </div>
</template>
<script setup>
import useHealthCheck from '#/useHealthCheck.js'
import FieldCheckbox from '~/form-fields/FieldCheckbox.vue'
import ComponentField from '~/form-fields/ComponentField.vue'

const props = defineProps({
  fields: {
    type: Object,
    required: true,
  },
})

const {
  currentOpenHealthCheck,
  langData,
} = useHealthCheck()

// const fields = computed(() => {
//   return langData[currentOpenHealthCheck.value.lang].translations.contact.fields
// })

// const changeHeardAbout = (val) => {
//   props.models.heard_about_via.val = val
// }




</script>