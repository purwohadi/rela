export function getRenkinPerTw(data) {
  return {
    tooltip: {
      trigger: 'axis',
      axisPointer: {
        type: 'shadow'
      },
    },
    dataset: {
      dimensions: ['triwulan', 'capaian'],
      source: data
    },
    grid: {
      left: '5%',
      right: '15%',
      bottom: '3%',
      containLabel: true
    },
    xAxis: [
      {
        type: 'category',
        name: 'Triwulan',
        axisTick: {
          alignWithLabel: true
        }
      }
    ],
    yAxis: [
      {
        name: 'Jumlah'
      }
    ],
    series: [
      {
        name: 'Persentase',
        type: 'bar',
        barWidth: '60%',
        // data: [10, 52, 200, 334, 390, 330, 220]
      }
    ]
  }
}

export function statistikBatas(data) {
  return {
    tooltip: {
      trigger: 'item',
      formatter: function (item) {
        return 'Kelompok : ' + item.value.kelompok + ' <br/> Batas : ' + item.value.keterangan + ' <br/> Total : ' + item.value.total_opd + ' (' + item.percent + '%)'
      }
    },
    legend: {
      bottom: 10,
      left: 'center',
    },
    dataset: {
      dimensions: ['keterangan', 'total_opd', 'kelompok'],
      source: data
    },
    series: [
      {
        type: 'pie',
        radius: '65%',
        center: ['50%', '50%'],
        selectedMode: 'single',
        // data: [
        //   { value: 735, name: 'CityC' },
        //   { value: 510, name: 'CityD' },
        //   { value: 434, name: 'CityB' },
        //   { value: 335, name: 'CityA' },
        //   { value: 335, name: 'CityE' },
        //   { value: 335, name: 'CityF' }
        // ],
        emphasis: {
          itemStyle: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        }
      }
    ]
  }
}
