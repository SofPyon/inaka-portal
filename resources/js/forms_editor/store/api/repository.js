import Axios from 'axios';

const baseURL = JSON.parse(document.querySelector('#forms-editor-config').dataset.apiBaseUrl);

export default Axios.create({
    baseURL: baseURL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    }
})
