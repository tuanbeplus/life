<template>
  <div
    :ref="el => orderResources.formEl = el"
    class="order-resource-form"
  >
    <div
      class="toggle-order-form"
    >
      <button
        type="button"
        class="button purple-muted btn-open -flex -height-64"
        :class="{
          '-hidden': (orderResources.selected.length === 0 || orderResources.formIsOpen),
        }"
        @click="orderResources.toggleForm()"
      >
        <SvgIconHamburger />
        <span>Order a Printed Version</span>
        <span class="resource-counter">{{ orderResources.selected.length }}</span>
      </button>
      <button
        type="button"
        class="button purple btn-close  -flex -height-64"
        :class="{
          '-hidden': !orderResources.formIsOpen,
        }"
        @click="orderResources.toggleForm()"
      >
        <SvgIconTimes />
        <span>Close Form</span>
      </button>
    </div>
    <div
      class="order-form-fields"
      :class="{
        '-open': orderResources.formIsOpen
      }"
    >
      <div class="_expander">
        <div class="_height">
          <div class="_inner">
            <h4 class="font-md wt-sb">
              Complete your order
            </h4>
            <div class="inner">
              <div class="ordering-items">
                <h5 class="font-mdish wt-sb">
                  Requested Items
                </h5>
                <ul
                  id="ordering-items"
                  class="listing order-items"
                >
                  <li class="heading">
                    <span class="item-label">Item</span>
                    <span class="item-quantity">Qty</span>
                    <span class="item-remove">&nbsp;</span>
                  </li>
                  <li
                    v-for="(resource, i) in orderResources.selected"
                    :key="i"
                  >
                    <span
                      class="item-label"
                      v-html="resource.title"
                    />
                    <span class="item-quantity">{{ resource.qty }}</span>
                    <span class="item-remove">
                      <button
                        type="button"
                        class="button tiny danger remove-item -flex"
                        @click="resource.clearQty()"
                      >
                        <SvgIconTimes />
                        <span>Remove</span>
                      </button>
                    </span>
                  </li>
                </ul>
              </div>
              <div class="contact-form-fields -cols4">
                <div class="-grid">
                  <FieldAndLabel
                    :field="f.full_name"
                  />
                  <FieldAndLabel
                    :field="f.org_name"
                  />
                  <FieldAndLabel
                    class="-span-full"
                    :field="f.address"
                  />
                  <FieldAndLabel
                    :field="f.suburb"
                  />
                  <FieldAndLabel
                    class="-span-quarter"
                    :field="f.state"
                  />
                  <FieldAndLabel
                    class="-span-quarter"
                    :field="f.postcode"
                  />
                  <FieldAndLabel
                    :class="{
                      '-span-full': f.event.val !== 'Yes',
                    }"
                    :field="f.event"
                  />
                  <FieldAndLabel
                    :class="{
                      'display-none': f.event.val !== 'Yes',
                    }"
                    :field="f.event_type"
                  />
                  <FieldAndLabel
                    :field="f.email"
                  />
                  <FieldAndLabel
                    :field="f.phone"
                  />
                  <FieldAndLabel
                    class="-span-full"
                    :field="f.comments"
                  />
                </div>
              </div>
              <ContactFormActionsAndFeedback
                :contact-form="contactForm"
                :has-return-to-site-button="false"
                submit-button-text="Submit Order Request"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, computed } from 'vue'
import { useIntersectionObserver } from '@vueuse/core'
import SvgIconHamburger from '~/svg/ui/IconHamburger.vue'
import SvgIconTimes from '~/svg/ui/IconTimes.vue'
import ContactFormActionsAndFeedback from '~/contact-forms/ContactFormActionsAndFeedback.vue'
import FieldAndLabel from '~/form-fields/FieldAndLabel.vue'


const props = defineProps({
  orderResources: {
    type: Object,
    required: true,
  },
  models: {
    type: Object,
    required: true,
  },
  fields: {
    type: Object,
    required: true,
  },
  contactForm: {
    type: Object,
    required: true,
  },
})




onMounted(() => {
  useIntersectionObserver(
    props.orderResources.formEl,
    ([{ isIntersecting }]) => {
      if (isIntersecting) {
        props.orderResources.formInView = true
      } else {
        props.orderResources.formInView = false
      }
    }
  )
})

const f = computed(() => props.contactForm.fields)


</script>