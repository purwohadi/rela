<template>
  <div class="row">
    <div class="col-12">
      <section class="batastmt">
        <data-table
          id="batastmttable"
          :fields="fields"
          api-url="batas-tmt.get"
          :title="$t('batastmt.datatable.title')"
          :filter-exclude="filterExclude"
          actions="SCRUDN"
          row-action-width="10%"
          @add="handleAdd"
          @update="handleUpdate"
          @delete="handleDelete"
        >
        </data-table>

        <batas-tmt-form
          :m-id="modal.id"
          :title="modal.title"
          :item="modal.item"
          :is-edit="modal.isEdit"
        ></batas-tmt-form>
      </section>
    </div>
  </div>
</template>

<script>
import BatasTmtForm from './BatasTmtForm'
export default {
    name: 'BatasTmt',
    components: {
        BatasTmtForm
    },
    filters: {
        getFirst(value = []) {
            let temp = [...value]
            return temp.length ? temp.shift().name : ''
        }
    },
    data() {
        return {
            show: true,
            title: '',
            form: {
                id: null,
                name: ''
            },
            fields: [
                {
                    key: 'rowaction',
                    label: '',
                    class: 'text-center',
                },
                {
                    key: 'rownum',
                    class: 'text-center',
                },
                {
                    key: 'tahun',
                    label: this.$t('batastmt.datatable.column.tahun'),
                    sortable: true,
                },
                {
                    key: 'bulan_idn',
                    label: this.$t('batastmt.datatable.column.bulan'),
                    sortable: true,
                },
                {
                    key: 'batas_tmt_convert',
                    label: this.$t('batastmt.datatable.column.batas_tmt'),
                    sortable: true,
                },
                {
                    key: 'user_update',
                    label: this.$t('batastmt.datatable.column.user_update'),
                    sortable: true,
                },
                {
                    key: 'tanggal_update_convert',
                    label: this.$t('batastmt.datatable.column.tanggal_update'),
                    sortable: true,
                },
            ],
            filterExclude: ['bulan_idn', 'batas_tmt_convert', 'tanggal_update_convert'],
            modal: {
                id: 'batas-tmt-form',
                title: "",
                item: {},
                isEdit: false
            },
        }
    },
    created() {
    },
    methods: {
        handleAdd() {
            this.modal.title = this.$t('batastmt.form.title.add')
            this.modal.isEdit = false
            this.$bvModal.show(this.modal.id)
        },
        handleUpdate(item, index, $el) {
            this.modal.title = this.$t('batastmt.form.title.edit')
            this.modal.item = item
            this.modal.isEdit = true
            this.$bvModal.show(this.modal.id)
        },
        handleDelete(item, index, $el) {
            console.log(item);
            const vm = this
            vm.$app.confirm({
            text: vm.$t('batastmt.alert.confirm.drop'),
            preConfirm: () => {
                return vm.$http
                .delete(vm.$app.route('batas-tmt.drop'), {
                    data: { slug: item.id }
                })
                .then(response => {
                if (response.data.status == "error") {
                    let errors = response.data.message
                    throw new Error(response.data.message)
                } else {
                    return response
                }
                })
                .catch(error => {
                    vm.$app.alert.showValidationMessage(error)
                })
            }
        })
            .then(result => {
                if (result.isDismissed) return
                    if (result.value.data.status == "success") {
                    vm.$app.success(this.$t(`batastmt.alert.actions.drop.${result.value.data.status}`))
                    .then(response => {
                        if (response.value === true) {
                            //vm.$root.$emit('bv::refresh::table', 'batastmttable')
                            this.$router.go(0)
                        }
                    })
                }
            })
        },
    }
}
</script>
