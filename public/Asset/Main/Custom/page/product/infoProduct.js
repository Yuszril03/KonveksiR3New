let searchPrice = new bootstrap.Modal(document.getElementById('searchPrice'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let dates = new Date()
let YearNow = dates.getFullYear()

let queryFilter = {
  IsProduct: true,
  IsPrice: true,
  queryPrice: '1=1',
  IsLog: true,
  IsStatik: true,
  yearStatik: YearNow
}
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

let isFirst = 0

document.getElementById('years').innerHTML = YearNow
setData()

function setData () {
  $.ajax({
    url: linkUrl + '/C_Product/getInfoProduct',
    data: queryFilter,
    type: 'POST',
    dataType: 'JSON'
  }).done(result => {
    if (isFirst == 0) {
      isFirst = 1
      queryFilter = {
        IsProduct: false,
        IsPrice: false,
        queryPrice: '1=1',
        IsLog: false,
        IsStatik: false,
        yearStatik: YearNow
      }
    }
    // console.log(result)
    let produk = result.Product
    let harga = result.Harga
    let log = result.Log
    let Statik = result.Statik

    if (result.IsProduct == 'true') {
      if (produk.Image == null) {
        document.getElementById('detailImage').src =
          linkUrl + '/Asset/Icon/empty-image-produk.svg'
      } else {
        document.getElementById('detailImage').src = linkUrl + '' + produk.Image
      }
      document.getElementById('stok').innerHTML =
        formatRupiah('' + produk.Stock) + '/ Potong'
      document.getElementById('nameProduk').innerHTML = produk.Name
      document.getElementById('typeProduk').innerHTML = produk.Jenis
      document.getElementById('materialProduk').innerHTML = produk.Bahan
      document.getElementById('sizeProduk').innerHTML = produk.Size
      document.getElementById('pricePotong').innerHTML =
        'Rp.' + formatRupiah('' + produk.Per_Piece)
      document.getElementById('priceLusin').innerHTML =
        'Rp.' + formatRupiah('' + produk.Per_Doze)
      document.getElementById('priceKodi').innerHTML =
        'Rp.' + formatRupiah('' + produk.Per_Kodi)
    }

    if (result.IsHarga == 'true') {
      if (harga.length == 0) {
        document.getElementById('nonePrice').classList.remove('d-none')
        document.getElementById('valuePrice').classList.add('d-none')
      } else {
        document.getElementById('valuePrice').classList.remove('d-none')
        document.getElementById('nonePrice').classList.add('d-none')
        let valuePrice = ''
        for (let i = 0; i < harga.length; i++) {
          let status = 'custom-bg-price-Inactive'
          if (harga[i].Status == 1) {
            status = 'custom-bg-price-active'
          }
          valuePrice += `<div class='mt-3'>
                        <div class='custom-bg-price ${status}'></div>
                        <div class='custom-konten-price shadow  bg-body-tertiary'>
                          <div class='row'>
                            <div class='col-lg col-12'>
                              <p class='text-muted custom-subtitle'>Nama Harga</p>
                              <p class='fw-bold'>${harga[i].Name}</p>
                            </div>
                            <div class='col-lg col-4'>
                              <p class='text-muted custom-subtitle'>Per-Potong</p>
                              <p class='fw-bold'>Rp.${formatRupiah(
                                '' + harga[i].Per_Piece
                              )}</p>
                            </div>
                            <div class='col-lg col-4'>
                              <p class='text-muted custom-subtitle'>Per-Lusin</p>
                              <p class='fw-bold'>Rp.${formatRupiah(
                                '' + harga[i].Per_Dozen
                              )}</p>
                            </div>
                            <div class='col-lg col-4'>
                              <p class='text-muted custom-subtitle'>Per-Kodi</p>
                              <p class='fw-bold'>Rp.${formatRupiah(
                                '' + harga[i].Per_Kodi
                              )}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      `
        }
        document.getElementById('valuePrice').innerHTML = valuePrice
      }
    }
    if (result.IsLog == 'true') {
      if (log.length == 0) {
        document.getElementById('noneLog').classList.remove('d-none')
        document.getElementById('valueLog').classList.add('d-none')
      } else {
        document.getElementById('valueLog').classList.remove('d-none')
        document.getElementById('noneLog').classList.add('d-none')
        let valueLog = ''
        let options = {
          // weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        }
        for (let i = 0; i < log.length; i++) {
          let today = new Date(log[i]['CreatedDate'])
          valueLog += ` <div class="d-flex bd-highlight mt-2">
                            <div class="d-lg-none d-none custom-padding bd-highlight">
                                <p class="text-muted custom-date">${today.toLocaleDateString(
                                  'id-ID',
                                  options
                                )} ${today.toLocaleTimeString('ru-RU', {
            timeZone: 'Asia/Jakarta',
            hourCycle: 'h23',

            hour: '2-digit',
            minute: '2-digit'
          })}</p>
                            </div>
                            <div class="customLeghty bd-highlight"></div>
                            <div class="custom-padding bd-highlight">
                                <p class="d-lg-block d-block text-muted custom-date">${today.toLocaleDateString(
                                  'id-ID',
                                  options
                                )} ${today.toLocaleTimeString('ru-RU', {
            timeZone: 'Asia/Jakarta',
            hourCycle: 'h23',

            hour: '2-digit',
            minute: '2-digit'
          })}</p>
                                <p class="mb-0 fw-bold">${
                                  log[i].Description
                                }</p>
                            </div>
                        </div>`
        }

        document.getElementById('valueLog').innerHTML = valueLog
      }
    }

    if (result.IsStatik == 'true') {
      options = {
        series: [
          {
            name: 'Penjualan',
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

      chart.render()
      chart.updateOptions(options)
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

document
  .getElementById('btnFilterPrice')
  .addEventListener('click', function () {
    searchPrice.show()
  })

document
  .getElementById('resetFilterPrice')
  .addEventListener('click', function () {
    let TempqueryFilter = {
      IsProduct: queryFilter.IsProduct,
      IsPrice: true,
      queryPrice: '1=1',
      IsLog: queryFilter.IsLog,
      IsStatik: false,
      yearStatik: queryFilter.yearStatik
    }
    queryFilter = TempqueryFilter
    setData()
    queryFilter.IsPrice = false
    document.getElementById('textNamePrice').value = ''
    $('input[name="statusPrice"]').val(['all'])
    document
      .getElementById('iconFilterPrice')
      .classList.remove('bi-funnel-fill')
    document.getElementById('iconFilterPrice').classList.add('bi-funnel')
  })

document
  .getElementById('submitFilterPrice')
  .addEventListener('click', function () {
    let text = document.getElementById('textNamePrice').value
    let status = $('input[name="statusPrice"]:checked').val()
    let valueQuery = '1=1'
    if (text != '') {
      valueQuery += ` AND Name LIKE '%${text}%'`
    }
    if (status != 'all') {
      valueQuery += ' AND Status = ' + status
    }
    let TempqueryFilter = {
      IsProduct: queryFilter.IsProduct,
      IsPrice: true,
      queryPrice: valueQuery,
      IsLog: queryFilter.IsLog,
      IsStatik: false,
      yearStatik: queryFilter.yearStatik
    }
    queryFilter = TempqueryFilter
    document.getElementById('iconFilterPrice').classList.remove('bi-funnel')
    document.getElementById('iconFilterPrice').classList.add('bi-funnel-fill')
    setData()
    searchPrice.hide()
  })

document.getElementById('Back1').addEventListener('click', function () {
  window.location.href = linkUrl + '/Produk'
})

document.getElementById('prevStatik').addEventListener('click', function () {
  let year = YearNow - 1
  document.getElementById('nextStatik').disabled = false
  YearNow = year
  document.getElementById('years').innerHTML = YearNow
  let TempqueryFilter = {
    IsProduct: queryFilter.IsProduct,
    IsPrice: false,
    queryPrice: queryFilter.queryPrice,
    IsLog: queryFilter.IsLog,
    IsStatik: true,
    yearStatik: YearNow
  }
  queryFilter = TempqueryFilter
  setData()
})
document.getElementById('nextStatik').addEventListener('click', function () {
  let year = YearNow + 1
  if (year == dates.getFullYear()) {
    document.getElementById('nextStatik').disabled = true
  }
  YearNow = year
  document.getElementById('years').innerHTML = YearNow
  let TempqueryFilter = {
    IsProduct: queryFilter.IsProduct,
    IsPrice: false,
    queryPrice: queryFilter.queryPrice,
    IsLog: queryFilter.IsLog,
    IsStatik: true,
    yearStatik: YearNow
  }
  queryFilter = TempqueryFilter
  setData()
})
