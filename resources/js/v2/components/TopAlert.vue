<template>
  <div
    class="top_alert"
    :class="{
      'is-success': type === 'success',
      'is-primary': type === 'primary',
      'is-danger': type === 'danger'
    }"
  >
    <h2 class="top_alert__title">
      <slot name="title" />
    </h2>
    <p class="top_alert__body">
      <slot />
    </p>
    <slot name="cta" />
  </div>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'primary'
    }
  }
}
</script>

<style lang="scss" scoped>
.top_alert {
  color: #fff;
  padding: $spacing;
  & + & {
    border-top: 1px solid rgba(#fff, 0.16);
  }
  &.is-success {
    background: $color-success;
  }
  &.is-primary {
    background: $color-primary;
  }
  &.is-danger {
    background: $color-danger;
  }
  &__title {
    font-size: 1rem;
    font-weight: bold;
    margin: 0;
  }
  &__body {
    font-size: 1rem;
    margin: $spacing-sm 0 0;
  }
}
</style>
