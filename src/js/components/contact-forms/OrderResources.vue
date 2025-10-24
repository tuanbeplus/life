<template>
  <section class="order-resources download-resources bg-white">
    <div class="center-frame">
      <form
        action="/"
        method="post"
        class="resource-listing"
        novalidate
        @submit.prevent="submitContactForm"
      >
        <ul
          v-if="resources"
          class="listing hard-resources"
        >
          <OrderResource
            v-for="(resource, i) in contactForm.orderResources.resources"
            :key="i"
            :resource="resource"
          />
        </ul>
        <OrderResourceForm
          :order-resources="contactForm.orderResources"
          :models="models"
          :fields="contactForm.fields"
          :contact-form="contactForm"
        />
      </form>
    </div>
    <div
      class="complete-order"
      :class="{
        'active': contactForm.orderResources.selected.length > 0 && !contactForm.orderResources.formInView,
      }"
    >
      <div class="inner font-sm align-center">
        <p>
          <span>Done selecting resources?</span>
          <a
            class="button purple-muted"
            @click.prevent="scrollToForm"
          >
            <span>Order Printed Materials</span>
            <span class="resource-counter">{{ contactForm.orderResources.selected.length }}</span>
          </a>
        </p>
      </div>
    </div>
  </section>
</template>
<script setup>
import { reactive } from 'vue'
import OrderResource from '~/contact-forms/order-resources/OrderResource.vue'
import OrderResourceForm from '~/contact-forms/order-resources/OrderResourceForm.vue'
import useContactFormOrderResources from '#/useContactFormOrderResources.js'


const props = defineProps({
  resources: {
    type: Array,
    required: true,
  },
})


const { ContactFormOrderResources  } = useContactFormOrderResources()
const contactForm = reactive(new ContactFormOrderResources(props.resources))

const scrollToForm = () => {
  if (!contactForm.orderResources.formIsOpen) {
    contactForm.orderResources.toggleForm()
  }
  contactForm.orderResources.formEl.scrollIntoView({ behavior: 'smooth' })
}




const submitContactForm = () => {
  contactForm.validateAndPost()
}


</script>