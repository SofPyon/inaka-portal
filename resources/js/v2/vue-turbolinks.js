/* eslint-disable eqeqeq */

/*!
 * jeffreyguenther/vue-turbolinks を一部改変したもの
 * https://github.com/jeffreyguenther/vue-turbolinks
 *
 * MIT License
 */

// リンククリック時にレイアウトが一瞬崩れたように見えてしまうため、
// $destory は実行しない。
// そのため、Vue の destroyed ライフサイクルメソッドは利用できない
// function handleVueDestructionOn(turbolinksEvent, vue) {
//   document.addEventListener(turbolinksEvent, function teardown() {
//     vue.$destroy();
//     document.removeEventListener(turbolinksEvent, teardown)
//   })
// }

function plugin(Vue) {
  // Install a global mixin
  Vue.mixin({
    beforeMount() {
      // If this is the root component, we want to cache the original element contents to replace later
      // We don't care about sub-components, just the root
      if (this == this.$root && this.$el) {
        // const destroyEvent =
        // this.$options.turbolinksDestroyEvent || 'turbolinks:visit'
        // handleVueDestructionOn(destroyEvent, this)
        this.$originalEl = this.$el.outerHTML
      }
    },

    destroyed() {
      // We only need to revert the html for the root component
      if (this == this.$root && this.$el) {
        this.$el.outerHTML = this.$originalEl
      }
    }
  })
}

export default plugin
