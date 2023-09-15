import axios from 'axios'

export default {
    namespaced: true,
    state: {
        tasks: [],
    },
    getters: {
        tasks: state => state.tasks,
    },
    mutations: {
        SET_TASKS(state, value) {
            state.tasks = value
        }

    },
    actions: {
        fetchTaskData({ commit, rootGetters }, params) {
            const token = rootGetters['auth/token'];
            return axios.get(`${process.env.MIX_APP_URL}/api/v1/tasks`,
                { headers: { Authorization: `Bearer ${token}` } }
            ).then(({ data }) => {
                commit('SET_TASKS', data.data);
            }).catch(({ response: { data } }) => {
                commit('SET_TASKS', {})
            })
        },

        showTaskData({ commit, rootGetters }, params) {
            const token = rootGetters['auth/token'];
            return new Promise((resolve, reject) => {
                axios.get(`${process.env.MIX_APP_URL}/api/v1/tasks/${params}`,
                    { headers: { Authorization: `Bearer ${token}` } }
                ).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                });
            })
        },


        storeData({ commit, rootGetters }, params) {
            const token = rootGetters['auth/token'];
            return new Promise((resolve, reject) => {
                axios.post(`${process.env.MIX_APP_URL}/api/v1/tasks`, params,
                    { headers: { Authorization: `Bearer ${token}` } }
                ).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                });
            })
        },
        updateData({ commit, rootGetters }, params) {
            const token = rootGetters['auth/token'];
            return new Promise((resolve, reject) => {
                axios.put(`${process.env.MIX_APP_URL}/api/v1/tasks/${params.id}`, params,
                    { headers: { Authorization: `Bearer ${token}` } }
                ).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                });
            })
        },

        sortData({ commit, rootGetters }, params) {
            const token = rootGetters['auth/token'];
            return new Promise((resolve, reject) => {
                axios.post(`${process.env.MIX_APP_URL}/api/v1/tasks/sort`, params,
                    { headers: { Authorization: `Bearer ${token}` } }
                ).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                });
            })
        },


        destroyData({ commit, rootGetters }, params) {
            const token = rootGetters['auth/token'];
            return new Promise((resolve, reject) => {
                axios.delete(`${process.env.MIX_APP_URL}/api/v1/tasks/${params}`,
                    { headers: { Authorization: `Bearer ${token}` } }
                ).then(response => {
                    resolve(response)
                }).catch(error => {
                    reject(error)
                });
            })
        },

        updateTaskData({ commit, rootGetters }, params) {
            const token = rootGetters['auth/token'];
            return axios.put(`${process.env.MIX_APP_URL}/api/v1/tasks/${params.id}`, params,
                { headers: { Authorization: `Bearer ${token}` } }
            ).then(({ data }) => {
                // commit('SET_TASKS', data.data);
            }).catch(({ response: { data } }) => {
                // commit('SET_TASKS',{})
            })
        },

    }
}