window._ = require('underscore')

require('sweetalert2')

window.moment = require('moment')
moment.locale(window.settings.locale)

global.$ = global.jQuery = require('jquery')
window.User = require('./modules/jquery')

window.User = require('./modules/semantic')

window.Vue = require('vue')
require('vue-resource')

Vue.http.options.root = '/api'

Vue.http.interceptors.push((request, next) => {
    request.headers['X-CSRF-TOKEN'] = window.settings.token;

    next((response) => {
        switch (response.status) {
            case 200:
            case 202:
                break;
            default:
                sweetAlert(
                    'Something went wrong',
                    response.data.message,
                    'error'
                )
        }
    });
});

require('./vue/filters/date')

window.Pusher = require('./modules/pusher')
Pusher._init(window.settings.config.broadcast.host)

window.User = require('./modules/user')
User.init(window.settings.user)

window.Dropzone = require('dropzone')
Dropzone.autoDiscover = false