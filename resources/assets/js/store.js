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
        addPost(state, post) {
            state.posts.unshift(post)
        }
    }
})