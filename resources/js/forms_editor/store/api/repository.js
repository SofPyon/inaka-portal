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

let is_processing = false;
let queued_count = 0;

axios.interceptors.request.use((config) => {
    vm.$store.commit('status/' + SET_SAVING)
    ++queued_count
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
        queued_count = Math.max(0, queued_count - 1)
        console.log(queued_count)
        if (queued_count === 0) {
            vm.$store.commit('status/' + SET_SAVED)
        }
        return response
    },
    // リクエスト失敗時
    (error) => {
        queued_count = Math.max(0, queued_count - 1)
        vm.$store.commit('status/' + SET_ERROR)
        throw error
    }
)

export default axios
