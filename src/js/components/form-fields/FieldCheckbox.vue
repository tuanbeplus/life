<template>
  <div
    :ref="el => field.el = el"
    class="-field -checkbox"
  >
    <label class="option label">
      <div class="-cb">
        <input
          v-model="field.val"
          type="checkbox"
          :name="field.fname"
          @change="field.errs = []"
        />
        <div class="-svg">
          <SvgCheckBox />
        </div>
      </div>
      <span
        class="-label"
        v-html="field.label"
      />
    </label>
    <FErrsFullWidth :errs="field.errs" />
  </div>
</template>
<script setup>
import SvgCheckBox from '~/svg/ui/CheckBox.vue'
import FErrsFullWidth from '~/form-fields/FErrsFullWidth.vue'


const props = defineProps({
  field: {
    type: Object,
    required: true,
  },
})


</script>