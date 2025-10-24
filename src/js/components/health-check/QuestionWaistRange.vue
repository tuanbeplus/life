<template>
  <div
    class="question-waist-range"
  >
    <div class="-number">
      <span>{{ q.number }}.</span>
    </div>
    <div class="-main">
      <h4>{{ showingSizes ? q.label_with_size : q.label }}</h4>
      <table class="-desktop">
        <thead>
          <tr>
            <th>{{ q.table_column_headers.val }}</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-if="showingSizes"
          >
            <td>{{ q.table_column_headers.size }}</td>
            <td v-html="table.waistRanges[1].size" />
            <td v-html="table.waistRanges[2].size" />
            <td v-html="table.waistRanges[3].size" />
          </tr>
          <tr>
            <td>{{ q.table_column_headers.measurement }}</td>
            <td v-html="table.waistRanges[1].measurement" />
            <td v-html="table.waistRanges[2].measurement" />
            <td v-html="table.waistRanges[3].measurement" />
          </tr>
        </tbody>
      </table>
      <table class="-mobile">
        <tbody>
          <template v-if="showingSizes">
            <tr>
              <th>{{ q.table_column_headers.size }}</th>
              <th>{{ q.table_column_headers.val }}</th>
            </tr>
            <tr
              v-for="i in 3"
              :key="i"
            >
              <td v-html="table.waistRanges[i].size" />
              <td>{{ i }}</td>
            </tr>
          </template>
          <tr>
            <th>{{ q.table_column_headers.measurement }}</th>
            <th>{{ q.table_column_headers.val }}</th>
          </tr>
          <tr
            v-for="i in 3"
            :key="i"
          >
            <td v-html="table.waistRanges[i].measurement" />
            <td>{{ i }}</td>
          </tr>
        </tbody>
      </table>
      <div class="large-radio-buttons">
        <div
          v-for="(optText, val) in q.classicButtons"
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

const q = computed(() => currentOpenHealthCheck.value.fieldByName.waist_range)



const table = computed(() => {
  const gender = currentOpenHealthCheck.value.fieldByName.gender.selected
  const tableVersion = (
    currentOpenHealthCheck.value.fieldByName.background.selected === 'No'
    && currentOpenHealthCheck.value.fieldByName.birthplace.selected !== 'Asia (including the Indian sub-continent)'
  )
    ? 'measurement-table-one'
    : 'measurement-table-two'
  return {
    waistRanges: q.value.ranges[gender][tableVersion].waist_ranges,
  }
})

const showingSizes = computed(() => 'size' in table.value.waistRanges[1])






const select = (val) => {
  currentOpenHealthCheck.value.fieldByName[props.fieldname].selected = val
  emitter.emit('selected', { fieldname: props.fieldname, val })
}

</script>