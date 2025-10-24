<template>
  <div
    :ref="el => field.el = el"
    class="component-field -field-buttons large-radio-buttons"
    :data-fname="field.fname"
    :class="{
      '-has-err': field.errs.length,
    }"
  >
    <div
      v-for="(optText, val) in field.options"
      :key="val"
      class="-opt button"
      :class="{
        '-selected': field.val === val,
      }"
      @click="click(val)"
    >
      <span>{{ optText }}</span>
    </div>
    <FErrsFullWidth :errs="field.errs" />
  </div>
</template>
<script setup>
import FErrsFullWidth from '~/form-fields/FErrsFullWidth.vue'


const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})

const click = (val) => {
  props.field.val = val
  props.field.errs = []
}


</script>