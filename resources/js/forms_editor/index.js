import Vue from 'vue';
import Vuex from 'vuex';
import EditorApp from './EditorApp.vue';
import store from './store';

Vue.use(Vuex);

Vue.component('editor-app', EditorApp);

const editorApp = new Vue({
    el: '#forms-editor-container',
    store,
    template: '<editor-app />',
});
