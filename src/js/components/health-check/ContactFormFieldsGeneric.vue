<template>
  <!-- <div
    class="contact-form-fields"
  >
    <div class="-grid">
      <div class="-field">
        <label for="send-contact-first-name">{{ fields.first_name.label }}</label>
        <input
          id="send-contact-first-name"
          v-model="models.first_name.val"
          type="text"
          name="first_name"
          required
        />
      </div>
      <div class="-field">
        <label for="send-contact-last-name">{{ fields.last_name.label }}</label>
        <input
          id="send-contact-last-name"
          v-model="models.last_name.val"
          type="text"
          name="last_name" 
          required
        />
      </div>
      <div class="-field">
        <label for="send-contact-email">{{ fields.email.label }}</label>
        <input
          id="send-contact-email"
          v-model="models.email.val"
          type="email"
          name="email"
          required
        />
      </div>
      <div class="-field">
        <label for="send-contact-phone">{{ fields.phone.label }}</label>
        <input
          id="send-contact-phone"
          v-model="models.phone.val"
          type="tel"
          name="phone"
          required
        />
      </div>
      <div
        v-if="'postcode' in fields"
        class="-field"
      >
        <label for="send-contact-postcode">{{ fields.postcode.label }}</label>
        <input
          id="send-contact-postcode"
          v-model="models.postcode.val"
          type="text"
          name="postcode"
          required
        />
      </div>
      <div
        v-if="'living_with_pcos' in fields"
        class="-field -span-full -v-pad"
      >
        <label>{{ fields.living_with_pcos.label }}</label>
        <div class="large-radio-buttons">
          <div
            v-for="(optText, val) in fields.living_with_pcos.options"
            :key="val"
            class="-opt button"
            :class="{
              '-selected': models.living_with_pcos.val === val,
            }"
            @click="models.living_with_pcos.val = val"
          >
            <span>{{ optText }}</span>
          </div>
        </div>
      </div>
      <div
        v-if="'currently_gdm' in fields"
        class="-field -span-full -v-pad"
      >
        <label>{{ fields.currently_gdm.label }}</label>
        <div class="large-radio-buttons">
          <div
            v-for="(optText, val) in fields.currently_gdm.options"
            :key="val"
            class="-opt button"
            :class="{
              '-selected': models.currently_gdm.val === val,
            }"
            @click="models.currently_gdm.val = val"
          >
            <span>{{ optText }}</span>
          </div>
        </div>
      </div>
      <div
        v-if="models.currently_gdm?.val === 'Yes'"
        class="-field -span-full"
      >
        <label for="send-contact-due-date">{{ fields.due_date.label }}</label>
        <input
          id="send-contact-due-date"
          v-model="models.due_date.val"
          type="date"
          name="due_date"
        />
      </div>
      <div
        class="-field"
        :class="{
          '-span-full': ('living_with_pcos' in fields || 'currently_gdm' in fields),
        }"
      >
        <label for="send-contact-via">{{ fields.heard_about_via.label }}</label>
        <SelectSml
          :opts="heardAboutOpts"
          :init-val="models.heard_about_via.val"
          fieldname="heard_about_via"
          :placeholder="fields.heard_about_via.placeholder"
          @select="e => props.models.heard_about_via.val = e"
        />
      </div>
      <div
        v-if="'Do_you_need_an_interpreter__c' in fields"
        class="-field -span-full -v-pad"
      >
        <label>{{ fields.Do_you_need_an_interpreter__c.label }}</label>
        <div class="large-radio-buttons">
          <div
            v-for="(optText, val) in fields.Do_you_need_an_interpreter__c.options"
            :key="val"
            class="-opt button"
            :class="{
              '-selected': models.Do_you_need_an_interpreter__c.val === val,
            }"
            @click="models.Do_you_need_an_interpreter__c.val = val"
          >
            <span>{{ optText }}</span>
          </div>
        </div>
      </div>
      <div
        v-if="'Vietnamese_woman__c' in fields"
        class="-field -span-full -checkbox"
      >
        <label class="option label">
          <div class="-cb">
            <input
              v-model="models.Vietnamese_woman__c.val"
              type="checkbox"
              name="Vietnamese_woman__c"
            />
            <div class="-svg">
              <SvgCheckBox />
            </div>
          </div>
          <span
            class="-label"
            v-html="fields.Vietnamese_woman__c.label"
          />
        </label>
      </div>
      <div
        v-if="'Program_to_be_deliver_Vietnamese__c' in fields"
        class="-field -span-full -v-pad"
      >
        <label>{{ fields.Program_to_be_deliver_Vietnamese__c.label }}</label>
        <div class="large-radio-buttons">
          <div
            v-for="(optText, val) in fields.Program_to_be_deliver_Vietnamese__c.options"
            :key="val"
            class="-opt button"
            :class="{
              '-selected': models.Program_to_be_deliver_Vietnamese__c.val === val,
            }"
            @click="models.Program_to_be_deliver_Vietnamese__c.val = val"
          >
            <span>{{ optText }}</span>
          </div>
        </div>
      </div>

      <div
        v-if="'speaks_english' in fields"
        class="-field -radios -span-full"
      >
        <p>{{ fields.speaks_english.label }}</p>
        <div
          v-for="(text, val) in fields.speaks_english.options"
          :key="val"
          class="-field -checkbox"
        >
          <label class="option label">
            <div class="-cb">
              <input
                v-model="models.speaks_english.val"
                type="radio"
                name="consent"
                :value="val"
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
      </div>
      <div class="-field -span-full -checkbox">
        <label class="option label">
          <div class="-cb">
            <input
              v-model="models.consent.val"
              type="checkbox"
              name="consent"
            />
            <div class="-svg">
              <SvgCheckBox />
            </div>
          </div>
          <span
            class="-label"
            v-html="fields.consent.label"
          />
        </label>
      </div>
      <div
        v-if="'consent_pcos' in fields"
        class="-field -span-full -checkbox"
      >
        <label class="option label">
          <div class="-cb">
            <input
              v-model="models.consent_pcos.val"
              type="checkbox"
              name="consent_refer"
            />
            <div class="-svg">
              <SvgCheckBox />
            </div>
          </div>
          <span
            class="-label"
            v-html="fields.consent_pcos.label"
          />
        </label>
      </div>
    </div>
  </div> -->
</template>
<script setup>
import { computed } from 'vue'
import SelectSml from '~/widget/SelectSml.vue'
import SvgCheckBox from '~/svg/ui/CheckBox.vue'

const props = defineProps({
  models: {
    type: Object,
    required: true,
  },
  fields: {
    type: Object,
    required: true,
  },
})



// const changeHeardAbout = (val) => {
//   props.models.heard_about_via.val = val
// }

const heardAboutOpts = computed(() => {
  const opts = []
  for (const v in props.fields.heard_about_via.options) {
    opts.push({
      text: props.fields.heard_about_via.options[v],
      val: v,
    })
  }
  return { value: opts }
})



</script>