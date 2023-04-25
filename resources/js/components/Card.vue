<template>
  <div class="who-card">
      <h3 className="who-card-title">{{title}}</h3>
      <div class="who-card-body">
        <slot />
      </div>
  </div>
</template>

<script>

export default {
  name: 'Card',
  props: {
    className: {
      type: String,
      required: false
    },
    title: {
      type: String,
      required: false
    }
  }
}
</script>
