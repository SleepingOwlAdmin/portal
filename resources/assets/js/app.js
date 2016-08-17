require('./bootstrap')

Vue.component('likeable', require('./vue/components/likeable.vue'))
Vue.component('commentable', require('./vue/components/commentable.vue'))

var app = new Vue({
    el: 'body',
    data() {
        return {
            notifications: []
        }
    },
    created () {
        User.isLoggedIn() && this.loadDataForAuthenticatedUser()
    },
    methods: {
        showNotifications () {
            $('.sidebar-notifications').sidebar('setting', 'transition', 'overlay').sidebar('toggle')
            this.markNotificationsAsRead()
        },
        loadDataForAuthenticatedUser () {
            this.getNotifications()
        },

        getNotifications () {
            var self = this;

            $('.notification-item').fadeIn()

            this.$http.get('notifications').then(response => {
                this.notifications = response.data.data
            })

            Pusher.on('user.' + User.getId(), 'App\\Events\\NotificationCreated', data => {
                data.notification.read = fase
                self.notifications.unshift(data.notification)
            })
        },
        markNotificationsAsRead () {
            if (!this.hasUnreadNotifications) {
                return
            }

            this.$http.get('notifications/read', {ids: _.pluck(this.notifications, 'id')}).then(response => {
                _.each(this.notifications, notification => {
                    notification.read = true
                })
            })
        }
    },
    computed: {
        unreadNotifications () {
            if (this.notifications) {
                return _.filter(this.notifications, notification => {
                    return !notification.read
                }).length
            }

            return 0
        },
        hasNotifications () {
            return this.notifications.length
        },
        hasUnreadNotifications () {
            return this.unreadNotifications > 0
        },
    }
})