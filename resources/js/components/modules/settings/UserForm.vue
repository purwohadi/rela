<template>
  <b-card class="p-3">
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <template>
          <b-form-group
            label-for="user_id"
            :label="$t('user.form.field.user_id.label')"
          >
            <input type="hidden" v-model="form.user_id">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.user_id.label')"
              :debounce="250"
            >
              <b-form-input
                id="user_id"
                :class="!isNew ? 'disabled-nrk' : ''"
                v-model="form.user_id"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t('user.form.field.user_id.placeholder')"
                :readonly="!isNew"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="password"
            :label="$t('user.form.field.password.label')"
          >
            <input type="hidden" v-model="form.password">
            <ValidationProvider
              :rules="rulesForPassword"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.password.label')"
              :debounce="250"
            >
              <b-input-group class="mt-3">
                <b-form-input
                  id="password"
                  :type="fieldTypePasword"
                  v-model="form.password"
                  :state="errors[0] ? false : (valid ? true : null)"
                  :placeholder="$t('user.form.field.password.placeholder')"
                >
                </b-form-input>
                <template>
                  <b-input-group-text class="radius_icon_password">
                    <i :class="`fa ${ iconPassword } fs-xl pointer show-hide`" @click="toggleClassPassword"></i>
                  </b-input-group-text>
                </template>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </b-input-group>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="password_confirm"
            :label="$t('user.form.field.password_confirm.label')"
          >
            <input type="hidden" v-model="form.password_confirm">
            <ValidationProvider
              :rules="rulesForPasswordConfirmed"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.password_confirm.label')"
              :debounce="250"
            >
              <b-input-group class="mt-3">
                <b-form-input
                  id="password_confirm"
                  :type="fieldTypePaswordConfirm"
                  v-model="form.password_confirm"
                  :state="errors[0] ? false : (valid ? true : null)"
                  :placeholder="$t('user.form.field.password_confirm.placeholder')"
                >
                </b-form-input>
                <template>
                  <b-input-group-text class="radius_icon_password">
                    <i :class="`fa ${ iconPasswordConfirm } fs-xl pointer show-hide`" @click="toggleClassPasswordConfirm"></i>
                  </b-input-group-text>
                </template>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </b-input-group>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="nama"
            :label="$t('user.form.field.nama.label')"
          >
            <input type="hidden" v-model="form.nama">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.nama.label')"
              :debounce="250"
            >
              <b-form-input
                id="nama"
                v-model="form.nama"
                :state="errors[0] ? false : (valid ? true : null)"
                :placeholder="$t('user.form.field.nama.placeholder')"
              >
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="status"
            :label="$t('user.form.field.status.label')"
          >
            <input type="hidden" v-model="form.status">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.status.label')"
              :debounce="250"
            >
              <b-form-radio-group
                id="nama"
                v-model="form.status"
                :options="statusOptions"
                class="mb-3"
                value-field="id"
                text-field="name"
                :state="errors[0] ? false : (valid ? true : null)"
              ></b-form-radio-group>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="group"
            :label="$t('user.form.field.group.label')"
          >
            <input type="hidden" v-model="form.group">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              :name="$t('user.form.field.group.label')"
              :debounce="250"
            >
              <m-select
                id="group"
                v-model="form.group"
                :options="group"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="false"
                :preserve-search="true"
                :preselect-first="true"
                :placeholder="$t('user.form.field.group.placeholder')"
                label="label"
                track-by="value"
                :searchable="true"
                :state="errors[0] ? false : (valid ? true : null)"
              >
              </m-select>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

        </template>

        <div class="text-right mt-4 pt-3">
          <b-button type="submit" variant="primary">
            {{ $t('general.form.button_add') }}
          </b-button>
          <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
            {{ $t('general.form.button_cancel') }}
          </b-button>
        </div>
      </form>
    </validation-observer>
  </b-card>
</template>

