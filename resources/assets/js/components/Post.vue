<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <textarea rows="4" class="form-control" v-model="content"></textarea>
                    <br>
                    <button class="btn btn-success pull-right" :disabled="not_working" @click="create_post">Create post</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let baseURL = document.head.querySelector('meta[name="base-url"]').content;
    export default {
        mounted () {

        },
        data () {
            return {
                content: '',
                not_working: true
            }
        },
        methods: {
            create_post() {
                axios.post(baseURL + '/api/posts', { content: this.content })
                    .then((response) => {
                        this.content = ''
                        noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: 'Your post has been published.',
                            timeout: 3000
                        })
                        let newPost = response.data;
                        this.$store.commit('addPost', newPost)
                    })
            }
        },
        watch: {
            content() {
                if (this.content.length > 0)
                    this.not_working = false
                else
                    this.not_working = true
            }
        }
    }
</script>