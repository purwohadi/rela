window._ = require('lodash')
window.moment = require('moment')
require('typeface-poppins')

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// window.axios = require('axios')
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

window.doLogout = (e) => {
  e.preventDefault()
  document.getElementById('logout-form').submit()
}

let jsonSettings = document.querySelector(
  '[data-settings-selector="settings-json"]'
)
window.settings = jsonSettings ? JSON.parse(jsonSettings.textContent) : {}

import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')

window.Echo = new Echo({
  // broadcaster: 'pusher',
  // key: process.env.MIX_PUSHER_APP_KEY,
  // // cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  // forceTLS: false,
  // wsHost: 'websocket.jakarta.go.id', //window.location.hostname,
  // wsPort: 80,
  // wssPort: 443,
  // forceTLS: true,
  // encrypted: true,
  // disableStats: true
  // broadcaster: 'pusher',
  // key: process.env.MIX_PUSHER_APP_KEY,
  // wsHost: '10.15.34.12', //'websocket.jakarta.go.id', //window.location.hostname,
  // wsPort: 6001,
  // forceTLS: false,
  // disableStats: true
})

// console.log('echo', window.Echo)
