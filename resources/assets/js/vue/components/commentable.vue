<template>
    <div id="comments">
        <div class="comment-form padded">
            <h3>Comments <span v-if="comments.length">({{ comments.length }})</span></h3>

            <form class="ui reply form" method="post">
                <div class="field" id="commentInputField">
                    <div class="ui dimmer">
                        <div class="ui text loader"></div>
                    </div>
                    <textarea v-model="comment_text"
                              rows="3"
                              v-on:keydown="handleCmdEnter($event)"
                              id="commentInput"
                    ></textarea>
                </div>
                <button class="ui blue labeled small submit icon button" @click="sendComment" v-if="comment_text.length">
                    <i class="icon edit"></i> Send
                    <small>[Ctrl+Enter]</small>
                </button>
                <a class="ui small submit icon button" id="uploadImage" title="Upload image">
                    <i class="save icon"></i>
                </a>
            </form>
        </div>

        <div class="ui comments padded" v-if="comments.length">
            <div class="comment padded small"
                 :class="{ 'deleted': comment.deleted }"
                 v-for="comment in comments"
                 id="comment{{ comment.id }}"
            >
                <div class="avatar ui circular image">
                    <img :src="comment.user.data.links.avatar" />
                </div>
                <div class="content">
                    <a class="author user-link" href="{{ comment.user.data.links.profile }}" data-id="{{ comment.user.data.id }}">
                        {{ comment.user.data.name }}
                    </a>

                    <div class="metadata">
                        <time class="date">{{ comment.created_at | formated 'lll' }}</time>
                    </div>

                    <div v-if="comment.deleted">
                        <div class="text">
                            Comment deleted
                        </div>
                    </div>

                    <div v-if="!comment.deleted">
                        <div class="text" style="margin-bottom: 20px">
                            {{{ comment.comment }}}
                        </div>
                        <div class="actions">
                            <likeable :id="comment.id" type="comments" :likes="comment.likes.count"></likeable>

                            <a @click="deleteComment(comment)" v-if="canDelete(comment)">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                coerce (val) {
                    return parseInt(val);
                },
                required: true
            },
            type: {
                type: String,
                required: true
            },
        },
        data: {
            comment_text: '',
            comments: [],
            reply_comment: null
        },
        created () {
            this.getComments()
        },
        ready () {
            var self = this;

            Pusher.on('comments', 'App\\Events\\CommentCreated', (data) => {
                if(data.commentable_id == self.id && data.commentable_type == self.type && data.author_id !== User.getId()) {
                    self.addComment(data.id);
                }
            })
            this.initFileUpload()
        },
        methods: {
            addComment (commentId) {
                this.$http.get('comment/' + commentId).then(response => {
                    this.comments.unshift(response.data.data)
                })
            },
            getComments () {
                this.$http.get('comments', {params: {id: this.id, type: this.type}}).then(response => {
                    this.$set('comments', _.values(response.data.data))
                })
            },
            handleCmdEnter (event) {
                if ((event.metaKey || event.ctrlKey) && event.keyCode == 13) {
                    this.sendComment(event);
                }
            },
            sendComment (event) {
                event.preventDefault()

                this.$http.post('comment/write', {comment: this.comment_text, to: {
                    id: this.id, type: this.type
                }}).then(response => {
                    if(response.data) {
                        this.getComments()
                        this.comment_text = ''
                    }
                })
            },
            deleteComment (comment) {
                this.$http.delete('comment/'+comment.id).then(() => {
                    this.getComments()
                })
            },
            canDelete (comment) {
                return true
            },
            canRestore (comment) {
                return true
            },
            isOwner (comment) {
                return comment.user_id = User.getId()
            },
            initFileUpload () {
                var self = this;

                $("#uploadImage").dropzone({
                    url: '/api/upload/image',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': window.settings.token
                    },
                    uploadMultiple: false,
                    previewsContainer: false,
                    acceptedFiles: 'image/*',
                    success (file, response) {
                        if (response) {
                            var text = self.comment_text || '';

                            self.$set(
                                'comment_text',
                                text + ' ![' + response.name + '](' + response.file_url + ')'
                            );
                        }
                    }
                });
            }
        }
    }
</script>