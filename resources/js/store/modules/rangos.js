
const state = () => ({
    all: null,
    selected: null
});

const getters = {
    getAll(state){
        return state.all;
    }
};

const actions = {
    loadData({commit}){
        const response = axios.get(route('rango.all')).then(response => {
            commit('UPDATE_RANGES', response.data);
        })
    },
    add({commit}, rango){
        commit('NEW_RANGO', rango);
    },
    update({commit}, rango){
        commit('UPDATE_RANGO', rango);
    }
}

const mutations = {
    UPDATE_RANGES(state, rangos){
        state.all = rangos;
    },
    NEW_RANGO(state, rango){
        state.all.push(rango);
    },
    UPDATE_RANGO(state, rango){
        state.all = state.all.map(record => record.id == rango.id ? rango : record);
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
