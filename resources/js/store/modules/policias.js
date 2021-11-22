
const VACIO = null;

const state = () => ({
    all: null,
    byRange: null,
    selected: null,
    loading: false
});

const getters = {
    getAll(state){
        return state.all;
    },
    getPoliciesByRange(state){

        if(state.loading == true || state.byRange == VACIO) return;

        return state.byRange.map(policie => {
            policie.nombre_completo = `[${policie.cedula}] ${policie.apellido_paterno} ${policie.apellido_materno || ''} ${policie.nombres}`;
            return policie;
        });

    }
};

const actions = {
    loadData({commit}){
        const response = axios.get(route('policia.all')).then(response => {
            commit('UPDATE_POLICES', response.data);
        });
    },
    async loadPoliciesByRanges({commit, state}, range){
        state.loading = true;

        await axios.get(route('rango.policia', range)).then(response => {
            commit('UDPATE_POLICIES_BY_RANGE',  response.data);
            state.loading = false;
        });
    },
    add({commit}, policia){
        commit('NEW_POLICE', policia);
    },
    update({commit}, policia){
        commit('UPDATE_POLICE', policia);
    },
    deletePoliciesByRanges({commit}){
        commit('DELETE_POLICIES_BY_RANGES');
    }
}

const mutations = {
    UPDATE_POLICES(state, policias){
        state.all = policias;
    },
    UDPATE_POLICIES_BY_RANGE(state, policias){
        state.byRange = policias;
    },
    NEW_POLICE(state, policia){
        state.all.push(policia);
    },
    UPDATE_POLICE(state, policia){
        state.all = state.all.map(record => record.id == policia.id ? policia : record);
    },
    DELETE_POLICIES_BY_RANGES(state){
        state.byRange = null;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
