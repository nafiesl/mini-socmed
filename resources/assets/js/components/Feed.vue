<template>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default" v-for="post in posts">
                <div class="panel-heading">
                    <small class="pull-right">{{ post.published }}</small>
                    <h3 class="panel-title">{{ post.user.name }}</h3>
                </div>
                <div class="panel-body">
                    {{ post.content }}
                </div>
                <div class="panel-footer">
                    <like :post="post" :current_user_id="current_user_id"></like>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let baseURL = document.head.querySelector('meta[name="base-url"]').content;
    export default {
        mounted() {
            this.getFeed()
        },
        props: ['current_user_id'],
        components: ['like'],
        methods: {
            getFeed() {
                axios.get(baseURL + '/api/posts')
                    .then((response) => {
                        this.$store.commit('pushPosts', response.data)
                    })
            }
        },
        computed: {
            posts() {
                return this.$store.getters.allPosts
            }
        }
    }
</script>