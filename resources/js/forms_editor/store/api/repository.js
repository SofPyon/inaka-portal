import Axios from 'axios';
import vm from '../../'
import { SET_SAVING, SET_SAVED, ENQUEUED, DEQUEUED, SET_ERROR } from '../status'

const baseURL = JSON.parse(document.querySelector('#forms-editor-config').dataset.apiBaseUrl);

const axios = Axios.create({
    baseURL: baseURL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }
})

let is_processing = false;

// TODO: getリクエストの時に「保存中」とか出てこないようにする
axios.interceptors.request.use((config) => {
    vm.$store.commit('status/' + SET_SAVING)
    vm.$store.commit('status/' + ENQUEUED)
    return new Promise((resolve) => {
        const interval = setInterval(() => {
            if (!is_processing) {
                is_processing = true
                clearInterval(interval)
                resolve(config)
            }
        }, 10)
    })
})

axios.interceptors.response.use(
    // リクエスト成功時
    (response) => {
        is_processing = false
        vm.$store.commit('status/' + DEQUEUED)
        if (vm.$store.state.status.request_queued_count === 0) {
            vm.$store.commit('status/' + SET_SAVED)
        }
        return response
    },
    // リクエスト失敗時
    (error) => {
        vm.$store.commit('status/' + DEQUEUED)
        vm.$store.commit('status/' + SET_ERROR)
        throw error
    }
)

export default axios
