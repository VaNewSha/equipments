<template>
  <div class="pagination-component col-sm-12 d-flex justify-content-between">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <li
          v-for="(link, index) in links"
          :key="index"
          class="page-item"
          :class="{active: link.active, disabled: !link.url}"
        >
          <button
            class="page-link"
            @click="currentUrl = link.url; refreshLinkData();"
          >
            <span class="sr-only" v-html="link.label" />
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {

  props: {
    links: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      perPage: 10,
      currentUrl: null,
    };
  },

  methods: {
    refreshLinkData () {
      if (!this.currentUrl) {
        this.currentUrl = this.links[1].url;
      }

      const urlParam = new URL(this.currentUrl);
      const page = urlParam.searchParams.get('page');

      this.$emit('refreshLinkData', page, this.perPage);
    },
  },
};
</script>
