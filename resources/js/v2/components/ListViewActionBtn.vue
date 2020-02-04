<template>
  <list-view-item :href="href" class="action-btn">
    <slot />
  </list-view-item>
</template>

<script>
import ListViewItem from './ListViewItem.vue'

export default {
  components: {
    ListViewItem
  },
  props: {
    href: {
      type: String,
      default: null
    }
  }
}
</script>

<style lang="scss" scoped>
.action-btn {
  align-items: center;
  color: $color-primary;
  display: flex;
  flex-direction: column;
  font-weight: bold;
  justify-content: center;
  padding-bottom: $spacing;
  padding-top: $spacing;
  &:hover,
  &:active,
  &:focus {
    color: $color-primary;
  }
}
</style>
