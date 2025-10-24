<template>
  <SvgIconCopy v-if="icon === 'copy'" />
  <SvgIconEmail v-else-if="icon === 'email'" />
  <SvgIconFbHollow v-else-if="icon === 'fb'" />
  <SvgIconWhatsapp v-else-if="icon === 'whatsapp'" />
</template>
<script setup>
import SvgIconCopy from '~/svg/social/IconCopy.vue'
import SvgIconEmail from '~/svg/social/IconEmail.vue'
import SvgIconFbHollow from '~/svg/social/IconFbHollow.vue'
import SvgIconWhatsapp from '~/svg/social/IconWhatsapp.vue'

const props = defineProps({
  icon: {
    type: String,
    required: true,
  },
})


</script>