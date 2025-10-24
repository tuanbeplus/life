import { ref, computed } from 'vue'
import mitt from 'mitt'
import useContactForm from '#/useContactForm.js'

class Resource {
  constructor(d) {
    Object.assign(this, d)
    this.qty = ref(0)
    this.updateEmitter = mitt()

    /**
     * These ids were in the codebase since 2021. I'm not sure how they are determined
     */
    this.isOrderable = !([1428, 1431, 4134, 1436, 1474, 1477, 1486].includes(this.id))
  }
  clearQty() {
    this.qty.value = 0
    this.updateEmitter.emit('update', 0)
  }
}


class OrderResources {
  constructor(resourcesData) {
    this.resources = resourcesData.map(r => new Resource(r))
    this.selected = computed(() => this.resources.filter(r => r.qty.value > 0))
    this.formEl = ref(null)
    this.formIsOpen = ref(false)
    this.formInView = ref(false)
  }
  toggleForm() {
    this.formIsOpen = !this.formIsOpen
  }
}


const fieldsData = {
  full_name: {
    label: 'Full Name',
  },
  org_name: {
    label: 'Name of Organisation',
  },
  address: {
    label: 'Address',
  },
  suburb: {
    label: 'Suburb',
  },
  state: {
    label: 'State',
    type: 'select',
    options: {
      'VIC': 'Victoria',
    },
  },
  postcode: {
    label: 'Post code',
    validation_macro: 'postcode',
  },
  event: {
    label: 'Are the resources for a specific event?',
    type: 'select',
    options: {
      'Yes': 'Yes',
      'No': 'No',
    },
  },
  event_type: {
    label: 'What type of event is it?',
    type: 'select',
    required: false,
    options: {
      'Expos': 'Expos',
      'Seminars': 'Seminars',
      'Conferences': 'Conferences',
      'Festivals': 'Festivals',
      'Other': 'Other',
    },
  },
  email: {
    label: 'Email',
    type: 'email',
  },
  phone: {
    label: 'Phone',
    validation_macro: 'phone',
  },
  comments: {
    label: 'Any comments or queries?',
    type: 'textarea',
    required: false,
  },
}


const { ContactForm } = useContactForm()

class ContactFormOrderResources extends ContactForm {
  constructor(resources) {
    super(fieldsData)
    this._formId = 'resourceRequest'

    this.orderResources = new OrderResources(resources)
  }
  appendToFormData(formData) {
    this.orderResources.resources.forEach(r => {
      formData.append(`qty[${r.id}]`, r.qty)
      formData.append(`qty_dummy[${r.id}]`, r.qty) // not sure what qty_dummy is for - prob not needed
    })
    return []
  }
  // post_OLD_REMOVE() {
  //   const quantityData = {}
  //   this.orderResources.resources.forEach(r => {
  //     quantityData[r.id] = r.qty
  //   })
  //   this.models.qty.val = quantityData
  //   this.models.qty_dummy.val = this.models.qty.val // not sure what this was for
  //   super.post(this.models, 'resourceRequest')
  // }
}




export default () => ({
  ContactFormOrderResources,
})