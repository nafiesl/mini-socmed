<template>
    <span>
        <button class="btn btn-danger btn-xs" :disabled="disableLike" v-if="currentUserIsLiker" @click="unlike(post)">Unlike</button>
        <button class="btn btn-success btn-xs" :disabled="disableLike" v-else @click="like(post)">Like</button>
        <span class="badge" v-for="liker in likers">{{ liker.id }} </span>
    </span>
</template>

<script>
    let baseURL = document.head.querySelector('meta[name="base-url"]').content;
    export default {
        mounted() {
        },
        data() {
            return {
                disableLike: false
            }
        },
        props: ['post', 'current_user_id'],
        computed: {
            likers() {
                return this.post.likers
            },
            anyLikers() {
                return this.likers.length > 0
            },
            currentUserIsLiker() {
                let likerIds = [];
                this.likers.forEach((liker) => {
                    likerIds.push(liker.id)
                })

                let hasLiked = likerIds.indexOf(this.current_user_id);

                if (hasLiked === -1)
                    return false
                else
                    return true
            }
        },
        methods: {
            like(post) {
                this.disableLike = true
                axios.post(baseURL + '/api/like/' + post.id)
                    .then((response) => {
                        this.$store.commit('addLikeToPost', {post: post, user: response.data});
                        this.disableLike = false
                    })
            },
            unlike(post) {
                this.disableLike = true
                axios.post(baseURL + '/api/like/' + post.id)
                    .then((response) => {
                        this.$store.commit('removeLikeFromPost', {post: post, user: response.data});
                        this.disableLike = false
                    })
            }
        }
    }
</script>