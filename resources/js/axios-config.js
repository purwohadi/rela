import axios from 'axios'
import Swal from 'sweetalert2'
// require('./vendor/sweet-alert')

/**
 * Axios config
 */
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

axios.interceptors.response.use(
  response => {
    catchSupportId(response)
    return response
  },
  error => {
    return Promise.reject(responseValidate(error))
  }
)

function responseValidate(error) {
  if (!error.response) {
    return 'server not responding'
  }
  if (error.response.status == 401) {
    window.location.href = '/login' //just redirect to login page
    return 'API Token Expire'
  }
  if (error.response.status == 403) { //not authorized
    return 'Access Denied'
  }
  if (error.response.status == 419) { //session expire
    window.location.href = '/login' //just redirect to login page
    return 'Refresh page!'  //CSRF Token Expoire
  }

  return error
}

function catchSupportId({ status, data }) {
  if (
    status == '200'
    && JSON.stringify(data).toLowerCase().includes('the requested url was rejected')
  ) {
    const { title, text } = strippingSupportIdResponse(data)
    window.swal.fire(title, text, 'error')
  }
}

function strippingSupportIdResponse(html) {
  let title = 'Request Rejected',
      tail = '[Go Back]',
      temp = document.createElement('div')

  temp.innerHTML = html
  let cleanText = temp.textContent || temp.innerText
  return {
    title,
    text: cleanText
      .replace(title, '')
      .replace(tail, '')
      .split('.')
      .map((text, idx, row) => idx == row.length - 1
        ? `<br><br><strong style="color: #0a6ebd">${text}</strong>`
        : `${text}. `
      )
      .join('')
  }
}

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}

export { axios }
