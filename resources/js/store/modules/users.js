const VACIO = null;

const state = () => ({
    all: null,
    byRange: null,
    selected: null,
    loading: false
});

const getters = {
    getAll(state) {
        return state.all;
    },
    getUsersByRange(state) {

        if (state.loading == true || state.byRange == VACIO) return;

        return state.byRange.map(user => {
            user.nombre_completo = `[${user.cedula}] ${user.apellido_paterno} ${user.apellido_materno} ${user.nombres}`;
            return user;
        });

    }
};

const actions = {
    loadData({commit}) {
        const response = axios.get(route('user.all')).then(response => {
            commit('UPDATE_USERS', response.data);
        });
    },
    async loadUsersByRanges({commit, state}, range) {
        state.loading = true;

        await axios.get(route('rango.user', range)).then(response => {
            commit('UDPATE_USERS_BY_RANGE', response.data);
            state.loading = false;
        });
    },
    add({commit}, user) {
        commit('NEW_USER', user);
    },
    update({commit}, user) {
        commit('UPDATE_USER', user);
    },
    deleteUsersByRanges({commit}) {
        commit('DELETE_USERS_BY_RANGES');
    }
}

const mutations = {
    UPDATE_USERS(state, users) {
        state.all = users;
    },
    UDPATE_USERS_BY_RANGE(state, users) {
        state.byRange = users;
    },
    NEW_USER(state, user) {
        state.all.push(user);
    },
    UPDATE_USER(state, user) {
        state.all = state.all.map(record => record.id == user.id ? user : record);
    },
    DELETE_USER_BY_RANGES(state) {
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
