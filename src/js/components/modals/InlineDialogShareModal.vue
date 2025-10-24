<template>
  <dialog
    :ref="el => dialogShare.dialogEl.value = el"
    class="inline-dialog-modal -share"
    @click="dialogShare.close()"
  >
    <div
      class="-box"
      @click.stop
    >
      <div
        class="-close"
        @click="dialogShare.close()"
      >
        <SvgIconTimes />
      </div>
      <div class="-content">
        <div class="-text">
          <h2>{{ eyebrowText }}</h2>
          <h3>{{ largeHeading }}</h3>
          <p>{{ bodyContent }}</p>
          <h4>{{ preButtonsText }}</h4>
        </div>
        <div class="-links">
          <a
            v-for="(button, i) in buttons"
            class="-link"
            :class="{
              '-show-checkmark': showCheckMarkOn === i,
            }"
            :href="button.href"
            target="_blank"
            rel="noopener noreferrer"
            @click="buttonClick($event, button, i)"
          >
            <ShareIcon :icon="button.icon" />
            <SvgCircleCheckmark
              v-if="'copyToClipboard' in button"
            />
            <span
              v-if="'copyToClipboard' in button"
              class="-copied-text"
            >Copied URL</span>
            <span>{{ button.text }}</span>
          </a>
        </div>
      </div>
    </div>
  </dialog>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import useDialogShare from '#/useDialogShare.js'
import SvgIconTimes from '~/svg/ui/IconTimes.vue'
import ShareIcon from '~/svg/dynamic/ShareIcon.vue'
import SvgCircleCheckmark from '~/svg/ui/CircleCheckmark.vue'
import dialogPolyfill from 'dialog-polyfill'

const props = defineProps({
  eyebrowText: {
    type: String,
    required: true,
  },
  largeHeading: {
    type: String,
    required: true,
  },
  bodyContent: {
    type: String,
    required: true,
  },
  preButtonsText: {
    type: String,
    required: true,
  },
  buttons: {
    type: Array,
    required: true,
  },
})


const { dialogShare } = useDialogShare()


const showCheckMarkOn = ref(null)


const buttonClick = (e, button, i) => {
  if ('copyToClipboard' in button) {
    navigator.clipboard.writeText(button.copyToClipboard).then(function() {
      showCheckMarkOn.value = i
      setTimeout(() => {
        showCheckMarkOn.value = null
      }, 3000)
    }, function(err) {
      alert('unable to copy url to clipboard')
    })
    e.preventDefault()
  }
}

onMounted(() => {
  dialogPolyfill.registerDialog(dialogShare.dialogEl.value)
})


</script>