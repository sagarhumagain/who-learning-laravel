<template>
  <div class="container">
    <div class="row pt-5">
      <div class="col-md-12">
        <div class="card rounded-0">
          <div class="card-header d-flex justify-content-between p-2">
            <div class="card-body">
              <h2>{{ title }}</h2>
              <p>{{ excerpt }}</p>
              <a v-if="link !== 'Link not available'" class="btn btn-primary" :href="link">View</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'notification-details',
  data() {
    return {
      title: '',
      excerpt: '',
      link: '',
    };
  },
  watch: {
    '$route.params': {
      immediate: true,
      handler(newParams) {
        this.title = newParams.title;
        this.excerpt = newParams.excerpt;
        this.link = newParams.link;
      },
    },
  },
};
</script>
