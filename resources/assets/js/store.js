import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        notifications: [],
        posts: []
    },
    getters: {
        allNotifications(state) {
            return state.notifications
        },
        allNotificationsCount(state) {
            return state.notifications.length
        },
        allPosts(state) {
            return state.posts
        }
    },
    mutations: {
        addNotification(state, notif) {
            state.notifications.push(notif)
        },
        pushPosts(state, posts) {
            state.posts = state.posts.concat(posts)
        },
        addPost(state, post) {
            state.posts.unshift(post)
        },
        addLikeToPost(state, payload) {
            payload.post.likers.push(payload.user)
        },
        removeLikeFromPost(state, payload) {
            let likerIndex = payload.post.likers.indexOf(payload.user)
            payload.post.likers.splice(likerIndex, 1)
        }
    }
})