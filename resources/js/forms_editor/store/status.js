export const SET_ERROR = 'SET_ERROR';

export default {
    namespaced: true,
    state: {
        is_error: false,
    },
    mutations: {
        [SET_ERROR](state) {
            state.is_error = true;
        },
    }
}
