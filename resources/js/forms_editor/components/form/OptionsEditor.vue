<template>
  <div>
    <ul v-if="options">
      <li v-for="option in options" :key="option.id">
        {{ option.value }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    options: {
      // {id, value, priority}
      type: Array,
      default: () => []
    }
  }
}
</script>

<style lang="scss" scoped></style>
