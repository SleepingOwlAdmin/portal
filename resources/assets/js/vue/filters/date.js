Vue.filter('relative', (value) => moment(value).local().fromNow())
Vue.filter('formated', (value, format) => moment(value).format(
    format || window.settings.config.data.format
))