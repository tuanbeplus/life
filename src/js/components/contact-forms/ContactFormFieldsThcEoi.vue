<template>
  <div
    class="contact-form-fields"
  >
    <div class="-grid">
      <FieldAndLabel
        :field="f.first_name"
      />
      <FieldAndLabel
        :field="f.last_name"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.gender"
      />
      <FieldAndLabel
        :field="f.address"
      />
      <FieldAndLabel
        :field="f.suburb"
      />
      <FieldAndLabel
        :field="f.state"
      />
      <FieldAndLabel
        :field="f.postcode"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.postal_as_above"
      />
      <FieldAndLabel
        v-if="f.postal_as_above.val === 'No'"
        class="-span-full"
        :field="f.postal_address"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.email"
      />
      <FieldAndLabel
        :field="f.mobile"
      />
      <FieldAndLabel
        :field="f.phone"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.contact_method"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.qualification"
      />
      <FieldAndLabel
        v-if="f.qualification.val === 'Other'"
        class="-span-full"
        :field="f.other_qualification"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.professional_accreditation"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.hca_model_training"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.motivational_interviewing"
      />

      <h4 class="font-md wt-sb">
        Provider Insurance Details
      </h4>
      <FieldAndLabel
        class="-span-full"
        :field="f.pl_insurance"
      />
      <div class="supporting">
        * End Date will be the 30th June each year.
      </div>
      <FieldAndLabel
        class="-span-full"
        :field="f.pl_insurer"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.pi_insurance"
      />
      <div class="supporting">
        * End Date will be the 30th June each year.
      </div>
      <FieldAndLabel
        class="-span-full"
        :field="f.pi_insurer"
      />
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



</script>