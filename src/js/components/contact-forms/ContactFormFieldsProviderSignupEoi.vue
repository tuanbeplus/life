<template>
  <div
    class="contact-form-fields"
  >
    <div class="-grid -hide-placeholders">
      <h4 class="modal-subheading font-md wt-sb">
        Organisation Details
      </h4>
      <FieldAndLabel
        class="-span-full"
        :field="f.org_name"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.building"
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
        :field="f.abn"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.describe_org"
      />
      
      <h4 class="modal-subheading font-md wt-sb">
        Main Contact Details
      </h4>
      <FieldAndLabel
        :field="f.first_name"
      />
      <FieldAndLabel
        :field="f.last_name"
      />
      <FieldAndLabel
        :field="f.mobile"
      />
      <FieldAndLabel
        :field="f.phone"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.email"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.position"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.fax"
      />
      
      <h4 class="modal-subheading font-md wt-sb">
        Manager Contact Details
      </h4>
      <FieldAndLabel
        class="-span-full"
        :field="f.manager_as_above"
      />
      <FieldAndLabel
        v-if="f.manager_as_above.val === 'No'"
        :field="f.manager_first_name"
      />
      <FieldAndLabel
        v-if="f.manager_as_above.val === 'No'"
        :field="f.manager_last_name"
      />
      <FieldAndLabel
        v-if="f.manager_as_above.val === 'No'"
        :field="f.manager_phone"
      />
      <FieldAndLabel
        v-if="f.manager_as_above.val === 'No'"
        :field="f.manager_mobile"
      />
      <FieldAndLabel
        v-if="f.manager_as_above.val === 'No'"
        class="-span-full"
        :field="f.manager_email"
      />
      <h4 class="modal-subheading font-md wt-sb">
        <em>Life!</em> Program Management
      </h4>
      <FieldAndLabel
        class="-span-full"
        :field="f.appropriate_space"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.referral_pathways"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.delivery_areas"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.data_entry"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.community_events"
      />
      <h4 class="modal-subheading font-md wt-sb">
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
      
      <h4 class="modal-subheading font-md wt-sb">
        GST Registration
      </h4>
      <FieldAndLabel
        class="-span-full"
        :field="f.gst_registration"
      />
      <FieldAndLabel
        class="-span-full"
        :field="f.facilitator_names"
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