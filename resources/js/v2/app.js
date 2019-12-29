import Vue from 'vue'

export default new Vue({
  el: '#v2-app',
  data() {
    return {
      isDrawerOpen: false
    }
  },
  methods: {
    toggleDrawer() {
      this.isDrawerOpen = !this.isDrawerOpen
    }
  }
})
