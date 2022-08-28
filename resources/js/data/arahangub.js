export function pieProsesRapim(data) {
  return {
    tooltip: {
      trigger: 'item',
      formatter: function (item) {
        return 'Status : ' + item.value.status + ' <br/> Jumlah : ' + item.value.jumlah + ' (' + item.percent + '%)'
      }
    },
    legend: {
      bottom: -5,
      left: 'center',
    },
    dataset: {
      dimensions: ['jumlah', 'status'],
      source: data
    },
    series: [
      {
        type: 'pie',
        radius: '65%',
        center: ['50%', '50%'],
        selectedMode: 'single',
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
