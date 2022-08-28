const state = () => ({
  item: {
    aktivitas: [],
    jadwalBukaTutup: {},
    referensi: {
      renaksi: [],
      aktivitas: []
    },
    times: [],
    holidays: {},
    profiles: {}
  }
})

const getters = {
  getItemAktivitas(state) {
    return state.item.aktivitas
  },
  getItemRenaksi(state) {
    return state.item.referensi.renaksi
  },
  getItemRefAktivitas(state) {
    return state.item.referensi.aktivitas
  },
  getTimes: (state) => state.item.times,
  getHolidays: (state) => state.item.holidays,
  getProfiles: (state) => state.item.profiles
}

const actions = {
  setAktivitasItems({ state, commit }, { key, items }) {
    if (key.length && items.length) {
      let payload = { key, data: items }
      let filtered = state.item.aktivitas.filter(item => item.key == key)
      if (filtered.length == 0) commit('SET_AKTIVITAS_ITEMS', payload)
    }
  },
  setAktivitasItemsByKey(context, payload) {
    context.commit('SET_AKTIVITAS_ITEM_BY_KEY', payload)
  },
  editAktivitasItemByKey(context, payload) {
    context.commit('EDIT_AKTIVITAS_ITEM_BY_KEY', payload)
  },
  dropAktivitasItemByKey(context, payload) {
    context.commit('DROP_AKTIVITAS_ITEM_BY_KEY', payload)
  },
  getAktivitasItemByKey(context, { key }) {
    return { context, key }
  },
  setReferensiItems(context, payload) {
    context.commit('SET_REFERENSI_ITEM', payload)
  },
  setRenaksiItems({ state, commit }, { key, data }) {
    if (key.length && data.length) {
      let payload = { key, data }
      let filtered = state.item.referensi.renaksi.filter(item => item.key == key)
      if (filtered.length == 0) commit('SET_RENAKSI_ITEM', payload)
    }
  },
  getRenaksiItemByKey( { state }, { key } ) {
    let founded = state.item.referensi.renaksi.find(renaksi => renaksi.key == key)
    return _.isEmpty(founded) ? [] : founded.data
  },

  // new
  getJadwalBukaTutupByThbl( { state }, { thbl } ) {
    let items = state.item.jadwalBukaTutup
    if (!findJadwalBukaTutupByThbl(items, thbl)) return false

    return items[thbl] || false
  },
  setJadwalBukaTutupByThbl( { state, commit }, { thbl, data } ) {
    let items = state.item.jadwalBukaTutup
    if (!findJadwalBukaTutupByThbl(items, thbl)) commit('SET_JADWAL_BUKA_TUTUP', { thbl, data })
  },
  getAktivitasByTglMulaiDanAkhir( { state }, { awal, akhir } ) {
    let items = state.item.aktivitas
    let { data } = findAktivitas(items, { awal, akhir })
    return data
  },
  setAktivitasByTglAwalDanAkhir( { state, commit }, { awal, akhir, data } ) {
    let items = state.item.aktivitas
    let { index } = findAktivitas(items, { awal, akhir })
    if (index === -1) commit('SET_AKTIVITAS_ITEM', { awal, akhir, data })
  },
  setTimes({ commit }, payload) {
    commit('SET_TIMES', payload)
  },
  setHoliday({ commit }, payload) {
    commit('SET_HOLIDAYS', payload)
  },
  getProfileByThbl( { state }, thbl ) {
    let profilesClone = Object.assign({}, state.item.profiles)
    let check = findProfileByThbl(profilesClone, thbl)
    return check ? profilesClone[thbl] : false
  },
  setProfile({ commit }, payload) {
    commit('SET_PROFILE', payload)
  }
}

const findAktivitas = (activities, { awal, akhir }) => {
  let current = {
    awal: window.moment(awal, 'YYYY-MM-DD'),
    akhir: window.moment(akhir, 'YYYY-MM-DD'),
  }

  let idx = activities.findIndex(activity => {
    let aktivitas = {
      awal: window.moment(activity.awal.split(' ').shift(), 'YYYY-MM-DD'),
      akhir: window.moment(activity.akhir.split(' ').shift(), 'YYYY-MM-DD')
    }

    return aktivitas.awal <= current.awal && aktivitas.akhir >= current.akhir
  })
  if (idx === -1) return { data: { awal, akhir, data: { data: [] } }, index: idx }
  return { data: activities[idx], index: idx }
}

const findJadwalBukaTutupByThbl = (items, key) => {
  if (key.length == 0) return
  if (Object.keys(items).length == 0) return
  return items.hasOwnProperty(key)
}

const findProfileByThbl = (profiles, thbl) => {
  return profiles.hasOwnProperty(thbl)
}

const mutations = {
  SET_AKTIVITAS_ITEM(state, payload) {
    state.item.aktivitas.push(payload)
  },
  SET_AKTIVITAS_ITEMS(state, payload) {
    state.item.aktivitas.push(payload)
  },
  SET_AKTIVITAS_ITEM_BY_KEY(state, { ymd, details }) {
    let { index } = findAktivitas(state.item.aktivitas, { awal: ymd, akhir: ymd })
    if (index === -1) return

    state.item.aktivitas[index].data.data.push(details)
  },
  EDIT_AKTIVITAS_ITEM_BY_KEY(state, { ymd, details }) {
    let { index } = findAktivitas(state.item.aktivitas, { awal: ymd, akhir: ymd })
    if (index === -1) return

    let idx = state.item.aktivitas[index].data.data.findIndex(aktivitas => aktivitas.slug_path == details.slug_path)
    let selectedData = state.item.aktivitas[index].data.data[idx]
    if (!selectedData) return

    setTimeout(() => state.item.aktivitas[index].data.data.splice(idx, 1, details), 500)
  },
  DROP_AKTIVITAS_ITEM_BY_KEY(state, { ymd, slug_path }) {
    let { index } = findAktivitas(state.item.aktivitas, { awal: ymd, akhir: ymd })
    if (index === -1) return

    let idx = state.item.aktivitas[index].data.data.findIndex(aktivitas => aktivitas.slug_path == slug_path)
    if (idx === -1) return

    state.item.aktivitas[index].data.data.splice(idx, 1)
  },
  SET_REFERENSI_ITEM(state, payload) {
    state.item.referensi.aktivitas = payload
  },
  SET_RENAKSI_ITEM(state, payload) {
    state.item.referensi.renaksi.push(payload)
  },
  SET_JADWAL_BUKA_TUTUP(state, { thbl, data }) {
    state.item.jadwalBukaTutup[thbl] = { data }
  },
  SET_TIMES(state, payload) {
    state.item.times = payload
  },
  SET_HOLIDAYS(state, { tahun, data }) {
    state.item.holidays[tahun] = data
  },
  SET_PROFILE(state, { thbl, data }) {
    state.item.profiles = { ...state.item.profiles, ...data}
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
