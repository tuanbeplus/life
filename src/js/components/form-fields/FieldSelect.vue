<template>
  <div
    :ref="el => field.el = el"
    class="component-field -field-select"
    :class="{
      '-has-err': field.errs.length,
    }"
  >
    <div
      class="-field"
    >
      <SelectSml
        :opts="options"
        :init-val="field.val"
        :fieldname="field.fname"
        :placeholder="field.placeholder"
        @select="select"
      />
    </div>
    <FErrs :errs="field.errs" />
  </div>
</template>
<script setup>
import { computed } from 'vue'
import SelectSml from '~/widget/SelectSml.vue'
import FErrs from '~/form-fields/FErrs.vue'

const emit = defineEmits(['change'])


const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})

const options = computed(() => {
  const opts = []
  for (const v in props.field.options) {
    opts.push({
      text: props.field.options[v],
      val: v,
    })
  }
  return { value: opts }
})

const select = val => {
  emit('change', val)
  props.field.val = val
  props.field.errs = []
}


</script>