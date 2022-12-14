<template>
  <!-- eslint-disable vue/no-use-v-if-with-v-for -->
  <!-- eslint-disable vue/v-bind-style -->
  <div class="table-responsive">
    <template v-if="isDataLoading">
      <slot name="loading">Loading...</slot>
    </template>
    <div
      v-else-if="data.length === 0"
      class="alert alert-warning"
      role="alert"
    >{{ noDataWarningText }}</div>
    <table v-else class="table table-bordered" :id="tableId">
      <!-- Table header -->
      <thead>
        <tr
          v-for="(colField, colFieldIndex) in colFields"
          :key="`head-${JSON.stringify(colField)}`"
          v-if="colField.showHeader === undefined || colField.showHeader"
        >
          <!-- Top left dead zone -->
          <th
            v-if="colFieldIndex === firstColFieldHeaderIndex && rowHeaderSize > 0"
            :colspan="rowHeaderSize"
            :rowspan="colHeaderSize"
          ></th>
          <!-- Column headers -->
          <th
            v-for="(col, colIndex) in sortedCols"
            :key="JSON.stringify(col)"
            :colspan="spanSize('col', sortedCols, colIndex, colFieldIndex)"
            v-if="spanSize('col', sortedCols, colIndex, colFieldIndex) !== 0"
            class="text-right"
          >
            <slot
              v-if="colField.headerSlotName"
              :name="colField.headerSlotName"
              v-bind:value="col[`col-${colFieldIndex}`]"
            >
              Missing slot
              <code>{{ colField.headerSlotName }}</code>
            </slot>
            <template v-else>{{ col[`col-${colFieldIndex}`] }}</template>
          </th>
          <!-- Total Header -->
          <th
            key="totalHeader"
            :rowspan="colHeaderSize"
            v-if="showTotal && colFieldIndex === firstColFieldHeaderIndex"
            class="text-right"
          >
            <slot name="totalHEADER" v-bind:value="totalText">
              Missing slot
              <code>totalHEADER</code>
            </slot>
          </th>
          <!-- Top right dead zone -->
          <th
            v-if="colFieldIndex === firstColFieldHeaderIndex && rowFooterSize > 0"
            :colspan="rowFooterSize"
            :rowspan="colFooterSize"
          ></th>
        </tr>
      </thead>
      <!-- Table body -->
      <tbody>
        <tr v-for="(row, rowIndex) in sortedRows" :key="JSON.stringify(row)">
          <!-- Row headers -->
          <th
            v-for="(rowField, rowFieldIndex) in rowFields"
            :key="`head-${JSON.stringify(rowField)}`"
            :rowspan="spanSize('row', sortedRows, rowIndex, rowFieldIndex)"
            v-if="(rowField.showHeader === undefined || rowField.showHeader) && spanSize('row', sortedRows, rowIndex, rowFieldIndex) !== 0"
          >
            <slot
              v-if="rowField.headerSlotName"
              :name="rowField.headerSlotName"
              v-bind:value="row[`row-${rowFieldIndex}`]"
            >
              Missing slot
              <code>{{ rowField.headerSlotName }}</code>
            </slot>
            <template v-else>{{ row[`row-${rowFieldIndex}`] }}</template>
          </th>
          <!-- Values -->
          <td v-for="col in sortedCols" :key="JSON.stringify(col)" class="text-right">
            <slot v-if="$scopedSlots.value" name="value" v-bind:value="value(row, col)" />
            <template v-else>{{ value(row, col) }}</template>
          </td>
          <!-- Total Column -->
          <th :key="`totalRow`" v-if="showTotal" class="text-right">
            <slot name="rowTOTAL" v-bind:value="summary(row, sortedCols)">
              Missing slot
              <code>rowTOTAL</code>
            </slot>
          </th>
          <!-- Row footers (if slots are provided) -->
          <th
            v-for="(rowField, rowFieldIndex) in rowFieldsReverse"
            :key="`foot-${JSON.stringify(rowField)}`"
            :rowspan="spanSize('row', rows, rowIndex, rowFields.length - rowFieldIndex - 1)"
            v-if="rowField.showFooter && spanSize('row', rows, rowIndex, rowFields.length - rowFieldIndex - 1) !== 0"
          >
            <slot
              v-if="rowField.footerSlotName"
              :name="rowField.footerSlotName"
              v-bind:value="row[`row-${rowFields.length - rowFieldIndex - 1}`]"
            >
              Missing slot
              <code>{{ rowField.footerSlotName }}</code>
            </slot>
            <template v-else>{{ row[`row-${rowFields.length - rowFieldIndex - 1}`] }}</template>
          </th>
        </tr>
      </tbody>

      <!-- Table footer -->
      <tfoot>
        <!-- TOTAL Column -->
        <tr :key="`totalFooter`" v-if="showTotal">
          <!-- Bottom left dead zone -->
          <th :colspan="rowHeaderSize" class="text-right">
            <slot name="totalFOOTER" v-bind:value="totalText">
              Missing slot
              <code>totalFOOTER</code>
            </slot>
          </th>
          <!-- Column footers -->
          <th v-for="col in sortedCols" :key="JSON.stringify(col)" class="text-right">
            <slot name="colTOTAL" v-bind:value="summary(col, sortedRows)" />
          </th>
          <!-- Bottom right dead zone -->
          <th :colspan="rowFooterSize"></th>
        </tr>
        <tr
          v-for="(colField, colFieldIndex) in colFieldsReverse"
          :key="`foot-${JSON.stringify(colField)}`"
          v-if="colField.showFooter"
        >
          <!-- Bottom left dead zone -->
          <th
            v-if="colFieldIndex === firstColFieldFooterIndex && rowHeaderSize > 0"
            :colspan="rowHeaderSize"
            :rowspan="colHeaderSize"
          ></th>
          <!-- Column footers -->
          <th
            v-for="(col, colIndex) in sortedCols"
            :key="JSON.stringify(col)"
            :colspan="spanSize('col', sortedCols, colIndex, colFields.length - colFieldIndex - 1)"
            v-if="spanSize('col', sortedCols, colIndex, colFields.length - colFieldIndex - 1) !== 0"
          >
            <slot
              v-if="colField.footerSlotName"
              :name="colField.footerSlotName"
              v-bind:value="col[`col-${colFields.length - colFieldIndex - 1}`]"
            >
              Missing slot
              <code>{{ colField.footerSlotName }}</code>
            </slot>
            <template v-else>{{ col[`col-${colFields.length - colFieldIndex - 1}`] }}</template>
          </th>
          <!-- Bottom right dead zone -->
          <th
            v-if="colFieldIndex === firstColFieldFooterIndex && rowFooterSize > 0"
            :colspan="rowFooterSize"
            :rowspan="colFooterSize"
          ></th>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
