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
        if (User.isLoggedIn()) {
            this.loadUserNotifications()

            var self = this;

            Pusher.on('private-App.User.' + User.getId(), notification => {
                self.loadUserNotification(notification.id)
            })
        }
    },
    methods: {
        showNotifications () {
            $('.sidebar-notifications').sidebar('setting', 'transition', 'overlay')
                .sidebar('toggle');

            this.markNotificationsAsRead()
        },

        loadUserNotifications () {
            $(".notification-item").fadeIn();
            this.$http.get('notifications').then(response => {
                this.notifications = response.data.data
            })
        },

        loadUserNotification (id) {
            this.$http.get('notification/'+id).then(response => {
                this.notifications.push(response.data.data)
            })
        },

        markNotificationsAsRead() {
            this.$http.put('notifications/read', {ids: _.pluck(this.notifications, 'id')})

            _.each(this.notifications, notification => {
                notification.read = true
            })
        }
    },
    computed: {
        unreadNotifications () {
            if (_.size(this.notifications) > 0) {
                return _.size(
                    _.filter(this.notifications, notification => {
                        return !notification.read
                    })
                )
            }

            return 0;
        },

        hasUnreadNotifications () {
            return this.unreadNotifications > 0
        },

        hasNotifications () {
            return _.size(this.notifications) > 0;
        }
    }
})