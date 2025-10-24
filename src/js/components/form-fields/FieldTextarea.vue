<template>
  <div
    :ref="el => field.el = el"
    class="component-field -field-textarea"
    :class="{
      '-has-err': field.errs.length,
    }"
  >
    <div
      class="-field"
    >
      <textarea
        v-model="field.val"
        :name="fName"
        :placeholder="field.placeholder"
        :required="field.required"
        @blur="field.errs = []"
      />
    </div>
    <FErrs :errs="field.errs" />
  </div>
</template>
<script setup>
import FErrs from '~/form-fields/FErrs.vue'


const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})


</script>