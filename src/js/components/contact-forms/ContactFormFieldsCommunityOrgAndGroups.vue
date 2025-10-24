<template>
  <div
    class="contact-form-fields"
  >
    <div class="-grid -hide-placeholders">
      <FieldAndLabel
        class="-span-full"
        :field="f.Company"
      />

      <h4>
        Please enter your community organisation address below:
      </h4>
      <FieldAndLabel
        class="-span-full"
        :field="f.Street"
      />
      <FieldAndLabel
        :field="f.City"
      />
      <FieldAndLabel
        :field="f.PostalCode"
      />
      <div class="-spacer" />

      <FieldAndLabel
        class="-span-full"
        :field="f.FirstName"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.LastName"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.How_did_you_hear_about_the_Life_program__c"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.Phone"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.Email"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.Healthy_Living_Session_delivery_method__c"
      />
      <FieldAndLabel
        v-if="hasFaceToFace"
        class="-span-full"
        :field="f.NO_POST_session_at_org_address"
        @change="change_NO_POST_session_at_org_address"
      />
      <h4
        v-if="hasFaceToFace"
      >
        Address of where session will be delivered
      </h4>
      <FieldAndLabel
        v-if="hasFaceToFace"
        class="-span-full"
        :field="f.StreetAddress__c"
      />
      <FieldAndLabel
        v-if="hasFaceToFace"
        :field="f.Suburb__c"
      />
      <FieldAndLabel
        v-if="hasFaceToFace"
        :field="f.Postcode__c"
      />
      <FieldAndLabel
        v-if="hasFaceToFace"
        class="-span-full"
        :field="f.Do_you_have_a_projector_screen__c"
      />
      <h4>Please provide two possible dates and times for a session to be delivered (3 weeks from the date you are submitting this form)</h4>
      <FieldAndLabel
        :field="f.First_preferred_session_date_time_HLS__c"
      />
      <FieldAndLabel
        :field="f.Second_preferred_session_date_time_HLS__c"
      />
      <div class="-spacer" />
      <FieldAndLabel
        :field="f.Preferred_languages_HLS__c"
      />
      <FieldAndLabel
        :field="f.Number_of_participants__c"
      />
      <div class="-spacer" />
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import FieldAndLabel from '~/form-fields/FieldAndLabel.vue'

const props = defineProps({
  contactForm: {
    type: Object,
    required: true,
  },
})

const f = computed(() => props.contactForm.fields)
const hasFaceToFace = computed(() => ['Face to face', 'Either'].includes(props.contactForm.fields.Healthy_Living_Session_delivery_method__c.val))

const change_NO_POST_session_at_org_address = (value) => {
  if (value === 'Yes') {
    props.contactForm.fields.StreetAddress__c.val = props.contactForm.fields.Street.val
    props.contactForm.fields.Suburb__c.val = props.contactForm.fields.City.val
    props.contactForm.fields.Postcode__c.val = props.contactForm.fields.PostalCode.val
  } else {
    props.contactForm.fields.StreetAddress__c.val = ''
    props.contactForm.fields.Suburb__c.val = ''
    props.contactForm.fields.Postcode__c.val = ''
  }
}

</script>