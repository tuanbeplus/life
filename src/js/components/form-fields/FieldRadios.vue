<template>
  <div
    :ref="el => field.el = el"
    class="component-field -field-text"
    :class="{
      '-has-err': field.errs.length,
    }"
  >
    <div
      v-for="(text, val) in field.options"
      :key="val"
      class="-field -radio"
    >
      <label class="option label">
        <div class="-cb">
          <input
            v-model="field.val"
            type="radio"
            name="field.fname"
            :value="val"
            @change="field.errs = []"
          />
          <div class="-svg">
            <SvgCheckBox />
          </div>
        </div>
        <span
          class="-label"
          v-html="text"
        />
      </label>
    </div>
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