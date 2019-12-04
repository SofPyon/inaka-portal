export const SAVE_STATUS_INIT = 'init';
export const SAVE_STATUS_DIRTY = 'dirty';
export const SAVE_STATUS_SAVING = 'saving';
export const SAVE_STATUS_SAVED = 'saved';

export const SET_SAVING = 'SET_SAVING';
export const SET_SAVED = 'SET_SAVED';
export const SET_ERROR = 'SET_ERROR';

export default {
    namespaced: true,
    state: {
        save_status: SAVE_STATUS_INIT,
        is_error: false,
    },
    mutations: {
        [SET_SAVING](state) {
            state.save_status = SAVE_STATUS_SAVING;
        },
        [SET_SAVED](state) {
            state.save_status = SAVE_STATUS_SAVED;
        },
        [SET_ERROR](state) {
            state.is_error = true;
        },
    }
}
