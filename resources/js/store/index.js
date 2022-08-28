import Vue from 'vue'
import Vuex from 'vuex'

import { getSettings } from '@js/helpers/commons'
import {
	getFaBrandList,
	getFaIconList,
	getNgIconList,
	getNgIconBaseList,
	getBgColorList,
	getTextColorList,
} from '@js/helpers/data'

import aktivitas from './modules/aktivitas'
import struktur from './modules/struktur'
import serapan from './modules/serapan'
import validasiRealisasiRenkin from './modules/validasiRealisasiRenkin'
import cronjobUi from './modules/cronjobUi'
import topics from './modules/topics'

const settings = getSettings()

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		aktivitas,
		struktur,
		serapan,
		cronjobUi,
		validasiRealisasiRenkin,
		topics,
	},
	state: {
		live_avatar: {
			has_avatar_image: settings.user.has_avatar_image,
			avatar_image_path: settings.user.avatar_image_path,
			thumbnail_avatar_path: settings.user.thumbnail_avatar_path,
			avatar: settings.user.avatar,
		},
		icons: {
			faBrandList: getFaBrandList(),
			faIconList: getFaIconList(),
			ngIconList: getNgIconList(),
			ngIconBaseList: getNgIconBaseList(),
			bgColorList: getBgColorList(),
			textColorList: getTextColorList(),
		},
		structureMenu: settings.structure_menu,
		flattenMenu: settings.flatten_menu,
		thbl: settings.current_date.split('-', 2).join(''),
		hitungTunda: null
	},
	getters: {
		getAvatar: (state) => state.live_avatar.avatar,
		getHasAvatarImage: (state) => state.live_avatar.has_avatar_image,
		getThumbnailAvatarPath: (state) => state.live_avatar.thumbnail_avatar_path,
		getAvatarImagePath: (state) => state.live_avatar.avatar_image_path,
		getFaBrandList: (state) => state.icons.faBrandList,
		getFaIconList: (state) => state.icons.faIconList,
		getNgIconList: (state) => state.icons.ngIconList,
		getNgIconBaseList: (state) => state.icons.ngIconBaseList,
		getNgIconBaseList: (state) => state.icons.bgColorList,
		getTextColorList: (state) => state.icons.textColorList,
		getStructureMenu: (state) => _.orderBy(state.structureMenu, ['order_no'], ['label']),
		getFlattenMenu: (state) => state.flattenMenu,
		getThbl: (state) => state.thbl,
		hitungTundaIsNull: (state) => state.hitungTunda == null,
		getHasHitungTunda: (state) => state.hitungTunda?.isActive || false,
		getHitungTundaUnitIgnore: (state) => state.hitungTunda != null ? state.hitungTunda.unitIgnore : []
	},
	mutations: {
		UPDATE_LIVE_AVATAR: (state, payload) => state.live_avatar = payload,
		UPDATE_LIVE_MENU: (state, payload) => state.structureMenu = payload,
		UPDATE_FLATTEN_MENU: (state, payload) => state.flattenMenu = payload,
		UPDATE_LIVE_THBL: (state, payload) => state.thbl = payload,
		UPDATE_HITUNG_TUNDA: (state, payload) => state.hitungTunda = payload
	},
	actions: {
		updateLiveAvatar: (context, payload) => {
			context.commit('UPDATE_LIVE_AVATAR', payload)
		},
		updateLiveMenu: (context, payload) => {
			context.commit('UPDATE_LIVE_MENU', payload)
		},
		updateFlattenMenu: (context, payload) => {
			context.commit('UPDATE_FLATTEN_MENU', payload)
		},
		updateLiveThbl: (context, payload) => {
			context.commit('UPDATE_LIVE_THBL', payload)
		},
		updateHitungTunda: (context, payload) => {
			context.commit('UPDATE_HITUNG_TUNDA', payload)
		}
	},
})

