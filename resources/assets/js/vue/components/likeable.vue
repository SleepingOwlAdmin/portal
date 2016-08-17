<template>
    <a @click="like()"> <i class="heart animated icon" :class="[size, class_color]"></i> {{ likes }} </a>
</template>

<script>
    export default {
        props: {
            id: {
                coerce (val) {
                    return parseInt(val)
                },
                required: true
            },
            type: {
                type: String,
                required: true
            },
            likes: {
                default: 0
            },
            size: {
                type: String,
                default: ''
            },
            color: {
                type: String,
                default: 'red'
            }
        },
        ready () {
            var self = this;

            Pusher.on('liked', data => {
                if(data.likeable_id == self.id && data.likeable_type == self.type && data.user_id !== User.getId()) {
                    self.setLikes(data.likes)
                }
            })
        },
        methods: {
            like () {
                if(!User.isLoggedIn()) {
                    return;
                }

                this.$http.post('like', {id: this.id, type: this.type}).then(response => {
                    this.setLikes(response.data)
                })
            },
            setLikes (likes) {
                var $icon = $(this.$el).find('.icon')

                $icon.addClass('bounceIn')
                window.setTimeout(() => {
                    $icon.removeClass('bounceIn')
                }, 300)

                this.likes = likes.count || 0
            }
        },
        computed: {
            class_color () {
                return this.likes > 0 ? this.color : 'grey'
            }
        }
    }
</script>