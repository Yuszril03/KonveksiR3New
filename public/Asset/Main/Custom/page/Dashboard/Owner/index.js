getTime()
getOmset()
getProduksiDashboard()

function getTime () {
  let d = new Date() // for now
  if (d.getHours() >= 0 && d.getHours() < 12) {
    document.getElementById('txtTime').innerHTML = 'Selamat Pagi,'
  } else if (d.getHours() >= 12 && d.getHours() < 15) {
    document.getElementById('txtTime').innerHTML = 'Selamat Siang,'
  } else if (d.getHours() >= 15 && d.getHours() < 18) {
    document.getElementById('txtTime').innerHTML = 'Selamat Sore,'
  } else if (d.getHours() >= 18 && d.getHours() <= 23) {
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

    setChartOmsetYear(result.OmsetTahunan)
  })
}

function getProduksiDashboard () {
  $.ajax({
    url: linkUrl + '/C_Product/getDataDashboard',
    dataType: 'JSON',
    type: 'GET'
  }).done(result => {
    // console.log(result)
    setChartProduk(result)
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

function setChartProduk (row) {
  let options = {
    series: [
      {
        name: 'Masuk',
        data: [
          row[0]['Masuk'],
          row[1]['Masuk'],
          row[2]['Masuk'],
          row[3]['Masuk'],
          row[4]['Masuk'],
          row[5]['Masuk'],
          row[6]['Masuk'],
          row[7]['Masuk'],
          row[8]['Masuk'],
          row[9]['Masuk'],
          row[10]['Masuk'],
          row[11]['Masuk']
        ]
      },
      {
        name: 'Keluar',
        data: [
          row[0]['Keluar'],
          row[1]['Keluar'],
          row[2]['Keluar'],
          row[3]['Keluar'],
          row[4]['Keluar'],
          row[5]['Keluar'],
          row[6]['Keluar'],
          row[7]['Keluar'],
          row[8]['Keluar'],
          row[9]['Keluar'],
          row[10]['Keluar'],
          row[11]['Keluar']
        ]
      }
    ],
    chart: {
      type: 'bar',
      height: 335
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '55%',
        borderRadius: 5,
        borderRadiusApplication: 'end'
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      show: true,
      width: 3,
      colors: ['transparent']
    },
    xaxis: {
      categories: [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mai',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Des'
      ]
    },
    yaxis: {
      title: {
        text: 'Per-Potong'
      }
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return ' ' + formatRupiah(val + '') + ' Potong'
        }
      }
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
