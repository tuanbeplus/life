<template>
  <ul
    v-if="errs.length"
    class="-err parsley-errors-list"
  >
    <li>
      {{ errs[0] }}
    </li>
  </ul>
</template>
<script setup>

defineProps({
  errs: {
    type: Array,
    required: true,
  },
})


</script>