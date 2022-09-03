<template>
	<div id="datatable-panel" :class="`panel ${panelBorder} ${panelShadow}`">
		<div :class="`panel-hdr ${panelBorder}`" v-if="panelTitle">
			<h2 class="fs-xl">
				<slot name="title">
					<i class="fal fa-th-list mr-2"></i>
					<i>{{ firstTitle }} <span class="fw-300">{{ restOfTitle }}</span></i>
				</slot>
			</h2>

			<div v-if="onBack">
				<div class="d-flex justify-content-end cstm-margin">
					<div class="panel-toolbar">
						<button
							type="button"
							class="btn btn-info btn-dt-refresh btn-sm rounded waves-effect waves-themed mr-2"
							v-b-tooltip.hover
							title="Kembali"
							@click="$emit('onBack')"
						>
							<i class="fal fa-arrow-alt-circle-left"></i> Kembali
						</button>
					</div>
				</div>
			</div>
		</div>
		<slot name="dateFilterTop"></slot>
		<div class="d-flex mt-3 pl-2 pr-2">
			<div class="panel-toolbar ml-2 mr-auto">
				<button
					v-if="actions.includes('C')"
					v-show="access"
					type="button"
					class="btn btn-success btn-sm rounded waves-effect waves-themed mr-lg-1"
					data-toggle="tooltip"
					data-placement="top"
					v-b-tooltip.hover.top="$t('general.datatable.toolbar.add')"
					@click="$emit('add')"
				>
					<i class="fal fa-plus"></i> Tambah
				</button>
				<div v-if="actions.includes('F1') || cstmFilter">
					<slot name="filter"></slot>
				</div>
			</div>
			<div class="panel-toolbar mr-2">
				<div v-if="actions.includes('TP')">
					<slot name="tutupperiode"></slot>
				</div>
				<button
					v-if="actions.includes('R') && topPositionLimitShow == false"
					type="button"
					class="btn btn-info btn-dt-refresh btn-sm rounded waves-effect waves-themed"
					v-b-tooltip.hover.top="$t('general.datatable.toolbar.reload')"
					@click="onRefresh"
				>
					<i class="fal fa-sync"></i> Muat Ulang
				</button>
				<div class="d-flex position-relative waves-effect waves-themed mr-lg-1 wider" ref="wrapperz" v-if="actions.includes('M')">
					<b-form-select
						v-model="selectedOptionsFilter"
						:options="optionsFilter"
						size="sm"
						class="mt-3"
						@change="onChange"
					>
					</b-form-select>
				</div>
				<button
					v-if="actions.includes('N') && topPositionLimitShow == false"
					:id="`filter-column-${id}`"
					type="button"
					:class="`btn ${cstmFilterBtn ? 'btn-warning' : 'btn-secondary'} btn-dt-filter btn-sm rounded waves-effect waves-themed mr-lg-1`"
					data-toggle="tooltip"
					data-placement="top"
					v-b-tooltip.hover.top="$t('general.datatable.toolbar.column')"
					@click="$emit('column-filter')"
				>
					<i class="fal fa-list-alt"></i> Filter
				</button>
				<b-popover :target="`filter-column-${id}`" triggers="focus" placement="left">
					<div class="mt-3 mb-0">
						<b-form-checkbox-group
							v-model="selectedColumns"
							:options="filterColumns"
							stacked
						/>
					</div>
				</b-popover>
				<div class="d-flex position-relative ml-auto wider" ref="wrapperz" v-if="actions.includes('S') && topPositionLimitShow == false">
					<i class="fal fa-search position-absolute pos-left fs-lg px-2 py-1 mt-1 fs-xs"></i>
					<input
						ref="searchInput"
						type="text"
						class="form-control form-control-sm pl-5 rounded"
						v-model="searchText"
						:placeholder="$t('general.datatable.toolbar.search')"
						@focus="onSizeChange"
						@blur="onSizeChange"
						@input="onSearch"
					>
					<i
						ref="btnClear"
						class="fal fa-times text-danger position-absolute pos-right fs-lg px-2 py-1 mt-1 fs-xs go-transparent"
						@click="onClear"
					>
					</i>
				</div>
				<div
					v-if="actions.includes('W') && (actions.includes('P') || actions.includes('F') || actions.includes('E') || actions.includes('V'))"
					ref="downloadAction"
					class="btn-group ml-1"
					role="group"
					v-b-tooltip.hover.top="$t('general.datatable.toolbar.download')"
				>
					<button
						type="button"
						class="btn btn-primary btn-sm rounded dropdown-toggle no-arrow waves-effect waves-themed"
						data-toggle="dropdown"
					>
						<i class="fal fa-download"></i> Ekspor
					</button>
					<div ref="downloadDropdown" class="dropdown-menu dropdown-menu-animated dropdown-menu-right w-auto h-auto">
						<span v-if="actions.includes('P')" class="dropdown-item" @click="downloadHandle('P')">
							<i class="fal fa-print fa-fw mr-2 color-fusion-700"></i>
							{{ $t('general.datatable.toolbar.print') }}
						</span>
						<div v-if="actions.includes('F') || actions.includes('E')" class="dropdown-divider m-0"></div>
						<span v-if="actions.includes('F')" class="dropdown-item" @click="downloadHandle('F')">
							<i class="fal fa-file-pdf fa-fw mr-2 color-danger-900"></i>
							{{ $t('general.datatable.toolbar.pdf') }}
						</span>
						<span v-if="actions.includes('E')" class="dropdown-item" @click="downloadHandle('E')">
							<i class="fal fa-file-excel fa-fw mr-2 color-success-800"></i>
							{{ $t('general.datatable.toolbar.excel') }}
						</span>
						<span v-if="actions.includes('V')" class="dropdown-item" @click="downloadHandle('V')">
							<i class="fal fa-file-alt fa-fw mr-2 color-success-600"></i>
							{{ $t('general.datatable.toolbar.csv') }}
						</span>
					</div>
				</div>
			</div>
		</div>
		<slot name="dateFilter"></slot>
		<div class="panel-container show" v-if="actions.includes('B')">
			<b-row class="box-filter" v-if="actions.includes('T')">
				<b-col md="12" class="box-filter-body">
					<b-row>
						<b-col md="12" class="box-filter-title">
							<i class="fal fa-filter"></i> Filter Berdasarkan {{ filterDateTitle }}
						</b-col>
					</b-row>
					<div class="box-filter-line"></div>
					<b-row v-if="actions.includes('Y')">
						<b-col md="4" class="mb-4">
							<b-form-group
								label-for="tanggal"
							>
								<bs-datepicker
									class="datepicker-input"
									v-model="selectedDate"
									label=""
									:placeholder="vDatePlaceholder"
									:settings="tanggalFormat"
									@onSelected="onSelectedDate"
								></bs-datepicker>
							</b-form-group>
						</b-col>
						<b-col md="4" class="mb-4">
							<button
								type="button"
								class="btn btn-primary rounded waves-effect waves-themed mr-lg-1 box-filter-btn"
								v-b-tooltip.hover.top="$t('general.datatable.toolbar.filter')"
								@click="onFilterTanggal"
							>
								<i class="fal fa-filter"></i>
								Filter
							</button>
						</b-col>
					</b-row>
					<b-row v-if="actions.includes('X')">
						<b-col md="4" class="mb-4">
							<b-form-group
								label-for="tahun"
							>
								<bs-datepicker
									class="datepicker-input"
									v-model="selectedDate"
									label=""
									:placeholder="vDatePlaceholder"
									:settings="tahunFormat"
									@onSelected="onSelectedDate"
								></bs-datepicker>
							</b-form-group>
						</b-col>
						<b-col md="4" class="mb-4">
							<button
								type="button"
								class="btn btn-primary rounded waves-effect waves-themed mr-lg-1 box-filter-btn"
								v-b-tooltip.hover.top="$t('general.datatable.toolbar.filter')"
								@click="onFilterTanggal"
							>
								<i class="fal fa-filter"></i>
								Filter
							</button>
						</b-col>
					</b-row>
					<b-row v-if="actions.includes('Z')">
						<b-col md="4" class="mb-4">
							<b-form-group
								label-for="tanggal_awal"
							>
								<bs-datepicker
									class="datepicker-input"
									v-model="selectedDateAwal"
									label=""
									:placeholder="vDatePlaceholderAwal"
									:settings="tanggalFormat"
									@onSelected="onSelectedDateAwal"
								></bs-datepicker>
							</b-form-group>
						</b-col>
						<b-col md="4" class="mb-4">
							<b-form-group
								label-for="tanggal_akhir"
							>
								<bs-datepicker
									class="datepicker-input"
									v-model="selectedDateAkhir"
									label=""
									:placeholder="vDatePlaceholderAkhir"
									:settings="tanggalFormat"
									@onSelected="onSelectedDateAkhir"
								></bs-datepicker>
							</b-form-group>
						</b-col>
						<b-col md="4" class="mb-4">
							<button
								type="button"
								class="btn btn-primary rounded waves-effect waves-themed mr-lg-1 box-filter-btn"
								v-b-tooltip.hover.top="$t('general.datatable.toolbar.filter')"
								@click="onFilterTanggalRange"
							>
								<i class="fal fa-filter"></i>
								Filter
							</button>
						</b-col>
					</b-row>
				</b-col>
			</b-row>
		</div>
		<div class="panel-container show">
			<div v-if="topPositionLimitShow ? true : false" :class="`panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted mt-2 ${panelBorder}`">
				<div class="row d-flex align-items-center">
					<div class="col-12 col-lg-3">
						<b-button size="sm" class="btn-outline-default waves-effect waves-themed" variant="outline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
						>
							Data Perhalaman
							<span class="badge badge-primary btn-xs rounded ml-2">
								{{ perPage }}
							</span>
						</b-button>
						<div ref="perpage" class="dropdown-menu width-xs dropdown-menu-right" x-placement="bottom-start">
							<span class="dropdown-item" v-for="page in pageOptions" :key="page" @click="perpageChange(page)">
								<template v-if="page === perPage">
									<span class="text-primary">{{ page }}</span>
								</template>
								<template v-else>
									{{ page }}
								</template>
							</span>
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="align-items-center justify-content-center font-italic">
							{{
								$t(
									'general.datatable.body.inforow',
									{
										awal: getRowNum(0),
										akhir: totalRows < (perPage * currentPage) ? totalRows : (perPage * currentPage),
										total: totalRows
									}
								)
							}}
						</div>
					</div>
					<div class="col-12 col-lg-5">
						<div class="d-flex mt-1 pl-2 pr-2" style="float: right;">
							<div class="panel-toolbar mr-2">
								<button
									v-if="actions.includes('R')"
									type="button"
									class="btn btn-info btn-dt-refresh btn-sm rounded waves-effect waves-themed"
									v-b-tooltip.hover.top="$t('general.datatable.toolbar.reload')"
									@click="onRefresh"
								>
									<i class="fal fa-sync"></i> Muat Ulang
								</button>
								<button
									v-if="actions.includes('N')"
									:id="`filter-column-${id}`"
									type="button"
									:class="`btn ${cstmFilterBtn ? 'btn-warning' : 'btn-secondary'} btn-dt-filter btn-sm rounded waves-effect waves-themed mr-lg-1`"
									data-toggle="tooltip"
									data-placement="top"
									v-b-tooltip.hover.top="$t('general.datatable.toolbar.column')"
									@click="$emit('column-filter')"
								>
									<i class="fal fa-list-alt"></i> Filter
								</button>
								<b-popover :target="`filter-column-${id}`" triggers="focus" placement="left">
									<div class="mt-3 mb-0">
										<b-form-checkbox-group
											v-model="selectedColumns"
											:options="filterColumns"
											stacked
										/>
									</div>
								</b-popover>
								<div class="d-flex position-relative ml-auto wider" ref="wrapperz" v-if="actions.includes('S')">
									<i class="fal fa-search position-absolute pos-left fs-lg px-2 py-1 mt-1 fs-xs"></i>
									<input
										ref="searchInput"
										type="text"
										class="form-control form-control-sm pl-5 rounded"
										v-model="searchText"
										:placeholder="$t('general.datatable.toolbar.search')"
										@focus="onSizeChange"
										@blur="onSizeChange"
										@input="onSearch"
									>
									<i
										ref="btnClear"
										class="fal fa-times text-danger position-absolute pos-right fs-lg px-2 py-1 mt-1 fs-xs go-transparent"
										@click="onClear"
									>
									</i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div :class="`panel-content ${ additionalClass }`">
				<section class="main-table">
					<b-table
						:ref="id"
						:id="id"
						:fields="fields"
						:options-filter-fields="optionsFilterFields"
						:filter-date-title="filterDateTitle"
						:v-date="vDate"
						:v-date-awal="vDateAwal"
						:v-date-akhir="vDateAkhir"
						:v-date-placeholder="vDatePlaceholder"
						:v-date-placeholder-awal="vDatePlaceholderAwal"
						:v-date-placeholder-akhir="vDatePlaceholderAkhir"
						:items="loadProvider"
						:api-url="apiUrl"
						:responsive="responsive"
						:striped="striped"
						:hover="hover"
						:bordered="bordered"
						:borderless="borderless"
						:outlined="outlined"
						:dark="dark"
						:head-variant="headVariant"
						:sticky-header="stickyHeader"
						:stacked="stacked"
						:filter="filter"
						:busy="isBusy"
						:current-page="currentPage"
						:per-page="perPage"
						:sort-by.sync="sortBy"
						:sort-desc.sync="sortDesc"
						:empty-text="$t('general.datatable.body.emptyText')"
						:empty-filtered-text="$t('general.datatable.body.emptyFilteredText')"
						show-empty
					>
						<!-- begin of rownum template -->
						<template #head(rownum)>
							{{ $t('general.datatable.body.rownum') }}
						</template>
						<template #cell(rownum)="data">
							<span class="no-wrap">{{ getRowNum(data.index) }}</span>
						</template>
						<!-- end of rownum template -->

						<!-- begin of rowaction template -->
						<template #head(rowaction)>
							{{ $t('general.datatable.body.rowaction') }}
						</template>
						<template #cell(rowaction)="data">
							<button
								v-if="actions.includes('L')"
								type="button"
								class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
								:class="data.item.e_status_proses=='PERIODE DITUTUP BELUM DIVERIFIKASI'? ' btn-danger' : ' btn-info'"
								v-b-tooltip.hover.right="$t('general.datatable.body.view')"
								@click="$emit('detail', data.item, data.index, $event.target)"
							>
								<i class="fal fa-info"></i> Lihat
							</button>
							<button
								v-if="actions.includes('U')"
								type="button"
								class="btn btn-warning btn-xs rounded waves-effect waves-themed mr-lg-1"
								v-b-tooltip.hover.right="$t('general.datatable.body.update')"
								@click="$emit('update', data.item, data.index, $event.target)"
							>
								<i class="fal fa-pen-alt"></i> Ubah
							</button>
							<button
								v-if="actions.includes('D')"
								type="button"
								class="btn btn-danger btn-xs rounded waves-effect waves-themed"
								v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
								@click="$emit('delete', data.item, data.index, $event.target)"
							>
								<i class="fal fa-trash"></i> Hapus
							</button>
							<slot name="actionExtra" :data="data">
							</slot>
						</template>
						<!-- end of rowaction template -->

						<!-- begin of custom slot -->
						<template
							v-if="$scopedSlots && Object.keys($scopedSlots).length"
							v-for="slot in Object.keys($scopedSlots)"
							:slot="slot"
							slot-scope="data"
						>
							<slot :name="slot" :data="data"></slot>
						</template>
						<!-- end of custom slot -->

						<!-- begin of empty slot -->
						<template #empty="scope">
							<div class="text-center">{{ scope.emptyText }}</div>
						</template>
						<template #emptyfiltered="scope">
							<div class="text-center">{{ scope.emptyFilteredText }}</div>
						</template>
						<!-- end of empty slot -->

						<!-- begin of busy slot -->
						<template #table-busy>
							<spinner></spinner>
						</template>
						<!-- end of busy slot -->
					</b-table>
					<div v-if="topPositionLimitShow ? false : true || isNotPaging ? false : true" class="d-flex align-items-center justify-content-center font-italic">
						{{
							$t(
								'general.datatable.body.inforow',
								{
									awal: getRowNum(0),
									akhir: totalRows < (perPage * currentPage) ? totalRows : (perPage * currentPage),
									total: totalRows
								}
							)
						}}
					</div>
				</section>
			</div>
			<div v-if="isNotPaging ? false : true" :class="`panel-content py-2 rounded-bottom border-faded border-left-0 border-right-0 border-bottom-0 text-muted mt-2 ${panelBorder}`">
				<div :class="`row d-flex align-items-center ${ topPositionLimitShow ? 'custom-margin-paging' : '' }`">
					<div v-if="topPositionLimitShow ? false : true" class="col-12 col-lg-6">
						<b-button size="sm" class="btn-outline-default waves-effect waves-themed" variant="outline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
						>
							Data Perhalaman
							<span class="badge badge-primary btn-xs rounded ml-2">
								{{ perPage }}
							</span>
						</b-button>
						<div ref="perpage" class="dropdown-menu width-xs dropdown-menu-right" x-placement="bottom-start">
							<span class="dropdown-item" v-for="page in pageOptions" :key="page" @click="perpageChange(page)">
								<template v-if="page === perPage">
									<span class="text-primary">{{ page }}</span>
								</template>
								<template v-else>
									{{ page }}
								</template>
							</span>
						</div>
					</div>
					<div :class="`col-12 ${ topPositionLimitShow ? 'col-lg-12' : 'col-lg-6' }`">
						<b-pagination
							class="pagination justify-content-end mb-0"
							size="sm"
							v-model="currentPage"
							:total-rows="totalRows"
							:per-page="perPage"
							:first-text="$t('general.datatable.pagination.firstText')"
							:prev-text="$t('general.datatable.pagination.prevText')"
							:next-text="$t('general.datatable.pagination.nextText')"
							:last-text="$t('general.datatable.pagination.lastText')"
						>
						</b-pagination>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
