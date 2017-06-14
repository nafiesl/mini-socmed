import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        notifications: []
    },
    getters: {
        allNotifications(state) {
            return state.notifications
        },
        allNotificationsCount(state) {
            return state.notifications.length
        }
    },
    mutations: {
        addNotification(state, notif) {
            state.notifications.push(notif)
        }
    }
})