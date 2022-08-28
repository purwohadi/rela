<template>
  <b-card class="p-3">
    <b-form-group
      label-for="user_id"
      :label="$t('user.form.field.user_id.label')"
    >
      <b-form-input
        id="user_id"
        readonly
        v-model="form.user_id"
        :placeholder="$t('user.form.field.user_id.placeholder')"
      >
      </b-form-input>
    </b-form-group>

    <b-form-group
      label-for="nama"
      :label="$t('user.form.field.nama.label')"
    >
      <b-form-input
        id="nama"
        readonly
        v-model="form.nama"
        :placeholder="$t('user.form.field.nama.placeholder')"
      >
      </b-form-input>
    </b-form-group>

    <b-form-group
      label-for="status"
      :label="$t('user.form.field.status.label')"
    >
      <b-form-radio-group
        v-model="form.status"
        :options="statusOptions"
        class="mb-3"
        value-field="id"
        text-field="name"
        disabled
      ></b-form-radio-group>
    </b-form-group>

    <b-form-group
      label-for="last_update_password"
      :label="$t('user.form.field.last_update_password.label')"
    >
      <b-form-input
        id="last_update_password"
        readonly
        v-model="form.last_update_password"
        :placeholder="$t('user.form.field.last_update_password.placeholder')"
      >
      </b-form-input>
    </b-form-group>

    <b-form-group
      label-for="group"
      :label="$t('user.form.field.group.label')"
    >
      <div class="custom-bedge-box">
        <template v-for="(item,key) in form.group">
          <b-badge :key="key" class="badge badge-success badge-pill mr-1 custom-bedge-detail">{{ item }}</b-badge>
        </template>
      </div>
    </b-form-group>

    <div class="text-right mt-4 pt-3">
      <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
        {{ $t('general.form.button_close') }}
      </b-button>
    </div>
  </b-card>
</template>

<script>
    export default {
        name: 'UserFormDetail',
        props: {
            id: null
        },
        data() {
            let resourceName = 'user';
            return {
            show: true,
            title: '',
            querySearch: '',
            resourceName: resourceName,
            routeName: `${resourceName}`,
            fields: {
                id: 'id',
                parentID: 'parent_id',
                text: 'name',
                hasChildren: 'hasChild',
                dataSource: null,
            },
            form: {
                slug_path: '',
                name: '',
                status: '',
            },
            statusOptions: [
                { id: 1, name: 'Aktif' },
                { id: 0, name: 'Tidak Aktif' },
            ]
            }
        },
        computed: {
            isNew() {
            return this.id === undefined ? true : false
            }
        },
        created() {
            if(!this.isNew) {
            this.fetchData()
            }
        },
        methods: {
            async fetchData() {
                try {
                    const action = this.$app.route(`${this.routeName}.show`, {id: this.id})
                    const {data} = await this.$http.get(action)
        
                    let group_name = [];
                    const group = data.data.user_group;

                    group.map(function(value, key) {
                        group_name.push(value.nama);
                    });

                    this.form.slug_path = data.data.slug_path
                    this.form.user_id = data.data.user_id
                    this.form.nama = data.data.username 
                    this.form.status = data.data.userstatus
                    this.form.last_update_password = (data.data.last_update_password) ? data.data.last_update_password : '-'
                    this.form.group = group_name
                } catch (e) {
                    console.log(e);
                }
            }
        }
    }
</script>

<style lang="scss">
@import '~@syncfusion/ej2-base/styles/bootstrap4.css';
@import "~@syncfusion/ej2-buttons/styles/bootstrap4.css";
@import "~@syncfusion/ej2-vue-navigations/styles/bootstrap4.css";
  #tree-feature {
    margin-left: -1rem;
    margin-right: -1rem;
    font-family: "Poppins", sans-serif;
    .e-list-text {
      font-size: 13px;
    }
  }
</style>
<style>
  .control_wrapper {
    display: block;
    max-width: 350px;
    max-height: 350px;
    margin: auto;
    overflow: auto;
    border: 1px solid #dddddd;
    border-radius: 3px;
  }

  .custom-bedge-box {
    background: #f3f3f3;
    border: 1px solid #e6e6e6;
    padding: 15px;
    border-radius: 5px;
  }

  .custom-bedge-detail {
    font-size: 12px;
    font-weight: 600;
    padding: 7px 17px;
    margin: 4px;
  }
</style>
