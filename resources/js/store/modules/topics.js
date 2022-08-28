const state = () => ({
  savedTopics: [],
})

const getters = {
  getItem(state) {
    return state.savedTopics
  },
}

const actions = {
  setItem(context, topics) {
    if (topics.length) {
      context.commit('SET_ITEM', topics)
    }
  },
}

const mutations = {
  SET_ITEM(state, payload) {
    state.savedTopics = payload
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
