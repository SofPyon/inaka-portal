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
  $listview-item-width: calc((100% - #{$spacing * 2}) / 3);

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
  &-item {
    background: $color-bg-white;
    border-bottom: 1px solid $color-border;
    box-shadow: 0 0.5rem 0.5rem rgba($color-text, 0.05);
    color: $color-text;
    display: flex;
    margin: 0;
    padding: $spacing-md $spacing;
    position: relative;
    width: 100%;
    @media screen and (max-width: $breakpoint-listview-sm) {
      box-shadow: none;
      &:first-child {
        border-top: 1px solid $color-border;
      }
    }
    @media screen and (min-width: $breakpoint-listview-sm) {
      &:last-child {
        border-bottom: 0;
      }
    }
    &:hover,
    &:active,
    &:focus {
      background: $color-bg-light;
      color: $color-text;
      text-decoration: none;
    }
    &:not(a):hover,
    &:not(a):active,
    &:not(a):focus {
      background: $color-bg-white;
    }
    &.is-action-btn {
      align-items: center;
      color: $color-primary;
      display: flex;
      flex-direction: column;
      font-weight: bold;
      justify-content: center;
      padding-bottom: $spacing;
      padding-top: $spacing;
    }
    &__day_calendar {
      flex: 1 0 auto;
      margin-right: $spacing;
    }
    &__body {
      flex: 1 1 100%;
      &:not(:first-child) {
        border-left: 1px solid $color-border;
        padding-left: $spacing;
      }
    }
    &__title {
      font-size: $font-size-listview-title;
      font-weight: bold;
      margin: 0;
    }
    &__meta {
      color: $color-muted;
      font-size: 0.9rem;
      margin: 0;
    }
    &__summary {
      margin: $spacing-sm 0 0;
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
  &::after {
    // 最後の行の配置がおかしくなる問題を解消
    content: '';
    height: 0;
    width: $listview-item-width;
  }
}
</style>
