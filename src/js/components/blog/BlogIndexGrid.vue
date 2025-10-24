<template>
  <div
    class="blog-index-grid"
  >
    <div class="-grid">
      <div
        v-for="(article, i) in catView.articles"
        :key="i"
        class="-slot"
        :class="{
          '-visible': i < catView.articleShowCount
        }"
      >
        <slot
          :name="`article-${article.id}`"
        />
      </div>
    </div>
    <slot name="discover-more" />
  </div>
</template>
<script setup>

const props = defineProps({
  catView: {
    type: Object,
    required: true,
  },
  perPage: {
    type: Number,
    required: true,
  },
})



</script>