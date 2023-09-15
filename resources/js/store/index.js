import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/store/auth'
import board from '@/store/task/board'

Vue.use(Vuex)

export default new Vuex.Store({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        board
    }
})