import HashTable from './HashTable'
import { firstBy } from 'thenby'
import naturalSort from 'javascript-natural-sort'

export default {
  name: 'PivotTable',
  props: {
    id: {
      type: String,
      default: null
    },
    data: {
      type: Array,
      default: () => []
    },
    rowFields: {
      type: Array,
      default: () => []
    },
    colFields: {
      type: Array,
      default: () => []
    },
    reducer: {
      type: Function,
      default: (sum, item) => sum + 1
    },
    noDataWarningText: {
      type: String,
      default: 'No data to display.'
    },
    isDataLoading: {
      type: Boolean,
      default: false
    },
    showTotal: {
      type: Boolean,
      default: false
    },
    totalText: {
      type: String,
      default: 'TOTAL'
    }
  },
  data: function() {
    return {
      valuesHashTable: null,
      cols: null,
      rows: null
    }
  },
  computed: {
    tableId: function() {
      if (this.id == null || this.id == '') {
        return 'pivot-'+Math.random().toString(36).replace('0.', '')
      }
      return  this.id
    },
    // Sort cols/rows using a composed function built with thenBy.js
    sortedCols: function() {
      let composedSortFunction
      this.colFields.forEach((colField, colFieldIndex) => {
        if (colFieldIndex === 0) {
          composedSortFunction = firstBy('col-0', {
            cmp: colField.sort || naturalSort
          })
        } else {
          composedSortFunction = composedSortFunction.thenBy(
            `col-${colFieldIndex}`,
            { cmp: colField.sort || naturalSort }
          )
        }
      })

      return [...this.cols].sort(composedSortFunction)
    },
    sortedRows: function() {
      let composedSortFunction
      this.rowFields.forEach((rowField, rowFieldIndex) => {
        if (rowFieldIndex === 0) {
          composedSortFunction = firstBy('row-0', {
            cmp: rowField.sort || naturalSort
          })
        } else {
          composedSortFunction = composedSortFunction.thenBy(
            `row-${rowFieldIndex}`,
            { cmp: rowField.sort || naturalSort }
          )
        }
      })

      return [...this.rows].sort(composedSortFunction)
    },
    // Compound property for watch single callback
    fields: function() {
      return [this.colFields, this.rowFields]
    },
    // Reversed props for footer iterators
    colFieldsReverse: function() {
      return this.colFields.slice().reverse()
    },
    rowFieldsReverse: function() {
      return this.rowFields.slice().reverse()
    },
    // Number of col header rows
    colHeaderSize: function() {
      return this.colFields.filter(
        colField => colField.showHeader === undefined || colField.showHeader
      ).length
    },
    // Number of col footer rows
    colFooterSize: function() {
      // let footerSize = this.colFields.filter(colField => colField.showFooter).length
      // let totalSize = this.showTotal ? 1 : 0
      // return  footerSize + totalSize
      return this.colFields.filter(colField => colField.showFooter).length
    },
    // Number of row header columns
    rowHeaderSize: function() {
      return this.rowFields.filter(
        rowField => rowField.showHeader === undefined || rowField.showHeader
      ).length
    },
    // Number of row footer columns
    rowFooterSize: function() {
      // let footerSize = this.rowFields.filter(rowField => rowField.showFooter).length
      // let totalSize = this.showTotal ? 1 : 0
      // return  footerSize + totalSize
      return this.rowFields.filter(rowField => rowField.showFooter).length
    },
    // Index of the first column field header to show - used for table header dead zones
    firstColFieldHeaderIndex: function() {
      return this.colFields.findIndex(
        colField => colField.showHeader === undefined || colField.showHeader
      )
    },
    // Index of the first column field footer to show - used for table footer dead zones
    firstColFieldFooterIndex: function() {
      return this.colFieldsReverse.findIndex(colField => colField.showFooter)
    }
  },
  watch: {
    fields: function() {
      this.computeData()
    },
    data: function() {
      this.computeData()
    }
  },
  created: function() {
    this.computeData()
  },
  methods: {
    summary: function(data, items) {
      let vm = this
      let total = items.reduce(function(sum, next) {
        let value = vm.valuesHashTable.get({ ...data, ...next }) || 0
        return sum + value
      }, 0)
      return { value: total }
    },
    // Get value from valuesHashTable
    value: function(row, col) {
      let result = this.valuesHashTable.get({ ...row, ...col }) || 0
      return { ...row, ...col, value: result }
    },
    // Get colspan/rowspan size
    spanSize: function(type, values, valueIndex, fieldIndex) {
      // If left value === current value
      // and top value === 0 (= still in the same top bracket)
      // The left td will take care of the display
      if (
        valueIndex > 0 &&
        values[valueIndex - 1][`${type}-${fieldIndex}`] ===
          values[valueIndex][`${type}-${fieldIndex}`] &&
        (fieldIndex === 0 ||
          this.spanSize(type, values, valueIndex, fieldIndex - 1) === 0)
      ) {
        return 0
      }

      // Otherwise, count entries on the right with the same value
      // But stop if the top value !== 0 (= the top bracket has changed)
      let size = 1
      let i = valueIndex
      while (
        i + 1 < values.length &&
        values[i + 1][`${type}-${fieldIndex}`] ===
          values[i][`${type}-${fieldIndex}`] &&
        (fieldIndex === 0 ||
          (i + 1 < values.length &&
            this.spanSize(type, values, i + 1, fieldIndex - 1) === 0))
      ) {
        i++
        size++
      }

      return size
    },
    // Called when fields have changed => recompute cols/rows/values
    computeData: function() {
      const cols = []
      const rows = []
      const valuesHashTable = new HashTable()

      this.data.forEach(item => {
        // Update cols/rows
        const colKey = {}
        this.colFields.forEach((field, index) => {
          colKey[`col-${index}`] = field.getter(item)
        })

        if (
          !cols.some(col => {
            return this.colFields.every(
              (colField, index) =>
                col[`col-${index}`] === colKey[`col-${index}`]
            )
          })
        ) {
          cols.push(colKey)
        }

        const rowKey = {}
        this.rowFields.forEach((field, index) => {
          rowKey[`row-${index}`] = field.getter(item)
        })

        if (
          !rows.some(row => {
            return this.rowFields.every(
              (rowField, index) =>
                row[`row-${index}`] === rowKey[`row-${index}`]
            )
          })
        ) {
          rows.push(rowKey)
        }

        // Update valuesHashTable
        const key = { ...colKey, ...rowKey }

        const previousValue = valuesHashTable.get(key) || 0

        valuesHashTable.set(key, this.reducer(previousValue, item))
      })

      this.cols = cols
      this.rows = rows
      this.valuesHashTable = valuesHashTable
    }
  }
}
</script>

<style scoped>
td {
  min-width: 100px;
}
</style>
