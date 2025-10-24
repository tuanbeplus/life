<template>
  <div
    class="question-checkboxes"
  >
    <div class="-number">
      <span>{{ q.number }}.</span>
    </div>
    <div class="-main">
      <h4>{{ q.label }}</h4>
      <div class="checkbox-lines -vue-component">
        <label
          v-for="(opt, val) in q.options"
          :key="val"
          class="-opt"
          :class="{
            '-selected': opt.isSelected,
            '-hidden': opt.female_only && currentOpenHealthCheck.fieldByName.gender.selected === 'Male',
            '-prevent-change': preventChange(opt, val),
          }"
          @click="toggle(opt, val)"
        >
          <span>{{ opt.label }}</span>
        </label>
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


const toggle = (opt, val) => {
  opt.isSelected = !opt.isSelected
  emitter.emit('selected', { fieldname: props.fieldname, val })
}

const q = computed(() => {
  return currentOpenHealthCheck.value.fieldByName[props.fieldname]
})


const preventChange = (opt, val) => {
  if (val === '') {
    for (const v in q.value.options) {
      if (v !== '' && q.value.options[v].isSelected) {
        return true
      }
    }
  } else {
    if (q.value.options[''].isSelected) {
      return true
    }
  }
}

</script>