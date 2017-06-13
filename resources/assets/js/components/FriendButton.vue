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
                            // noty({
                            //     type: 'success',
                            //     layout: 'bottomLeft',
                            //     text: 'Friend request sent .'
                            // })
                            this.loading = false
                    })
                this.loading = false
            },
            accept_friend() {
                this.loading = true
                // this.$http.get('/accept_friend/' + this.profile_user_id )
                //     .then( (r) => {
                //         if(r.body == 1)
                //             this.status = 'friends'
                //             noty({
                //                 type: 'success',
                //                 layout: 'bottomLeft',
                //                 text: 'You are now friend. Go ahead and hangout .'
                //             })
                //             this.loading = false
                //     })
                this.loading = false
            },
            remove_friend() {
                this.loading = true
                this.status = '0'
                // this.$http.get('/accept_friend/' + this.profile_user_id )
                //     .then( (r) => {
                //         if(r.body == 1)
                //             this.status = 'friends'
                //             noty({
                //                 type: 'success',
                //                 layout: 'bottomLeft',
                //                 text: 'You are now friend. Go ahead and hangout .'
                //             })
                //             this.loading = false
                //     })
                this.loading = false
            }
        }
    }
</script>
