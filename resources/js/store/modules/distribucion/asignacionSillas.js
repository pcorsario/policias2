
const state = () => ({
   all: null
});

const getters = {
    getAll(state){
        return state.all;
    },
    getByMesa: (state) => (idMesa) => {
        return state.all?.filter(asignacion => asignacion?.idMesa == idMesa);
    }
};

const actions = {
    async loadAll({commit}){
        const response =  await axios.get(route('mesa.sillas.asinadas'));
        commit('UPDATE_ASIGNACIONES', response.data);

    },
    asignarSillaAPolicia({commit}, asignacion){
        commit('NEW_ASIGNACION', asignacion);
    },
    update({commit}, idSilla, idPolicia){
        commit('UPDATE_ASIGNACION', policia);
    },
    delete({commit}, idAsignacion){
        commit('DELETE_ASIGNACION', idAsignacion);
    }
}

const mutations = {
    NEW_ASIGNACION(state, asignacion){
        state.all.push(asignacion);
    },
    UPDATE_ASIGNACIONES(state, asignaciones){
        state.all = asignaciones;
    },
    DELETE_ASIGNACION(state, idAsignacion){
        state.all = state.all.filter(asignacion => asignacion.idSP !== idAsignacion);
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
