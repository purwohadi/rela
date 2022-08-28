const state = () => ({
  items: []
})

const getters = {
  getItems (state) {
    return state.items
  }
}

const actions = {
  setItem(context, { thbl, settings, item }) {
    if (item.length) {
      let hasSettings = !_.isEmpty(settings)
      let currentSettings = !hasSettings ? {...settings, ...{slug_path: 'root'}} : {...settings}
      let count = context.state.items.find(n => n.thbl == thbl && n.settings.slug_path == currentSettings.slug_path) || []
      if (count.length == 0) context.commit('SET_ITEM', { thbl, settings: currentSettings, item })
    }
  }
}

const mutations = {
  SET_ITEM (state, payload) {
    state.items.push(payload)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
