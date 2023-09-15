import axios from 'axios'

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: {},
        token: ''
    },
    getters: {
        authenticated: state => state.authenticated,
        user: state => state.user,
        token: state => state.token
    },
    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value
        },
        SET_USER(state, value) {
            state.user = value
        },
        SET_TOKEN(state, value) {
            state.token = value
        }

    },
    actions: {
        login({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios.post(`${process.env.MIX_APP_URL}/api/v1/login`, params).then(response => {
                    commit('SET_USER', response.data.user)
                    commit('SET_TOKEN', response.data.access_token)
                    commit('SET_AUTHENTICATED', true)
                    resolve(response)
                }).catch(error => {
                    commit('SET_USER', {})
                    commit('SET_AUTHENTICATED', false)
                    commit('SET_TOKEN', '')
                    reject(error)
                });
            })
        },

        logout({ commit }) {
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
            commit('SET_TOKEN', '')
        }
    }
}