let uuid = 0
import datatable from '@components/mixins/datatables'
export default {
	name: 'DataTables',
	mixins: [datatable],
	props: {
		id: {
			type: String,
			required: false,
			default: () => {
				uuid += 1
				return `v-datatable-${uuid.toString()}`
			},
		},
		apiUrl: {
			type: String,
			required: false,
			default: '',
		},
		fields: {
			type: Array,
			required: false,
			default: () => []
		},
		optionsFilterFields: {
			type: Array,
			required: false,
			default: () => []
		},
		filterDateTitle: {
			type: String,
			required: false,
			default: ''
		},
		vDate: {
			type: String,
			required: false,
			default: ''
		},
		vDateAwal: {
			type: String,
			required: false,
			default: ''
		},
		vDateAkhir: {
			type: String,
			required: false,
			default: ''
		},
		vDatePlaceholder: {
			type: String,
			required: false,
			default: ''
		},
		vDatePlaceholderAwal: {
			type: String,
			required: false,
			default: ''
		},
		vDatePlaceholderAkhir: {
			type: String,
			required: false,
			default: ''
		},
		items: {
			type: Array,
			required: false,
			default: () => []
		},
		title: {
			type: String,
			required: false,
			default: ''
		},
		actions: {
			type: String,
			required: false,
			default: 'SCRWULDPFEV',
			description: `
        Available =>
        B: Filter Box
        T: Filter By Tanggal
        S: Search
        N: Filter Column Button
        M: Filter Select
        C: Add Button
        R: Reload Button
        W: Download Button
        U: Update Button
        L: Detail Button
        D: Delete Button
        P: Print
        F: PDF
        E: Excel
        V: CSV
        Y: Single Date Filter
        Z: Range Date Filter
      `,
		},
		responsive: {
			type: Boolean,
			required: false,
			default: true,
		},
		striped: {
			type: Boolean,
			required: false,
			default: false,
		},
		hover: {
			type: Boolean,
			required: false,
			default: true,
		},
		bordered: {
			type: Boolean,
			required: false,
			default: true,
		},
		borderless: {
			type: Boolean,
			required: false,
			default: true,
		},
		outlined: {
			type: Boolean,
			required: false,
			default: false,
		},
		dark: {
			type: Boolean,
			required: false,
			default: false,
		},
		stickyHeader: {
			type: Boolean,
			required: false,
			default: false,
		},
		stacked: {
			type: Boolean,
			required: false,
			default: false,
		},
		headVariant: {
			type: String,
			required: false,
			default: 'light',
		},
		rowActionWidth: {
			type: String,
			required: false,
			default: '15%',
		},
		rowNumWidth: {
			type: String,
			required: false,
			default: '7%',
		},
		defaultSortBy: {
			type: String,
			required: false,
		},
		querySearch: {
			type: String,
			required: false
		},
		delay: {
			type: Number,
			required: false,
			default: 100,
		},
		panelBorderNone: {
			type: Boolean,
			require: false,
			default: false
		},
		panelShadowNone: {
			type: Boolean,
			require: false,
			default: false
		},
		panelTitle : {
			type: Boolean,
			require: false,
			default: true
		},
		customLoadProvider: {
			type: [Object, Function, Array],
			required: false,
			default: () => null
		},
		urlParams: {
			type: [Object, Array],
			required: false,
			default: () => null
		},
		forceUrl: {
			type: Boolean,
			required: false,
			default: false
		},
		minimumSearchLen: {
			type: Number,
			required: false,
			default: 1
		},
		filterExclude: {
			type: Array,
			required: false,
			default: () => []
		},
		intialSortDesc: {
			type: Boolean,
			required: false,
			default: false
		},
		cstmFilter: {
			type: Boolean,
			default: false
		},
		cstmFilterBtn: {
			type: Boolean,
			default: false
		},
		onBack: {
			type: Boolean,
			default: false
		},
		argsRoute: {
			type: Object,
			default: () => {}
		},
		perPageCustom: {
			type: Number,
			required: false
		},
		additionalClass: {
			type: String,
			required: false,
			default: ''
		},
		topPositionLimitShow: {
			type: Boolean,
			default: false
		},
		isNotPaging: {
			type: Boolean,
			default: false
		},    
		access: {
			type: Boolean,
			default: true
		},
	},
}
</script>
<style scoped>
.action {
  max-width: 1rem;
}

.custom-select-sm {
  margin-top: 0px !important;
  border-radius: 7.5px;
}

.box-filter {
  padding: 15px 25px 5px;
}

.box-filter-body {
  background: #f8f9fa;
  border: 1px solid #ededed;
  border-radius: 8px;
  padding: 15px 15px 5px;
}

.box-filter-title {
  font-size: 14px;
  font-style: italic;
}

.box-filter-line {
  border-top: 1px solid #e4e4e4;
  margin: 10px 5px 15px;
}

.box-filter-btn {
  font-size: 12px;
  padding: 7px 15px !important;
}

.btn-dt-refresh {
  margin-right: 5px;
}

/* .btn-dt-filter {
  margin-right: 5px !important;
}  */

.custom-margin-paging {
  margin: 15px 0px 5px;
}
</style>
