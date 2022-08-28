<template>
  <section class="renkin-revision">
    <span>
      <template v-if="isActive">
        <span v-if="item.hasOwnProperty(fieldRev) && item[fieldRev] && item[field] != item[fieldRev]">
          <del class="text-muted">{{ item[field] }}</del>&nbsp;{{ item[`${fieldRev}`] }}
        </span>
        <span v-else>
          {{ item[field] }}
        </span>
      </template>
      <template v-else>
        <span v-if="item.hasOwnProperty(fieldRev) && item[fieldRev] && item[field] != item[fieldRev]">
          <del
            class="text-muted"
            :style="{ 'text-decoration-style': 'double' }"
          >
            {{ item[field] }}
          </del>
          &nbsp;<del class="text-muted">{{ item[`${fieldRev}`] }}</del>
        </span>
        <span v-else>
          <del class="text-muted">{{ item[field] }} </del>
        </span>
      </template>
    </span>

    <template v-if="suffix && suffix.length">
      <span v-if="isActive">
        <template v-if="suffixAsString">
          {{ suffix }}
        </template>
        <template v-else>
          {{ item.hasOwnProperty(suffix) ? item[suffix] : '' }}
        </template>
      </span>
      <span v-else>
        <del class="text-muted">
          <template v-if="suffixAsString">
            {{ suffix }}
          </template>
          <template v-else>
            {{ item.hasOwnProperty(suffix) ? item[suffix] : '' }}
          </template>
        </del>
      </span>
    </template>
  </section>
</template>

<script>
export default {
  name: 'RenkinRevision',
  props: {
    item: {
      type: Object,
      required: true,
    },
    field: {
      type: String,
      required: true,
    },
    fieldRev: {
      type: String,
      required: true
    },
    suffix: {
      type: String,
      required: false
    },
    suffixAsString: {
      type: Boolean,
      required: false,
      default: false
    },
    isActive: {
      type: Boolean,
      required: true
    }
  }
}
</script>

<style>

</style>
