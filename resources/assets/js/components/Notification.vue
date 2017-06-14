<template>
    <div></div>
</template>

<script>
    export default {
        mounted() {
            this.listen();
        },
        props: ['id'],
        methods: {
            listen() {
                Echo.private('App.User.' + this.id)
                    .notification((notification) => {
                        noty({
                            type: 'success',
                            layout: 'bottomLeft',
                            text: notification.message,
                            timeout: 3000
                        })
                        this.$store.commit('addNotification', notification)
                        document.getElementById('noty_audio').play()
                    })
            }
        }
    }
</script>