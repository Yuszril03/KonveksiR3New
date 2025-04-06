let tanggalFormat = $('.selector').flatpickr({
  mode: 'range',
  dateFormat: 'Y-m-d',
  maxDate: 'today',
  onClose: function (selectedDates, dateStr, instance) {
    checkDate(selectedDates)
  }
})
let queryData = {
  startDate: '',
  endDate: '',
  Selisih: 0
}
let options = {
  series: [
    {
      name: 'Aktivitas',
      data: []
    }
  ],
  chart: {
    height: 350,
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
  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    }
  },
  xaxis: {
    categories: []
  }
}
let chart = new ApexCharts(document.querySelector('#chartTrans'), options)

let dateSelect1 = new Date()
let dateSelect2 = new Date()

let isFilter = 0
setAktivitas()
getTime()
getTotal()
setOnlineUser()

function setAktivitas () {
  if (isFilter == 0) {
    let DateNow = new Date()
    let DateBefore = new Date()
    DateBefore.setDate(DateNow.getDate() - 7)
    queryData = {
      startDate: formatDate(DateBefore),
      endDate: formatDate(DateNow),
      Selisih: 7
    }
    let date7Seven = [formatDate(DateBefore), formatDate(DateNow)]
    tanggalFormat.setDate(date7Seven)
  } else {
    queryData = {
      startDate: formatDate(dateSelect1),
      endDate: formatDate(dateSelect2),
      Selisih: getSelisih(formatDate(dateSelect1), formatDate(dateSelect2))
    }
  }

  $.ajax({
    url: linkUrl + '/C_Activity/activityUserEmploye',
    dataType: 'JSON',
    type: 'POST',
    data: queryData
  }).done(result => {
    // console.log(queryData)
    let arrayNameDate = []
    let arrayValueDate = []
    for (let i = 0; i < result.length; i++) {
      arrayNameDate.push(result[i]['Name'])
      arrayValueDate.push(result[i]['Value'])
    }

    options = {
      series: [
        {
          name: 'Aktivitas',
          data: arrayValueDate
        }
      ],
      chart: {
        height: 350,
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
      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.5
        }
      },
      xaxis: {
        categories: arrayNameDate
      }
    }

    if (isFilter == 0) {
      chart.render()
      chart.updateOptions(options)
    } else {
      chart.updateOptions(options)
    }
  })
}

function formatDate (date) {
  var d = new Date(date),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear()

  if (month.length < 2) month = '0' + month
  if (day.length < 2) day = '0' + day

  return [year, month, day].join('-')
}
// getSelisih('2025-01-25', '2025-01-27')

function getSelisih (start, end) {
  let diff = new Date(new Date(end) - new Date(start)),
    days = diff / 1000 / 60 / 60 / 24

  return parseInt(days)
}

function checkDate (data) {
  dateSelect1 = new Date(data[0])
  dateSelect2 = new Date(data[1])

  if (dateSelect1.getTime() == dateSelect2.getTime()) {
    tanggalFormat.clear()
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Pilih lebih dari 1 Hari'
    })
  } else if (!isNaN(dateSelect1.getDate())) {
    isFilter = 1
    setAktivitas()
  }
}

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

function getTotal () {
  // 1 Total Trans
  $.ajax({
    url: linkUrl + '/C_Transaction/getTotalTransAdmin',
    dataType: 'JSON'
  }).done(result => {
    document.getElementById('totalTrans').innerHTML = formatRupiah(
      result.length + ''
    )
  })
  // 2 Total Produk
  $.ajax({
    url: linkUrl + '/C_Product/getData',
    dataType: 'JSON'
  }).done(result => {
    document.getElementById('totalProduk').innerHTML = formatRupiah(
      result.length + ''
    )
  })
  // 3 Total Pelanggan
  $.ajax({
    url: linkUrl + '/C_Pelanggan/getData',
    dataType: 'JSON'
  }).done(result => {
    document.getElementById('totalPelanggan').innerHTML = formatRupiah(
      result.length + ''
    )
  })
}

function setOnlineUser () {
  $.ajax({
    url: linkUrl + '/C_Employee/getOnlineUser',
    dataType: 'JSON'
  }).done(result => {
    // console.log(result)
    if (result.length == 0) {
      document.getElementById('offlineUser').classList.remove('d-none')
      document.getElementById('onlineUser').classList.add('d-none')
    } else {
      document.getElementById('offlineUser').classList.add('d-none')
      document.getElementById('onlineUser').classList.remove('d-none')
      let temp = ''
      for (let i = 0; i < result.length; i++) {
        let img = linkUrl + '/Asset/Main/compiled/jpg/2.jpg'
        if (result[i]['Image'] != null) {
          img = linkUrl + '/' + result[i]['Image']
        } else {
          if (result[i]['Gender'] == 0) {
            img = linkUrl + '/Asset/Main/compiled/jpg/3.jpg'
          }
        }
        temp += `<div class="d-flex bd-highlight" style="margin-top: -10px;">
                    <div class="p-2 flex-shrink-1 bd-highlight">
                        <div class="avatar avatar-md2">
                            <img class="custom-img-online" src="${img}" alt="Avatar">
                        </div>
                    </div>
                    <div class="p-2 w-100 bd-highlight">
                        <h6 class="mt-1">${result[i]['Nama']}</h6>
                        <p style="margin-top: -5px;">${result[i]['Kegiatan']}</p>
                    </div>
                </div>`
      }
      document.getElementById('onlineUser').innerHTML = temp
    }
  })
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
