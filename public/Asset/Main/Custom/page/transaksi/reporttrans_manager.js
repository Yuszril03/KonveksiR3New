setKasir()
setCustomer()

let query = {
  query: '1=1 ',
  sort: 'DESC',
  spanKasir: '',
  spanTanggal: '',
  SearchStatus: 0
}
let datFilter = {
  sort: 'DESC',
  kasir: '',
  status: '',
  lastEdit: ''
}

let isFilter = 0
let Page = 1
let data = []

RequestData()

let tanggalFormat = $('.selector').flatpickr({
  mode: 'range',
  dateFormat: 'Y-m-d',
  maxDate: 'today'
})

function setLoadingList (isLoading) {
  if (isLoading == 1) {
    document.getElementById('loadingData').classList.add('d-none')
    document.getElementById('listTrans').classList.remove('d-none')
  } else {
    document.getElementById('listTrans').classList.add('d-none')
    document.getElementById('loadingData').classList.remove('d-none')
  }
}

function RequestData () {
  setLoadingList(0)
  document.getElementById('emptydata').classList.add('d-none')
  setTimeout(function () {
    setLoadingList(1)
    setData()
  }, 3000)
}

function setData () {
  $.ajax({
    url: linkUrl + 'C_Transaction/getHistoryTransManager3',
    dataType: 'JSON',
    data: query,
    method: 'POST'
  }).done(result => {
    if (result.data.length == 0) {
      document.getElementById('emptydata').classList.remove('d-none')
    } else {
      document.getElementById('emptydata').classList.add('d-none')
    }
    // console.log(result)
    data = result.data
    Page = result.jumlah
    document.getElementById('totalTransaksi').innerHTML = formatRupiah(
      '' + data.length
    )
    document.getElementById('omset').innerHTML =
      'Rp.' + formatRupiah('' + result.sum)
    setList(1, Page)
    // setSpans(
    //   result.isFilter,
    //   result.spanSort,
    //   result.spanStatus,
    //   result.spanTanggal,
    //   result.spanKasir
    // )
  })
}
function setList (pages, total) {
  let batas = 10
  // console.log(total)

  let initial = batas * (pages - 1)
  batas = batas * pages
  let count = 0
  let values = ''
  // console.log(data)
  for (let i = initial; i < batas; i++) {
    if (data[i] != null) {
      var options = {
        // weekday: 'long',
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      }
      var today = new Date(data[i]['TGLBayar'])

      let status = `<span class="badge text-bg-primary">Teruskan</span>`
      let pay = 0
      let metode = 'Tunai'
      if (data[i]['OverPay'] == 0) {
        pay = data[i]['Payment'] - data[i]['ChangePay']
      } else {
        pay = data[i]['Payment']
      }
      if (data[i]['Image'] != null) {
        metode = 'Transfer'
      }

      values += `
      <div class="mt-3 mb-3">
      <div class="name-Kasir">
        
      </div>
      <div class='shadow  bg-body-tertiary container-list'>
      <div class='row'>
        <div class='col-lg-2 col-12'>
          <p class='text-muted'>No.Transaksi</p>
          <p class='fw-bold list-values'>${data[i]['Number_Trans']}</p>
        </div>
        <div class='col-lg-2 col-12'>
          <p class='text-muted'>Pelanggan</p>
          <p class='fw-bold list-values'>${data[i]['Customer']}</p>
        </div>
        <div class='col-lg-2 col-6'>
          <p class='text-muted'>Kasir</p>
          <p class='fw-bold list-values'>${data[i]['Kasir']}</p>
        </div>
        <div class='col-lg-2 col-6'>
          <p class='text-muted'>Tgl. Bayar</p>
          <p class='fw-bold list-values'>${today.toLocaleDateString(
            'id-ID',
            options
          )}  ${today.getHours()}:${today.getMinutes()}</p>
        </div>
        <div class='col-lg-2 col-6'>
          <p class='text-muted'>Bayar</p>
          <p class='fw-bold list-values'>Rp.${formatRupiah('' + pay)}</p>
        </div>
        <div class='col-lg-2 col-6'>
          <p class='text-muted'>Metode</p>
          <p class='fw-bold list-values'>${metode}</p>
        </div>
      </div>
    </div>
    </div>
    `
    }
  }

  document.getElementById('listTrans').innerHTML = values
  setPage(pages, total)
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

function setPage (pages, total) {
  let navPage = `<ul class="pagination justify-content-end">`
  let li = ''
  let prev = ''
  let next = ''
  let ipage = pages - 1
  let countPage = 1
  if (pages == 1) {
    ipage = 1
  } else {
    if (pages == total) {
      ipage = pages - 2
    } else if ((pages - 1) % 3 == 0) {
      ipage = pages
    } else {
      if ((pages + 1) % 3 == 0) {
        ipage = pages - 1
      } else if ((pages + 2) % 3 == 0) {
        ipage = pages
      }
    }
  }
  // console.log(pages == total)
  for (let i = ipage; i <= total; i++) {
    if (i >= 1) {
      if (countPage < 4) {
        if (i == pages) {
          li += ` <li class="page-item active"><a class="page-link active" href="javascript:void(0)" onclick="setList(${i},${Page});">${i}</a></li>`
        } else {
          li += ` <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="setList(${i},${Page});">${i}</a></li>`
        }
      }
    }

    countPage++
  }
  if (pages == 1 || total == 1) {
    prev = `<li class="page-item disabled">
                <a class="page-link" >
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>`
  } else {
    prev = `<li class="page-item ">
                <a class="page-link" href="javascript:void(0)" onclick="setList(${
                  pages - 1
                },${Page});">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>`
  }
  if (pages == 1 && total == 1) {
    next = `<li class="page-item disabled">
                <a class="page-link">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>`
  } else if (pages == total) {
    next = `<li class="page-item disabled">
                <a class="page-link" >
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>`
  } else {
    next = `<li class="page-item ">
                <a class="page-link" href="javascript:void(0)" onclick="setList(${
                  pages + 1
                },${Page});">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>`
  }
  document.getElementById('setPage').innerHTML =
    navPage + prev + li + next + `</ul>`
}

function setKasir () {
  $.ajax({
    url: linkUrl + '/C_Transaction/getNameKasirInManager',
    method: 'GET',
    dataType: 'JSON'
  }).done(result => {
    let selectDat = document.getElementById('kasir')
    let Opt = document.createElement('option')
    let Opt2 = document.createElement('option')
    Opt.value = ''
    Opt.disabled = 'true'
    Opt.selected = true
    Opt.innerHTML = 'Pilih Kasir...'
    selectDat.appendChild(Opt)
    Opt2.value = 'semua'
    Opt2.innerHTML = 'Semua Kasir'
    selectDat.appendChild(Opt2)

    for (let i = 0; i < result.length; i++) {
      let Opt = document.createElement('option')
      Opt.value = result[i]['Username']
      Opt.innerHTML = result[i]['Name']
      selectDat.appendChild(Opt)
    }
  })
}

function setCustomer () {
  $.ajax({
    url: linkUrl + '/C_Pelanggan/getData',
    method: 'GET',
    dataType: 'JSON'
  }).done(result => {
    let selectDat = document.getElementById('pelanggan')
    let Opt = document.createElement('option')
    let Opt2 = document.createElement('option')
    Opt.value = ''
    Opt.disabled = 'true'
    Opt.selected = true
    Opt.innerHTML = 'Pilih Pelanggan...'
    selectDat.appendChild(Opt)
    Opt2.value = 'semua'
    Opt2.innerHTML = 'Semua Pelanggan'
    selectDat.appendChild(Opt2)

    for (let i = 0; i < result.length; i++) {
      let Opt = document.createElement('option')
      Opt.value = result[i]['Id']
      Opt.innerHTML = result[i]['Name']
      selectDat.appendChild(Opt)
    }
  })
}

document.getElementById('cari').addEventListener('click', function () {
  let urutan = document.getElementById('urutan').value
  let kasir = document.getElementById('kasir').value
  let pelanggan = document.getElementById('pelanggan').value
  let status = document.getElementById('status').value
  let TanggalArray = document.getElementById('date').value.split(' to ')
  let OnlyTextTanggal = document.getElementById('date').value
  let sums = 0
  for (let i = 0; i < 3; i++) {
    if (i == 0 && kasir == '') {
      sums++
      document.getElementById('kasir').classList.add('is-invalid')
    }
    if (i == 1 && pelanggan == '') {
      sums++
      document.getElementById('pelanggan').classList.add('is-invalid')
    }
    // if (i == 2 && status == '') {
    //   sums++
    //   document.getElementById('status').classList.add('is-invalid')
    // }
    if (i == 2 && OnlyTextTanggal == '') {
      sums++
      document.getElementById('date').classList.add('is-invalid')
    }
  }
  if (sums > 0) {
    Swal.fire({
      title: 'Opps...',
      text: 'Harap Isi Terlebih Dahulu',
      icon: 'error'
    })
  } else {
    document.getElementById('reset').classList.remove('d-none')
    document.getElementById('kasir').classList.remove('is-invalid')
    document.getElementById('pelanggan').classList.remove('is-invalid')
    document.getElementById('status').classList.remove('is-invalid')
    document.getElementById('date').classList.remove('is-invalid')

    isFilter = 1
    let queryData = '1=1'
    if (pelanggan != '') {
      if (pelanggan != 'semua') {
        queryData += ` AND t_transaction_manual.IdCustomer = '${pelanggan}'`
      }
    }

    let sTanggalAcrivity = ''
    if (document.getElementById('date').value != '') {
      datFilter.lastEdit = document.getElementById('date').value
      if (TanggalArray.length == 1) {
        let endtDate = new Date(Date.parse(TanggalArray[0]))
        endtDate.setDate(endtDate.getDate() + 1)
        let endText =
          endtDate.getFullYear() +
          '-' +
          (endtDate.getMonth() + 1) +
          '-' +
          endtDate.getDate()

        sTanggalAcrivity =
          " activity_transaction.CreatedDate >= '" +
          TanggalArray[0] +
          "' AND activity_transaction.CreatedDate <= '" +
          endText +
          "'"

        // sTanggalAcrivity =
        //   " activity_transaction.CreatedDate = '" + TanggalArray[0] + "'"
        SetTanggal = TanggalArray[0]
      } else {
        let endtDate = new Date(Date.parse(TanggalArray[1]))
        endtDate.setDate(endtDate.getDate() + 1)
        let endText =
          endtDate.getFullYear() +
          '-' +
          (endtDate.getMonth() + 1) +
          '-' +
          endtDate.getDate()

        sTanggalAcrivity =
          " activity_transaction.CreatedDate >= '" +
          TanggalArray[0] +
          "' AND activity_transaction.CreatedDate <= '" +
          endText +
          "'"

        console.log(endText)
        // document.getElementById('texttanggal').innerHTML =
        //   TanggalArray[0] + ' to ' + TanggalArray[1]
        // SetTanggal = TanggalArray[0] + ' to ' + TanggalArray[1]
      }
    }
    let TempData = {
      query: queryData,
      sort: urutan,
      spanKasir: kasir,
      spanTanggal: sTanggalAcrivity,
      SearchStatus: 1
    }
    query = TempData
    // console.log(TempData)
    RequestData()
  }
})

document.getElementById('reset').addEventListener('click', function () {
  document.getElementById('urutan').value = 'asc'
  document.getElementById('kasir').value = ''
  document.getElementById('pelanggan').value = ''
  document.getElementById('status').value = ''
  document.getElementById('date').value = ''
  document.getElementById('reset').classList.add('d-none')
  isFilter = 0

  let TempData = {
    query: '1=1 ',
    sort: 'DESC',
    spanKasir: '',
    spanTanggal: '',
    SearchStatus: 0
  }
  query = TempData
  RequestData()
})

document.getElementById('ekpor').addEventListener('click', function () {
  if (query.SearchStatus == 1) {
    TGL = ''
    let TanggalArray = document.getElementById('date').value.split(' to ')
    if (TanggalArray.length == 1) {
      TGL = TanggalArray[0]
      SetTanggal = TanggalArray[0]
    } else {
      TGL = TanggalArray[0] + ' to ' + TanggalArray[1] + ''
    }

    window.location.href =
      linkUrl + `C_Transaction/ExportToExcel?Tanggal=${TGL}`
  } else {
    Swal.fire({
      title: 'Opps...',
      text: 'Harap Melakukan Filter Data Dahulu',
      icon: 'error'
    })
  }
})
