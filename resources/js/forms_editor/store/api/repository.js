import Axios from 'axios';

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
        return response
    },
    // リクエスト失敗時
    (error) => {
        pending_requests = Math.max(0, pending_requests - 1)
        throw error
    }
)

export default axios
