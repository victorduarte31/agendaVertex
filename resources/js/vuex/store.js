import Vue from 'vue'
import Vuex from 'vuex'

import agenda from './modules/agenda/agenda'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        agenda,
    }
});
