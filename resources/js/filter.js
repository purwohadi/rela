import Vue from 'vue'
import moment from 'moment'

Vue.filter('formatSize', function (size) {
  if (size > 1024 * 1024 * 1024 * 1024) {
    return (size / 1024 / 1024 / 1024 / 1024).toFixed(1) + ' TB'
  } else if (size > 1024 * 1024 * 1024) {
    return (size / 1024 / 1024 / 1024).toFixed(1) + ' GB'
  } else if (size > 1024 * 1024) {
    return (size / 1024 / 1024).toFixed(1) + ' MB'
  } else if (size > 1024) {
    return (size / 1024).toFixed(1) + ' KB'
  }
  return size.toString() + ' B'
})

Vue.filter('formatDate', function (value) {
  if (value) {
    return moment(String(value)).format('DD MMM YYYY HH:mm')
  }
});

Vue.filter('formatDateShort', function (value) {
  moment.locale('id')
  if (value) {
    return moment(String(value), 'DD-MM-YYYY HH:mm').format('DD MMM YYYY HH:mm')
  }
});

Vue.filter('formatDateNoTime', function (value) {
  if (value) {
    moment.locale('id')
    return moment(String(value)).format('DD MMM YYYY')
  }
});

Vue.filter('formatFullWithDay', function (value) {
  if (value) {
    moment.locale('id')
    return moment(String(value)).format('dddd, DD MMMM YYYY')
  }
  return '-'
});

Vue.filter('formatFullTime', function (value) {
  if (value) {
    moment.locale('id')
    return moment(String(value)).format('HH:mm:ss')
  }
});
Vue.filter('formatSecondToFullTime', function (value) {
  if (value) {
    moment.locale('id')
    return moment.utc(value*1000).format('HH:mm:ss')
  }
});

Vue.filter('formatFullDateAndTime', function (value) {
  if (value) {
    moment.locale('id')
    return moment(String(value)).format('DD MMM YYYY HH:mm:ss')
  }
});

Vue.filter('formatDateNoYear', function (value) {
  if (value) {
    moment.locale('id')
    return moment(String(value)).format('DD MMM')
  }
});

Vue.filter('formatRelativeDay', function (value) {
  if (value) {
    moment.locale('id')
    return moment(String(value)).startOf('day').fromNow()
  }
});
Vue.filter('formatRelativeHour', function (value) {
  if (value) {
    moment.locale('id')
    let isToday = moment(String(value)).isSame(moment(), 'day');
    if(isToday) {
      return moment(value).fromNow()
    }
    else {
      return moment(String(value), 'YYYY-MM-DD HH:mm').format('DD MMM YYYY HH:mm')
    }
  }
});

Vue.filter('formatDateFull', function (value) {
  moment.locale('id')
  if (value) {
    return moment(String(value)).format('DD MMMM YYYY')
  }
});
Vue.filter('formatYearOnly', function (value) {
  moment.locale('id')
  if (value) {
    return moment(String(value)).format('YYYY')
  }
});

Vue.filter('formatMonthOnly', function (value) {
  moment.locale('id')
  if (value) {
    return moment(String(value)).format('MM')
  }
});

Vue.filter('formatMonthNameOnly', function (value) {
  moment.locale('id')
  if (value) {
    return moment(String(value), 'MM').format('MMMM')
  }
});

Vue.filter('formatMonthNameOnlyYearMonth', function (value) {
  moment.locale('id')
  if (value) {
    return moment(String(value)).format('MMMM')
  }
});

Vue.filter("formatNumber", function (value) {
  return new Intl.NumberFormat().format(value)
});

Vue.filter('formatMonthNameYear', function (value) {
  moment.locale('id')
  if (value) {
    return moment(String(value)).format('MMMM YYYY')
  }
});



