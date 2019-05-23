import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import editor from './editor';

const store = new Vuex.Store({
    modules: {
        editor,
    }
});

export default store;
