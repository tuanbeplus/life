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
        format="dd/MM/yyyy HH:mm"
        @update:model-value="update"
        time-picker-inline
        :month-change-on-scroll="false"
        :min-time="field.minTime"
        v-bind="field.vComponentProps"
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

const _updateProps = () => {
  props.field.val = dateModel.value === null ? '' : dateModel.value.toISOString();
}


const update = () => {
  _updateProps()
  props.field.errs = []
}

_updateProps()

</script>