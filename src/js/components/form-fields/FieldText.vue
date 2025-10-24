<template>
  <div
    :ref="el => field.el = el"
    class="component-field -field-text"
    :class="{
      '-has-err': field.errs.length,
    }"
  >
    <div
      class="-field"
    >
      <input
        v-model="field.val"
        :type="field.type"
        :name="field.fname"
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