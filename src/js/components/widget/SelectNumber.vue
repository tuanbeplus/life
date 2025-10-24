<template>
  <SelectSml
    :opts="{ value: _opts }"
    :fieldname="fieldname"
    :init-val="initVal"
    :update-emitter="updateEmitter"
  />
</template>
<script setup>
import SelectSml from '~/widget/SelectSml.vue'

const props = defineProps({
  maxVal: {
    type: Number,
    required: true,
  },
  fieldname: {
    type: String,
    default: null,
  },
  zeroText: {
    type: String,
    default: 'Select',
  },
  initVal: {
    type: Number,
    default: 0,
  },
  updateEmitter: {
    type: Object,
    default: null,
  },
})

const _opts = [{ val: 0, text: props.zeroText }]
for (let i = 1; i <= props.maxVal; i++) {
  _opts.push({ val: i, text: i })
}




</script>