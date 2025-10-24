<template>
  <div
    class="button hollow-orange -flex"
    @click="dialogShare.open()"
  >
    <SvgIconUpload />
    <span>Share health check with a friend or family</span>
  </div>
</template>
<script setup>
import SvgIconUpload from '~/svg/ui/IconUpload.vue'
import useDialogShare from '#/useDialogShare.js'

const { dialogShare } = useDialogShare()


</script>