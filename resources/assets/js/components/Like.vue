<template>
    <div class="panel-footer">
        <span class="badge" v-for="liker in likers">{{ liker.id }} </span>
        <br>
        <button class="btn btn-danger btn-xs" v-if="currentUserIsLiker">Unlike</button>
        <button class="btn btn-success btn-xs" v-else>Like</button>
    </div>
</template>

<script>
    export default {
        mounted() {
        },
        props: ['post', 'current_user_id'],
        computed: {
            likers() {
                return this.post.likers
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
        }
    }
</script>