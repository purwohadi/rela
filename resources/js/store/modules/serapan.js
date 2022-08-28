const state = () => ({
  items: [],
})

const getters = {
  getItems: state => state.items
}

function findItem(state, slug_path) {
  let idx = state.items.findIndex(item => item.slug_path === slug_path)
  if (idx === -1) return false

  return state.items[idx]
}

const actions = {
  findBySlug: ({ state }, slug_path) => findItem(state, slug_path),
  setItem({ state, commit }, payload) {
    if (!findItem(state, payload.slug_path)) {
      commit('SET_ITEM', payload)
    }
  }
}

const mutations = {
  SET_ITEM: (state, payload) => state.items.push(payload)
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
