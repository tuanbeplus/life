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
        :field="f.work_experience"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.facilitation_experience"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.cultural_experience"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.langauges_other_than_en"
      />
      <FieldAndLabel
        v-if="f.langauges_other_than_en.val === 'Yes'"
        class="-span-full"
        :field="f.languages"
      />
      <FieldAndLabel
        v-if="f.langauges_other_than_en.val === 'Yes'"
        class="-span-full"
        :field="f.deliver_cald_q"
      />
      <FieldAndLabel
        v-if="f.langauges_other_than_en.val === 'Yes' && f.deliver_cald_q.val === 'Yes'"
        class="-span-full"
        :field="f.deliver_cald"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.computer_access"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.internet_access"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.org_name"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.existing_provider"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.comments"
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