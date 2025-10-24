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
      <VueDatePicker
        v-model="dateModel"
        :enable-time-picker="false"
        format="dd/MM/yyyy"
        @update:model-value="update"
        :month-change-on-scroll="false"
      />
    </div>
    <FErrs :errs="field.errs" />
  </div>
</template>
<script setup>
import FErrs from '~/form-fields/FErrs.vue'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { ref } from 'vue'
// https://vue3datepicker.com/methods-and-events/events/

const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})

const dateObj = ref(new Date(props.field.val))

const dateModel = ref(
  dateObj.value instanceof Date && isNaN(dateObj.value) === false
    ? dateObj.value
    : null
)

const update = () => {
  // format model.value to yyyy-MM-dd
  props.field.val = dateModel.value === null ? '' : dateModel.value.toLocaleDateString('en-CA')
  props.field.errs = []
}


</script>