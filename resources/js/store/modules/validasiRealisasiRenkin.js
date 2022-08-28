const state = () => ({
  items: [],
})

const getters = {
  getItems(state) {
    return state.items
  },
}

const actions = {
  setItem(context, { item }) {
    if (item.length) {
      context.commit('SET_ITEM', { item })
    }
  },
  setItemByKey(context, payload) {
    context.commit('SET_ITEM_BY_KEY', payload)
  },
}

const mutations = {
  SET_ITEM(state, payload) {
    state.items.push(payload)
  },
  SET_ITEM_BY_KEY(state, payload) {
    let index = state.items[0].item.findIndex(el => el.id_detail_renaksi == payload.details.id_detail_renaksi)
    if (index === -1) return

    state.items[0].item.splice(index, 1, payload.details)
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
