<template>
  <FieldSelect
    v-if="field.type === 'select'"
    :field="field"
    @change="emit('change', $event)"
  />
  <FieldRadios
    v-else-if="field.type === 'radios'"
    :field="field"
    @change="emit('change', $event)"
  />
  <FieldTextarea
    v-else-if="field.type === 'textarea'"
    :field="field"
    @change="emit('change', $event)"
  />
  <FieldButtons
    v-else-if="field.type === 'buttons'"
    :field="field"
    @change="emit('change', $event)"
  />
  <FieldDatepicker
    v-else-if="field.type === 'datepicker'"
    :field="field"
    @change="emit('change', $event)"
  />
  <FieldDatetimepicker
    v-else-if="field.type === 'datetimepicker'"
    :field="field"
    @change="emit('change', $event)"
  />
  <FieldText
    v-else
    :field="field"
    @change="emit('change', $event)"
  />
</template>
<script setup>
import FieldSelect from '~/form-fields/FieldSelect.vue'
import FieldRadios from '~/form-fields/FieldRadios.vue'
import FieldTextarea from '~/form-fields/FieldTextarea.vue'
import FieldButtons from '~/form-fields/FieldButtons.vue'
import FieldDatepicker from '~/form-fields/FieldDatepicker.vue'
import FieldDatetimepicker from '~/form-fields/FieldDatetimepicker.vue'
import FieldText from '~/form-fields/FieldText.vue'

const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})

const emit = defineEmits(['change'])

</script>