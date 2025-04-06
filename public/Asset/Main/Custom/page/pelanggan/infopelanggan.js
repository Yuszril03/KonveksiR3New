RequestData()
let dates = new Date()
let YearNow = dates.getFullYear()

let options = {
  series: [
    {
      name: 'Penjualan',
      data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
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

  grid: {
    row: {
      colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
      opacity: 0.5
    }
  },
  yaxis: {
    labels: {
      formatter: function (value) {
        return formatRupiah('' + value)
      }
    },
    title: {
      text: 'Per-Potong'
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

let chart = new ApexCharts(document.querySelector('#chartYear'), options)

function RequestData () {
  setLoadingItem(0)
  setTimeout(function () {
    setData()
    setLoadingItem(1)
  }, 1000)
}
document.getElementById('Back1').addEventListener('click', function () {
  window.location.href = linkUrl + '/Pelanggan'
})
function setLoadingItem (isLoading) {
  if (isLoading == 1) {
    // document.getElementById('loadingDataBawahan').classList.add('d-none')
    document.getElementById('loadingDataLog').classList.add('d-none')
    document.getElementById('loadingDataHarga').classList.add('d-none')
    // document.getElementById('kontenItem').classList.remove('d-none')
  } else {
    // document.getElementById('kontenItem').classList.add('d-none')
    // document.getElementById('loadingDataBawahan').classList.remove('d-none')
    document.getElementById('loadingDataLog').classList.remove('d-none')
    document.getElementById('loadingDataHarga').classList.remove('d-none')
  }
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

function setData () {
  $.ajax({
    type: 'GET',
    url: linkUrl + 'C_Pelanggan/getInformationPelanggan',
    dataType: 'JSON'
  }).done(result => {
    let Pelanggan = result.Pelanggan
    let harga = result.Price
    let Statik = result.Statistik
    // let Log = result.Log
    // let Bawahan = result.Bawahan
    // console.log(result)

    //set EMploye
    document.getElementById('nameEmploye').innerHTML = Pelanggan.Name
    document.getElementById('username').innerHTML =
      Pelanggan.Username != null ? Pelanggan.Username : '-'
    if (Pelanggan.Email != '' && Pelanggan.Email != null) {
      document.getElementById('email').innerHTML = Pelanggan.Email
    } else {
      document.getElementById('email').innerHTML = '-'
    }
    document.getElementById('alamat').innerHTML = Pelanggan.Address
    if (Pelanggan.Gender == null) {
      document.getElementById('gender').innerHTML = '-'
    } else {
      document.getElementById('gender').innerHTML =
        Pelanggan.Gender == '0' ? 'Perempuan' : 'Laki-Laki'
    }

    document.getElementById('telepon').innerHTML = Pelanggan.Telephone
    document.getElementById('status').innerHTML =
      Pelanggan.Status != 1 ? 'Tidak Aktif' : 'Aktif'
    let optionss = {
      // weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }
    let created = new Date(Pelanggan.CreatedDate)
    let updated = new Date(Pelanggan.ModifiedDate)

    document.getElementById('created').innerHTML =
      created.toLocaleDateString('id-ID', optionss) +
      ' ' +
      created.toLocaleTimeString('ru-RU', {
        timeZone: 'Asia/Jakarta',
        hourCycle: 'h23',

        hour: '2-digit',
        minute: '2-digit'
      })
    document.getElementById('update').innerHTML =
      updated.toLocaleDateString('id-ID', optionss) +
      ' ' +
      updated.toLocaleTimeString('ru-RU', {
        timeZone: 'Asia/Jakarta',
        hourCycle: 'h23',

        hour: '2-digit',
        minute: '2-digit'
      })

    if (Pelanggan.ImageProfile == null) {
      if (Pelanggan.Gender == '0') {
        document.getElementById('detailImage').src =
          linkUrl + '/Asset/Main/compiled/jpg/3.jpg'
      } else if (Pelanggan.Gender == '1') {
        document.getElementById('detailImage').src =
          linkUrl + '/Asset/Main/compiled/jpg/2.jpg'
      } else {
        document.getElementById('detailImage').src =
          linkUrl + '/Asset/Icon/no-image.jpg'
      }
    } else {
      document.getElementById('detailImage').src =
        linkUrl + '/' + Pelanggan.ImageProfile
    }

    if (harga.length == 0) {
      document.getElementById('nonePrice').classList.remove('d-none')
      document.getElementById('valuePrice').classList.add('d-none')
    } else {
      document.getElementById('valuePrice').classList.remove('d-none')
      document.getElementById('nonePrice').classList.add('d-none')
      let valuePrice = ''
      for (let i = 0; i < harga.length; i++) {
        let status = 'custom-bg-price-Inactive'
        let StatusText = 'Tidak Aktif'
        if (harga[i].StatusHarga == 1) {
          status = 'custom-bg-price-active'
          StatusText = 'Aktif'
        }
        valuePrice += `<div class='mt-3'>
                        <div class='custom-bg-price ${status}'></div>
                        <div class='custom-konten-price shadow  bg-body-tertiary'>
                          <div class='row'>
                            <div class='col-lg col-4'>
                              <p class='text-muted custom-subtitle'>Produk</p>
                              <p class='fw-bold'>${harga[i].produk}</p>
                            </div>
                            <div class='col-lg col-4'>
                              <p class='text-muted custom-subtitle'>Nama Harga</p>
                              <p class='fw-bold'>${harga[i].NamaHarga}</p>
                            </div>
                            <div class='col-lg col-4'>
                              <p class='text-muted custom-subtitle'>Status</p>
                              <p class='fw-bold'>${StatusText}</p>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                      `
      }
      document.getElementById('valuePrice').innerHTML = valuePrice
    }
    let d = new Date()
    document.getElementById('years').innerHTML = d.getFullYear()

    options = {
      series: [
        {
          name: 'Pembelian',
          data: [
            Statik[0]['Value'],
            Statik[1]['Value'],
            Statik[2]['Value'],
            Statik[3]['Value'],
            Statik[4]['Value'],
            Statik[5]['Value'],
            Statik[6]['Value'],
            Statik[7]['Value'],
            Statik[8]['Value'],
            Statik[9]['Value'],
            Statik[10]['Value'],
            Statik[11]['Value']
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

      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.5
        }
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            return formatRupiah('' + value)
          }
        },
        title: {
          text: 'Transaksi'
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

    chart.render()
    chart.updateOptions(options)
  })
}

document.getElementById('prevStatik').addEventListener('click', function () {
  let year = YearNow - 1
  document.getElementById('nextStatik').disabled = false
  YearNow = year
  document.getElementById('years').innerHTML = YearNow

  let data = {
    years: year
  }
  document.getElementById('loadingDataLog').classList.remove('d-none')
  document.getElementById('chartYear').classList.add('d-none')
  setTimeout(function () {
    document.getElementById('chartYear').classList.remove('d-none')
    document.getElementById('loadingDataLog').classList.add('d-none')
    setDataStatistik(data)
  }, 2000)
})
document.getElementById('nextStatik').addEventListener('click', function () {
  let year = YearNow + 1
  if (year == dates.getFullYear()) {
    document.getElementById('nextStatik').disabled = true
  }
  YearNow = year
  document.getElementById('years').innerHTML = YearNow
  let data = {
    years: year
  }
  document.getElementById('chartYear').classList.add('d-none')
  document.getElementById('loadingDataLog').classList.remove('d-none')
  setTimeout(function () {
    document.getElementById('chartYear').classList.remove('d-none')
    document.getElementById('loadingDataLog').classList.add('d-none')
    setDataStatistik(data)
  }, 2000)
})

function setDataStatistik (data) {
  $.ajax({
    url: linkUrl + '/C_Pelanggan/getStatistikPembelian',
    type: 'POST',
    data: data,
    dataType: 'JSON'
  }).done(Statik => {
    options = {
      series: [
        {
          name: 'Pembelian',
          data: [
            Statik[0]['Value'],
            Statik[1]['Value'],
            Statik[2]['Value'],
            Statik[3]['Value'],
            Statik[4]['Value'],
            Statik[5]['Value'],
            Statik[6]['Value'],
            Statik[7]['Value'],
            Statik[8]['Value'],
            Statik[9]['Value'],
            Statik[10]['Value'],
            Statik[11]['Value']
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

      grid: {
        row: {
          colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
          opacity: 0.5
        }
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            return formatRupiah('' + value)
          }
        },
        title: {
          text: 'Transaksi'
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

    chart.render()
    chart.updateOptions(options)
  })
}
