getTime()
getOmset()

function getTime () {
  let d = new Date() // for now
  if (d.getHours() > 23 && d.getHours() < 12) {
    document.getElementById('txtTime').innerHTML = 'Selamat Pagi,'
  } else if (d.getHours() >= 12 && d.getHours() < 15) {
    document.getElementById('txtTime').innerHTML = 'Selamat Siang,'
  } else if (d.getHours() >= 15 && d.getHours() < 18) {
    document.getElementById('txtTime').innerHTML = 'Selamat Sore,'
  } else if (d.getHours() >= 18 && d.getHours() < 0) {
    document.getElementById('txtTime').innerHTML = 'Selamat Malam,'
  }
}

function getOmset () {
  $.ajax({
    url: linkUrl + '/C_Transaction/getDataDashboard',
    dataType: 'JSON',
    type: 'GET'
  }).done(result => {
    // console.log(result)
    document.getElementById('textOmsetNow').innerHTML =
      'Rp. ' + formatRupiah('' + result.Omset)

    setChartStatus(result.Status)
    setChartOmsetYear(result.OmsetTahunan)
  })
}

function setChartOmsetYear (Omset) {
  var options = {
    series: [
      {
        name: 'Omset',
        data: [
          Omset[0]['omset'],
          Omset[1]['omset'],
          Omset[2]['omset'],
          Omset[3]['omset'],
          Omset[4]['omset'],
          Omset[5]['omset'],
          Omset[6]['omset'],
          Omset[7]['omset'],
          Omset[8]['omset'],
          Omset[9]['omset'],
          Omset[10]['omset'],
          Omset[11]['omset']
        ]
      }
    ],
    chart: {
      height: 300,
      type: 'line',
      zoom: {
        enabled: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'straight'
    },
    title: {
      text: 'Omset Per-Bulan',
      align: 'left'
    },
    grid: {
      row: {
        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.5
      }
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return 'Rp.' + formatRupiah('' + value)
        }
      }
    },
    xaxis: {
      labels: {
        formatter: function (value) {
          return value
        }
      },
      categories: [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Okt',
        'Nov',
        'Des'
      ]
    }
  }

  var chart = new ApexCharts(document.querySelector('#chartYear'), options)
  chart.render()
}

function setChartStatus (row) {
  let options = {
    series: [
      {
        data: [
          row[0]['Jumlah'],
          row[1]['Jumlah'],
          row[2]['Jumlah'],
          row[3]['Jumlah'],
          row[4]['Jumlah'],
          row[5]['Jumlah']
        ]
      }
    ],
    chart: {
      type: 'bar',
      height: 330
    },
    plotOptions: {
      bar: {
        borderRadius: 4,
        borderRadiusApplication: 'end',
        horizontal: true
      }
    },
    dataLabels: {
      enabled: false
    },
    xaxis: {
      categories: [
        row[0]['Nama'],
        row[1]['Nama'],
        row[2]['Nama'],
        row[3]['Nama'],
        row[4]['Nama'],
        row[5]['Nama']
      ]
    }
  }

  var chart = new ApexCharts(document.querySelector('#chart'), options)
  chart.render()
}

function formatRupiah (angka) {
  if (angka == 0) {
    return '0'
  } else {
    let prefix = ''
    var number_string = angka.replaceAll(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi)

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
      separator = sisa ? '.' : ''
      rupiah += separator + ribuan.join('.')
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah
    return prefix == undefined ? rupiah : rupiah ? rupiah : ''
  }
}
