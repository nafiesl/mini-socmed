<template>
    <li>
        <a id="unread-notif-link" href="#">
            Unread <span class="badge">{{ allNotificationsCount }}</span>
        </a>
    </li>
</template>

<script>
    let baseURL = document.head.querySelector('meta[name="base-url"]').content;
    export default {
        mounted () {
            $('#unread-notif-link').attr('href', baseURL + '/notifications');
            this.getUnreadNotifications()
        },
        methods: {
            getUnreadNotifications() {
                axios.get(baseURL + '/notifications/unread')
                    .then( (notifications) => {
                        notifications.data.forEach( (notif) => {
                            this.$store.commit('addNotification', notif)
                        })
                    })
            }
        },
        computed: {
            allNotificationsCount() {
                return this.$store.getters.allNotificationsCount
            }
        }
    }
</script>