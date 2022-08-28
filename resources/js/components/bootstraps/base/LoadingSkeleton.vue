<template>
  <b-skeleton-wrapper :loading="loading">
    <template #loading>
      <b-skeleton-table
        v-if="type == 'skeleton-table'"
        :rows="rows"
        :columns="columns"
        :table-props="{ bordered: true, striped: true }"
      ></b-skeleton-table>

      <template v-if="type == 'skeleton-form-horizontal'">
        <b-row v-for="total in totalRow" :key="total.total">
          <b-col cols="2">
            <b-skeleton width="70px" animation="fade" class="mt-2"></b-skeleton>
          </b-col>
          <b-col>
            <b-skeleton type="input" animation="fade" class="mt-2"></b-skeleton>
          </b-col>
        </b-row>
      </template>

      <template v-if="type == 'card-personal-info'">
        <b-row>
          <b-col lg="2" md="2" sm="2" class="user-img-pdg mt-3">
            <b-skeleton type="avatar" class="user-image-skeleton"></b-skeleton>
          </b-col>
          <b-col b-col lg="10" md="10" sm="10" class="">
            <b-row v-for="total in totalRow" :key="total.total">
              <!-- <b-col cols="2">
                <b-skeleton width="70px" animation="fade" class="mt-2"></b-skeleton>
              </b-col> -->
              <b-col>
                <b-skeleton type="input" animation="fade" class="mt-2"></b-skeleton>
              </b-col>
            </b-row>
          </b-col>
        </b-row>
      </template>

      <template v-if="type == 'skeleton-card'">
        <b-skeleton-img></b-skeleton-img>
      </template>
    </template>
  </b-skeleton-wrapper>
</template>

<script>
export default {
  name: 'LoadingSkeleton',
  props:{
    loading:{
      type: Boolean,
      default: false
    },
    type:{
      type: String,
      default: null
    },
    rows:{
      type: Number,
      default: 5
    },
    columns:{
      type: Number,
      default: 4
    },
    totalRow:{
      type: Number,
      default: 2
    },
  }
}
</script>

<style lang="scss" scoped>
.user-image-skeleton{
  width: 100%;
  height: 100%;
}
</style>