<script>
    export default {
        name: 'UserForm',
        props: {
            id: null
        },
        data() {
            let resourceName = 'user';
            return {
                show: true,
                title: '',
                querySearch: '',
                rulesForPassword: '',
                rulesForPasswordConfirmed: '',
                resourceName: resourceName,
                routeName: `${resourceName}`,
                fields: {
                    id: 'id',
                    parentID: 'parent_id',
                    text: 'name',
                    hasChildren: 'hasChild',
                    dataSource: null,
                },
                checkedNodes: [],
                form: {
                    slug_path: '',
                    status: '',
                    group: []
                },
                statusOptions: [
                    { id: 1, name: 'Aktif' },
                    { id: 0, name: 'Tidak Aktif' },
                ],
                fieldTypePasword: 'password',
                iconPassword: 'fa-eye-slash',
                fieldTypePaswordConfirm: 'password',
                iconPasswordConfirm: 'fa-eye-slash',
                selected: {
                    group: []
                },
                group: [],
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
                this.rulesForPassword = 'min:8'
                this.rulesForPasswordConfirmed = 'confirmed:Password|min:8'
            } else {
                this.rulesForPassword = 'required|min:8'
                this.rulesForPasswordConfirmed = 'required|confirmed:Password|min:8'
            }
            this.getGroup();
        },
        methods: {
            async fetchData() {
            try {
                const action = this.$app.route(`${this.routeName}.show`, {id: this.id})
                const {data} = await this.$http.get(action)

                let group_id = [];
                const group = data.data.user_group;

                group.map(function(value, key) {
                    group_id.push({value: value.id, label: value.nama});
                });

                this.form.slug_path = data.data.slug_path
                this.form.user_id = data.data.user_id
                this.form.nama = data.data.username
                this.form.status = data.data.userstatus
                this.form.last_update_password = data.data.last_update_password
                this.form.group = group_id

            } catch (e) {
                console.log(e);
            }
            },
            async submit() {
                let vm = this
                let mode = this.isNew ? 'add' : 'edit'
                let formData = this.$app.objectToFormData(vm.$data.form)
                if(!this.isNew) {
                    formData.append('_method', 'PUT')
                }
                let url = vm.$app.route(this.isNew ? `${this.routeName}.store` : `${this.routeName}.update`, {id:this.id})
                vm.$app.confirm({
                    text: vm.$t(`${this.routeName}.alert.confirm.${mode}`, { name: vm.$data.form.nama }),
                    preConfirm: () => {
                    return vm.$http.post(url, formData)
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
                    if (result.value.data.status == "success" || result.value.data.status == "info") {
                        vm.$app.success(`${result.value.data.message}`)
                        .then(response => {
                            if (response.value === true) {
                                this.$router.push({name: 'settings.user'})
                                vm.$root.$emit('bv::refresh::table', this.resourceName)
                            }
                        })
                    }
                })
            },
            toggleClassPassword(e) {
                if(this.fieldTypePasword === 'password') {
                    this.fieldTypePasword = 'text';
                    this.iconPassword = 'fa-eye';
                    e.target.classList.add('hide');
                } else {
                    this.fieldTypePasword = 'password';
                    this.iconPassword = 'fa-eye-slash';
                    e.target.classList.remove('hide');
                }
            },
            toggleClassPasswordConfirm(e) {
                if(this.fieldTypePaswordConfirm === 'password') {
                    this.fieldTypePaswordConfirm = 'text';
                    this.iconPasswordConfirm = 'fa-eye';
                    e.target.classList.add('hide');
                } else {
                    this.fieldTypePaswordConfirm = 'password';
                    this.iconPasswordConfirm = 'fa-eye-slash';
                    e.target.classList.remove('hide');
                }
            },
            getGroup() {
                let vm = this
                vm.groupLoading = true
                vm.$http
                .get(vm.$app.route('group.get_group'), {
                params: {
                    sort_by: 'v_group_name',
                    sort_desc: 'asc',
                    status: '1'
                },
                })
                .then(response => {
                    const groupOption = [];
                    response.data.map(function(value, key) {
                        groupOption.push({value: value.i_id, label: value.v_group_name});
                    });

                    vm.group = groupOption
                })
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

    .radius_icon_password {
        border-radius: 0px 4px 4px 0px !important;
    }

    .custom-checkbox {
        width: 300px;
        padding-top: 7px;
        padding-bottom: 12px;
    }

    .custom-radio {
        padding-top: 5px;
    }

    .multiselect {
        width: 100% !important;
    }

    .multiselect__tag {
        padding: 7px 26px 7px 11px !important;
        margin: 3px 4px !important;
    }

    .disabled-nrk {
        background: #f3f3f3 !important;
    }
</style>
