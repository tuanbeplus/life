<template>
  <div class="blog-index-tabbed">
    <ContentTabs
      style="--tabsButtonWidthDesktop:215px"
      :tabs="tabs"
      :update-height-event="updateHeightEvent"
    >
      <template
        v-for="(catView, i) in catViewOpts"
        #[`tab-${i}`]
      >
        <BlogIndexGrid
          class="-articles-for-category"
          :cat-view="catView"
          :per-page="perPage"
        >
          <template
            v-for="article in catView.articles"
            #[`article-${article.id}`]
          >
            <slot
              :name="`article-${article.id}`"
            />
          </template>
          <template #discover-more>
            <div class="discover-more">
              <button
                type="button"
                class="button grey"
                @click="discoverMore(catView)"
              >
                Discover More
              </button>
            </div>
          </template>
        </BlogIndexGrid>
      </template>
    </ContentTabs>
  </div>
</template>
<script setup>
import { ref, computed } from 'vue'
import ContentTabs from '~/widget/ContentTabs.vue'
import BlogIndexGrid from '~/blog/BlogIndexGrid.vue'
import mitt from 'mitt'

const props = defineProps({
  articles: {
    type: Array,
    required: true,
  },
  possibleCategories: {
    type: Array,
    required: true,
  },
  perPage: {
    type: Number,
    required: true,
  },
})

const catViewOpts = ref([])
props.possibleCategories.forEach(c => {
  if (('unfiltered' in c) || props.articles.some(a => c.slug in a.categories)) {
    catViewOpts.value.push({
      ...c,
      articleShowCount: props.perPage,
      articles: props.articles.filter(a => ('unfiltered' in c) || (c.slug in a.categories)),
    })
  }
})

const updateHeightEvent = mitt()

const discoverMore = (catView) => {
  catView.articleShowCount += props.perPage
  updateHeightEvent.emit('update')
}

const tabs = computed(() => {
  return catViewOpts.value.map(c => ({
    title: c.navButtonText,
    slug: c.slug,
    type: null,
  }))
})


</script>