<template>
    <span class="label label-success" title="Online Users">
        {{ this.count }} <slot></slot>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                count: 0
            }
        },
        mounted() {
            this.listen();
        },
        methods: {
            listen() {
                Echo.join('online-users')
                    .here((users) => {
                        this.count = users.length
                    })
                    .joining(user => this.count++)
                    .leaving(user => this.count--);
            }
        }
    }
</script>