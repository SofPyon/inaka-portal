import Axios from 'axios';
import vm from '../../'
import { SET_SAVING, SET_SAVED, SET_ERROR } from '../status'

const baseURL = JSON.parse(document.querySelector('#forms-editor-config').dataset.apiBaseUrl);

const axios = Axios.create({
    baseURL: baseURL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }
})

const MAX_REQUEST_COUNT = 1;
let pending_requests = 0;

axios.interceptors.request.use((config) => {
    vm.$store.commit('status/' + SET_SAVING)
    return new Promise((resolve) => {
        const interval = setInterval(() => {
            if (pending_requests < MAX_REQUEST_COUNT) {
                ++pending_requests
                clearInterval(interval)
                resolve(config)
            }
        }, 10)
    })
})

axios.interceptors.response.use(
    // リクエスト成功時
    (response) => {
        pending_requests = Math.max(0, pending_requests - 1)
        if (pending_requests === 0) {
            vm.$store.commit('status/' + SET_SAVED)
        }
        return response
    },
    // リクエスト失敗時
    (error) => {
        pending_requests = Math.max(0, pending_requests - 1)
        vm.$store.commit('status/' + SET_ERROR)
        throw error
    }
)

export default axios
