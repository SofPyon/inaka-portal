import Vue from 'vue'
import GlobalEvents from 'vue-global-events'

export default new Vue({
  el: '#v2-app',
  components: {
    GlobalEvents
  },
  data() {
    return {
      isDrawerOpen: false
    }
  },
  methods: {
    toggleDrawer() {
      this.isDrawerOpen = !this.isDrawerOpen
    },
    closeDrawer() {
      this.isDrawerOpen = false
    }
  }
})
