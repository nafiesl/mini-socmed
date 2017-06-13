<template>
    <div>
        <p class="text-center" v-if="loading">
            Loading...
        </p>
        <p class="text-center" v-if="!loading">
            <button class="btn btn-success" v-if="status == 0" @click="add_friend">Add Friend</button>
            <button class="btn btn-success" v-if="status == 'pending'" @click="accept_friend">Accept Friend</button>
            <span class="text-success" v-if="status == 'waiting'">Waiting for response</span>
            <button class="btn btn-success" v-if="status == 'friends'" @click="remove_friend">Remove Friend</button>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('http://localhost/lv/riset/socmed/public/friendships/check/' + this.current_user_id + '/' + this.profile_user_id )
                .then( (resp) => {
                    console.log(resp)
                    this.status = resp.data.status
                    this.loading = false
                })
        },
        props: ['current_user_id', 'profile_user_id'],
        data() {
            return {
                status: '',
                loading: true
            }
        },
        methods: {
            add_friend() {
                this.loading = true
                axios.post('http://localhost/lv/riset/socmed/public/friendships/request/' + this.current_user_id + '/' + this.profile_user_id )
                    .then( (r) => {
                        if(r.data.status == 'waiting')
                            this.status = r.data.status
                            this.loading = false
                    })
                this.loading = false
            },
            accept_friend() {
                this.loading = true
                axios.post('http://localhost/lv/riset/socmed/public/friendships/accept/' + this.current_user_id + '/' + this.profile_user_id )
                    .then( (r) => {
                        if(r.data.status == 'friends')
                            this.status = 'friends'
                            this.loading = false
                    })
                this.loading = false
            },
            remove_friend() {
                this.loading = true
                axios.post('http://localhost/lv/riset/socmed/public/friendships/remove/' + this.current_user_id + '/' + this.profile_user_id )
                    .then( (r) => {
                        if(r.data.status == 0)
                            this.status = 0
                            this.loading = false
                    })
                this.loading = false
            }
        }
    }
</script>
