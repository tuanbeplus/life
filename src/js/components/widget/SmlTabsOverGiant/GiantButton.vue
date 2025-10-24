<template>
  <li
    v-if="Array.isArray(smlTab.flows_steps) && smlTab.flows_steps.length > flowI"
    class="giant-button"
  >
    <div
      class="inner"
      :class="{
        'active': smlTab.flowShowing.value === flowI,
      }"
      @click="smlTab.setFlowShowing(flowI)"
    >
      <slot />
    </div>
  </li>
</template>
<script setup>

defineProps({
  smlTab: {
    type: Object,
    required: true,
  },
  flowI: {
    type: Number,
    required: true,
  },
})



</script>