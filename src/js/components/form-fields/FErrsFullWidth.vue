<template>
  <ul
    v-if="errs.length"
    class="f-errs-full-width"
  >
    <li
      v-for="err in errs"
      :key="err"
    >
      {{ err }}
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