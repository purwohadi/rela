const state = () => ({
  cronjob: {
    list: [],
    selected: {}
  }
})

const getters = {
  getList: state => state.cronjob.list,
  getSelected: state => state.cronjob.selected,
}

const actions = {
  setList(context, payload) {
    context.commit('SET_LIST', payload)
  },
  setSelected(context, payload) {
    context.commit('SET_SELECTED', payload)
  },
  chageProcessingState(context, payload) {
    context.commit('CHANGE_PROCESSING_STATE', payload)
  }
}

const mutations = {
  SET_LIST(state, payload) {
    state.cronjob.list = payload
  },
  SET_SELECTED(state, payload) {
    state.cronjob.selected = payload
  },
  CHANGE_PROCESSING_STATE(state, payload) {
    // changing process_flag
    // find job in cronjob.list
    const idx = state.cronjob.list.findIndex(job => job.command == payload.command)
    if (idx !== -1) {
      state.cronjob.list[idx].has_processing = payload.setProcessing
    }

    // if cronjob.selected has value
    if (Object.keys(state.cronjob.selected).length && state.cronjob.selected.command == payload.command) {
      state.cronjob.selected.has_processing = payload.setProcessing
    }
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
