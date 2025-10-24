<template>
  <div
    class="select-sml"
    :class="{
      '-is-open': isOpen,
    }"
    @click="toggleOpen"
  >
    <input
      v-if="fieldname"
      v-model="val"
      type="hidden"
      :name="fieldname"
    />
    <div
      class="local-overlay"
      :class="{ '-show': isOpen }"
      @click.stop="toggleOpen"
    />
    <div class="-drop">
      <div class="-opts">
        <div
          v-for="option in opts.value"
          :key="option.val"
          class="-opt"
          :class="{ '-selected': option.val === val }"
          @click="select(option.val)"
        >
          {{ option.text }}
        </div>
      </div>
    </div>
    <div class="-top-box">
      <p>{{ selected ? selected.text : placeholder }}</p>
      <SvgChevDown />
    </div>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue'
import SvgChevDown from '~/svg/ui/ChevDown.vue'
import useLocalOverlay from '#/useLocalOverlay.js'

const emit = defineEmits(['select'])

const props = defineProps({
  opts: {
    type: Array,
    required: true,
  },
  initVal: {
    type: [String, Number],
    default: null,
  },
  initKey: {
    type: [String, Number],
    default: null,
  },
  fieldname: {
    type: String,
    default: null,
  },
  placeholder: {
    type: String,
    default: '',
  },
  updateEmitter: {
    type: Object,
    default: null,
  },
})

// console.log(' ')

// console.log('initKey', props.initKey)
// console.log('initVal', props.initVal)
// console.log('fieldname', props.fieldname)
// console.log('placeholder', props.placeholder)
// console.log('opts', props.opts.value)

// console.log(' ')


const { toggleOpenFunc } = useLocalOverlay()

const isOpen = ref(false)

const val = ref(props.initVal === null ? props.initKey : props.initVal)
if (!val.value && props.opts.value.length && props.opts.value[0].val === '') {
  val.value = props.opts.value[0].val
}


const selected = computed(() => {
  if (val.value !== null) {
    return props.opts.value.find((opt) => opt.val === val.value)
  } else {
    return null
  }
})
const select = (newVal) => {
  emit('select', newVal)
  val.value = newVal
}

const toggleOpen = toggleOpenFunc(isOpen)

if (props.updateEmitter) {
  props.updateEmitter.on('update', (newVal) => {
    val.value = newVal
  })
}


</script>