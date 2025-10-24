<template>
  <div
    class="question-opts"
  >
    <div class="-number">
      <span>{{ q.number }}.</span>
    </div>
    <div class="-main">
      <h4>{{ q.label }}</h4>
      <div
        class="large-radio-buttons"
        :data-fname="fieldname"
      >
        <div
          v-for="(optText, val) in q.options"
          :key="val"
          class="-opt button"
          :class="{
            '-selected': q.selected === val,
          }"
          @click="select(val)"
        >
          <span>{{ optText }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue'
import useHealthCheck from '#/useHealthCheck.js'

const props = defineProps({
  fieldname: {
    type: String,
    required: true,
  },
})

const { currentOpenHealthCheck, emitter } = useHealthCheck()


const select = (val) => {
  currentOpenHealthCheck.value.fieldByName[props.fieldname].selected = val
  emitter.emit('selected', { fieldname: props.fieldname, val })
}

const q = computed(() => {
  return currentOpenHealthCheck.value.fieldByName[props.fieldname]
})

</script>