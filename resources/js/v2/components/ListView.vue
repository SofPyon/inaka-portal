<template>
  <div class="listview container">
    <div class="listview-header" v-if="headerTitle">
      {{ headerTitle }}
    </div>
    <div class="listview-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    headerTitle: {
      type: String,
      default: null
    }
  }
}
</script>

<style lang="scss" scoped>
.listview {
  padding: $spacing $spacing $spacing-md;
  @media screen and (max-width: $breakpoint-listview-sm) {
    padding: 0;
  }
  &-header {
    font-size: $font-size-lg;
    font-weight: bold;
    padding: 0 0 $spacing-md;
    width: 100%;
    @media screen and (max-width: $breakpoint-listview-sm) {
      padding: $spacing $spacing $spacing-xs;
    }
  }
  &-empty {
    color: $color-muted;
    padding: $spacing-lg 0;
    text-align: center;
    width: 100%;
    &__icon {
      font-size: 2.5rem;
      margin: 0 0 $spacing-md;
    }
    &__text {
      font-weight: bold;
      margin: 0;
    }
  }
}
</style>
