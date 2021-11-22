const state = () => ({
    selectedChair: null
});

const getters = {
    getSelectedChair(state){
        return state.selectedChair;
    }
};

const actions = {
    setSelectedChair({commit}, chair){
        commit('UPDATE_SELECTED_CHAIR', chair);
    }
};

const mutations = {
    UPDATE_SELECTED_CHAIR(state, chair) {
        state.selectedChair = chair;
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};

