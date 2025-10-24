<template>
  <div
    v-if="field"
    class="-field"
  >
    <label v-html="field.label" />
    <ComponentField
      :field="field"
      @change="emit('change', $event)"
    />
  </div>
</template>
<script setup>
import ComponentField from '~/form-fields/ComponentField.vue'


const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})

if (!props.field || typeof props.field !== 'object') {
  console.error('FieldAndLabel: field is a required object', props.field)
}

const emit = defineEmits(['change'])


</script>