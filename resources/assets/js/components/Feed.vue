<template>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default" v-for="post in posts">
                <div class="panel-heading">
                    <small class="pull-right">{{ post.published }}</small>
                    <h3 class="panel-title">{{ post.user.name }}</h3>
                </div>
                <div class="panel-body">
                    {{ post.content }}
                </div>
                <like :post="post" :current_user_id="current_user_id"></like>
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
                        response.data.forEach((post) => {
                            this.$store.commit('addPost', post)
                        })
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