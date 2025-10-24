<template>
  <li class="order-resource">
    <div class="inner">
      <div
        v-if="resource.image"
        class="image"
      >
        <img
          :src="resource.image"
          class="contain"
        />
      </div>
      <div class="details">
        <div
          class="-content"
          :class="{
            'content':resource.isOrderable,
            'content-na': !resource.isOrderable,
          }"
        >
          <h6
            class="font-middling wt-sb lh-tight"
            v-html="resource.title"
          />
          <div
            v-if="resource.content"
            class="formatted"
            v-html="resource.content"
          />
        </div>
        <div
          class="-download"
          :class="{
            'download-file': !resource.isOrderable,
            'download-file-na': resource.isOrderable,
          }"
        >
          <div>
            <a
              target="_blank"
              rel="noopener noreferrer"
              :href="resource.file?.url"
              class="button white -flex"
            >
              <SvgIconDownload />
              <span>Download Free PDF</span>
            </a>
          </div>
        </div>
        <div class="print-order-qty">
          <div
            v-if="resource.maxQty > 0 && resource.isOrderable"
            class="inner"
          >
            <div class="-label">
              <p>Qty for print order</p>
            </div>
            <div class="qty-selection-block">
              <div class="qty-selection">
                <SelectNumber
                  :max-val="resource.maxQty"
                  :fieldname="`qty_dummy[${resource.id}]`"
                  :update-emitter="resource.updateEmitter"
                  @select="selectQty($event)"
                />
              </div>
              <div
                class="qty-selection-confirm"
                :class="{ '-hidden': resource.qty === 0 }"
              >
                <div class="-pad">
                  <button
                    type="button"
                    class="button green"
                  >
                    <SvgIconCheck />
                  </button>
                </div>
              </div>
            </div>
            <input
              v-model="resource.qty" 
              type="hidden"
              :name="`qty[${resource.id}]`"
            />
          </div>
          <div
            v-else
            class="-unavailable"
          >
            <p class="unavailable">
              N/A
            </p>
          </div>
        </div>
      </div>
    </div>
  </li>
</template>
<script setup>
import SelectNumber from '~/widget/SelectNumber.vue'
import SvgIconDownload from '~/svg/ui/IconDownload.vue'
import SvgIconCheck from '~/svg/ui/IconCheck.vue'

const props = defineProps({
  resource: {
    type: Object,
    required: true,
  },
})




const selectQty = (qty) => {
  props.resource.qty = qty
}

</script>