import Vue from 'vue'
import GlobalEvents from 'vue-global-events'

import TopAlert from './components/TopAlert.vue'
import ListView from './components/ListView.vue'
import ListViewItem from './components/ListViewItem.vue'
import ListViewActionBtn from './components/ListViewActionBtn.vue'
import ListViewEmpty from './components/ListViewEmpty.vue'

export default new Vue({
  el: '#v2-app',
  components: {
    GlobalEvents,
    TopAlert,
    ListView,
    ListViewItem,
    ListViewActionBtn,
    ListViewEmpty
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
  },
  watch: {
    isDrawerOpen(newVal) {
      // アクセシビリティのため、適切な位置にフォーカスする
      if (newVal) {
        this.$refs.drawer.focus()
      } else {
        this.$refs.toggle.focus()
      }
    }
  }
})
