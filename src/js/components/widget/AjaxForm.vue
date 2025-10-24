<template>
  <form class="ajax-form">
    <label
      v-for="(field, i) in fields"
      :key="i"
      class="-field"
      :class="{
        '-has-err': errs[field.name].length > 0,
      }"
    >
      <p>{{ field.label }}</p>
      <SelectSml
        v-if="field.type === 'select'"
        :opts="field.opts"
        :fieldname="field.name"
        :init-key="models[field.name]"
        @select="($event) => {models[field.name] = $event; errs[field.name] = []}"
      />
      <textarea
        v-else-if="field.type === 'textarea'"
        v-model="models[field.name]"
        :name="field.name"
        cols="40"
        rows="10"
        :placeholder="field.label"
        :required="(!('required' in field)) || field.required"
        @keydown="errs[field.name] = []"
      />
      <input
        v-else
        v-model="models[field.name]"
        :name="field.name"
        :type="field.type"
        :placeholder="field.label"
        :required="(!('required' in field)) || field.required"
        @keydown="errs[field.name] = []"
      />
      <div
        v-if="errs[field.name].length > 0"
        class="-err-msg"
      >
        <div class="-errs">
          <p
            v-for="(err, ii) in errs[field.name]"
            :key="ii"
          >{{ err }}</p>
        </div>
      </div>
    </label>
    <div
      class="form-feedback"
      :class="{
        '-populated': responseMessage !== '',
      }"
    >
      <div
        v-if="responseMessage !== ''"
        class="alert"
        :class="{
          success: postSuccessful,
          error: !postSuccessful,
        }"
      >
        <p v-html="responseMessage" />
      </div>
    </div>
    <div class="-submit">
      <button
        type="submit"
        name="submit_signup"
        class="button grey loader"
        :class="{
          '-loading': posting
        }"
        aria-label="Submit enquiry"
        @click.prevent="submit"
      >
        <SvgLoadingSpinner />
        <span>Submit Enquiry</span>
      </button>
      <input
        type="hidden"
        name="action"
        value="life_ajax_submit_form"
      />
      <input
        type="hidden"
        name="form_id"
        :value="formId"
      />
    </div>
  </form>
</template>
<script setup>
import { reactive, ref } from 'vue'
import SelectSml from '~/widget/SelectSml.vue'
import SvgLoadingSpinner from '~/svg/ui/LoadingSpinner.vue'
import axios from 'axios'

const props = defineProps({
  formId: {
    type: String,
    required: true,
  },
  fields: {
    type: Array,
    required: true,
  },
})

const responseMessage = ref('')
const posting = ref(false)
const posted = ref(false)
const postSuccessful = ref(false)

const _setAsPosting = () => {
  posting.value = true
}
const _setAsSuccessful = () => {
  posting.value = false
  postSuccessful.value = true
  posted.value = true
}
const _setAsFailed = () => {
  posting.value = false
  posted.value = true
}


const _models = {}
const _errs = {}

props.fields.forEach(field => {
  _models[field.name] = field.val
  _errs[field.name] = []
})

const models = reactive(_models)
const errs = reactive(_errs)

const submit = () => {
  const fieldsInErr = new Set()
  props.fields.forEach(field => {
    errs[field.name] = []
    // console.log(field.name, models[field.name])
    if (models[field.name] === '') {
      // console.log('empty')
      if (!('required' in field) || field.required) {
        // console.log('REQUIRED')
        errs[field.name].push('This field is required')
        fieldsInErr.add(field.name)
      }
    }
    // console.log(' ')
  })

  if (fieldsInErr.size === 0) {
    const formData = new FormData()
    
    formData.append('action', 'life_ajax_submit_form')
    formData.append('form_id', props.formId)

    props.fields.forEach(field => {
      formData.append(field.name, models[field.name])
    })

    _setAsPosting()
    const SEND_TO_SERVER = true
    const PRETEND_SUCCESS = false
    const ALLOW_RECURRENT_SUBMISSION = false
    if (SEND_TO_SERVER) {
      axios({
        method: 'post',
        url: '/',
        data: formData,
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Accept': 'application/json, text/javascript, */*; q=0.01',
        },
      })
        .then((response) => {
          if (PRETEND_SUCCESS) {
            _setAsSuccessful()
            responseMessage.value = 'PRETEND_SUCCESS.data.message'
          } else if (ALLOW_RECURRENT_SUBMISSION) {
            responseMessage.value = 'GO AGAIN'
            posting.value = false
          } else {
            if (response.status === 200 && response.data.status === 'ok') {
              _setAsSuccessful()
              responseMessage.value = response.data.messages.join(', ')
            } else if ('data' in response && 'validation' in response.data) {
              _setAsFailed()
              const message = []
              for (const fieldName in response.data.validation) {
                message.push(`${fieldName}: ${response.data.validation[fieldName]}`)
              }
              responseMessage.value = message.join(', ')
            } else {
              _setAsFailed()
              responseMessage.value = 'Sorry. Something went wrong. Please try again later.'
            }
          }
        })
        .catch((error) => {
          console.log(error)
          posting.value = false
        })
    } else {
      setTimeout(() => {
        if (PRETEND_SUCCESS) {
          _setAsSuccessful()
          responseMessage.value = 'Thank you for your enquiry. One of our friendly staff will be in contact with you within the next 24-48 hours.'
        } else {
          responseMessage.value = 'GO AGAIN'
          posting.value = false
        }
      }, 1200)
    }
  }
}


</script>