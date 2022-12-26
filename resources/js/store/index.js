import * as Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import auth from '@/store/auth';
import choice from '@/store/choice';
// import storePlugins from "@/plugins/storePlugins";

export default new Vuex.Store({
    plugins:[
        createPersistedState(),
        // storePlugins
    ],
    modules:{
        auth,
        choice
    }
})
