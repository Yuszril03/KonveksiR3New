let table = $('#table').DataTable({
  responsive: true,
  pageLength: 10,
  ordering: false,
  lengthChange: false,
  language: {
    searchPlaceholder: 'Pencarian',
    search: '',
    paginate: {
      next: 'Selanjutnya',
      previous: 'Sebelumnya'
    },
    info: 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
    lengthMenu: 'Tampilkan _MENU_ entri',
    infoEmpty: 'Menampilkan 0 hingga 0 of 0 entri',
    infoFiltered: '(disaring dari _MAX_ total entri)',
    zeroRecords: `<img style="width:150px; padding:20px" src="${linkUrl}Asset/Icon/serach-empty.svg"><p>Tidak ada data yang cocok ditemukan</p>`,
    emptyTable: `<img style="width:150px;" src="${linkUrl}Asset/Icon/empty-data.svg"><p>Tidak ada data di dalam tabel</p>`
  },
  dom: 'Bfrtip',
  buttons: {
    buttons: [
      {
        text: `<i class="bi bi-funnel"></i>Filter`,
        name: 'filter',
        className: 'btn-primary customb m-lg-0 m-1 btn-sm',
        action: function (e, dt, node, config) {}
      }
    ],
    dom: {
      button: {
        tag: 'button',
        className: 'btn'
      }
    }
  }
})
let tanggalFormat = $('.selector').flatpickr({
  mode: 'range',
  dateFormat: 'Y-m-d'
})

let query = {
  query: '1=1 ',
  sort: 'DESC',
  search: '',
  spanSort: 'Terbesar-Terkecil',
  spanStatus: '',
  spanTanggal: ''
}
let datFilter = {
  sort: 'DESC',
  kasir: '',
  status: '',
  lastEdit: ''
}
let filterData = new bootstrap.Modal(document.getElementById('filterData'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})

let Page = 1
let data = []

RequestData()
setDataKasir()

function setButtons (role) {
  if (role == 1) {
    table.buttons('semua:name').nodes().removeClass('btn-outline-primary')
    table.buttons('semua:name').nodes().addClass('btn-primary')
    // outline
    table.buttons('simpan:name').nodes().removeClass('btn-primary')
    table.buttons('simpan:name').nodes().addClass('btn-outline-primary')
    table.buttons('hutang:name').nodes().removeClass('btn-primary')
    table.buttons('hutang:name').nodes().addClass('btn-outline-primary')
    table.buttons('lunas:name').nodes().removeClass('btn-primary')
    table.buttons('lunas:name').nodes().addClass('btn-outline-primary')
  } else if (role == 2) {
    table.buttons('simpan:name').nodes().removeClass('btn-outline-primary')
    table.buttons('simpan:name').nodes().addClass('btn-primary')
    // outline
    table.buttons('semua:name').nodes().removeClass('btn-primary')
    table.buttons('semua:name').nodes().addClass('btn-outline-primary')
    table.buttons('hutang:name').nodes().removeClass('btn-primary')
    table.buttons('hutang:name').nodes().addClass('btn-outline-primary')
    table.buttons('lunas:name').nodes().removeClass('btn-primary')
    table.buttons('lunas:name').nodes().addClass('btn-outline-primary')
  } else if (role == 3) {
    table.buttons('hutang:name').nodes().removeClass('btn-outline-primary')
    table.buttons('hutang:name').nodes().addClass('btn-primary')
    // outline
    table.buttons('semua:name').nodes().removeClass('btn-primary')
    table.buttons('semua:name').nodes().addClass('btn-outline-primary')
    table.buttons('simpan:name').nodes().removeClass('btn-primary')
    table.buttons('simpan:name').nodes().addClass('btn-outline-primary')
    table.buttons('lunas:name').nodes().removeClass('btn-primary')
    table.buttons('lunas:name').nodes().addClass('btn-outline-primary')
  } else if (role == 4) {
    table.buttons('lunas:name').nodes().removeClass('btn-outline-primary')
    table.buttons('lunas:name').nodes().addClass('btn-primary')
    // outline
    table.buttons('semua:name').nodes().removeClass('btn-primary')
    table.buttons('semua:name').nodes().addClass('btn-outline-primary')
    table.buttons('simpan:name').nodes().removeClass('btn-primary')
    table.buttons('simpan:name').nodes().addClass('btn-outline-primary')
    table.buttons('hutang:name').nodes().removeClass('btn-primary')
    table.buttons('hutang:name').nodes().addClass('btn-outline-primary')
  }
}

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
  setTimeout(function () {
    setLoadingList(1)
    setData()
  }, 3000)
}

function setData () {
  $.ajax({
    url: linkUrl + 'C_Transaction/getHistoryTransManager',
    dataType: 'JSON',
    data: query,
    method: 'POST'
  }).done(result => {
    if (result.data.length == 0) {
      document.getElementById('emptydata').classList.remove('d-none')
    } else {
      document.getElementById('emptydata').classList.add('d-none')
    }
    data = result.data
    Page = result.jumlah
    // console.log(data)
    setList(1, Page)
    setSpans(
      result.isFilter,
      result.spanSort,
      result.spanStatus,
      result.spanTanggal,
      result.spanKasir
    )
  })
}
function setDataKasir () {
  $.ajax({
    url: linkUrl + '/C_Transaction/getNameKasirInManager',
    method: 'GET',
    dataType: 'JSON'
  }).done(result => {
    let selectDat = document.getElementById('kasir')
    let Opt = document.createElement('option')
    Opt.value = ''
    Opt.innerHTML = 'Pilih Semua Kasir...'
    selectDat.appendChild(Opt)

    for (let i = 0; i < result.length; i++) {
      let Opt = document.createElement('option')
      Opt.value = result[i]['Username']
      Opt.innerHTML = result[i]['Name']
      selectDat.appendChild(Opt)
    }
  })
}

function setList (pages, total) {
  let batas = 10
  // console.log(total)

  let initial = batas * (pages - 1)
  batas = batas * pages
  let count = 0
  let values = ''

  for (let i = initial; i < batas; i++) {
    if (data[i] != null) {
      var options = {
        // weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      var today = new Date(data[i]['CreatedDate'])

      let status = `<span class="badge text-bg-primary">Teruskan</span>`
      let button = `<button Title="Detail Transaksi" data-id="${data[i]['Number_Trans']}" class='btn btn-primary btn-sm mt-lg-3 mt-3 details'>
            <i class='bi bi-eye'></i>
          </button>
          `
      if (data[i]['StatusTransakksi'] == 1) {
        status = `<span class="badge text-bg-secondary">Draft</span>`
        button = `<button Title="Detail Transaksi" data-id="${data[i]['Number_Trans']}" class='btn btn-primary btn-sm mt-lg-3 mt-3 details'>
            <i class='bi bi-eye'></i>
          </button>`
      } else if (data[i]['StatusTransakksi'] == 2) {
        status = `<span class="badge text-bg-info">Simpan</span>`
        button = `<button data-id="${data[i]['Number_Trans']}" Title="Edit Transaksi" class='btn btn-warning btn-sm mt-lg-3 mt-3 edits'>
            <i class='bi bi-pen'></i>
          </button>
          <button Title="Detail Transaksi" data-id="${data[i]['Number_Trans']}" class='btn btn-primary btn-sm mt-lg-3 mt-3 details'>
            <i class='bi bi-eye'></i>
          </button>
           <a Title="Cetak Nota" href="${linkUrl}/Nota-Transaksi/${data[i]['Number_Trans']}" target="_blank" class='btn btn-secondary btn-sm mt-lg-3 mt-3'>
            <i class='bi bi-receipt'></i>
          </a>`
      } else if (data[i]['StatusTransakksi'] == 3) {
        status = `<span class="badge text-bg-danger">Batal</span>`
        button = `<button Title="Detail Transaksi" data-id="${data[i]['Number_Trans']}" class='btn btn-primary btn-sm mt-lg-3 mt-3 details'>
            <i class='bi bi-eye'></i>
          </button>`
      } else if (data[i]['StatusTransakksi'] == 4) {
        status = `<span class="badge text-bg-success">Lunas</span>`
        button = `<button Title="Detail Transaksi" data-id="${data[i]['Number_Trans']}" class='btn btn-primary btn-sm mt-lg-3 mt-3 details'>
            <i class='bi bi-eye'></i>
          </button>
          <a Title="Cetak Nota" href="${linkUrl}/Nota-Transaksi/${data[i]['Number_Trans']}" target="_blank" class='btn btn-secondary btn-sm mt-lg-3 mt-3'>
            <i class='bi bi-receipt'></i>
          </a>`
      } else if (data[i]['StatusTransakksi'] == 5) {
        status = `<span class="badge text-bg-warning">Hutang</span>`
        button = `<button Title="Detail Transaksi" data-id="${data[i]['Number_Trans']}" class='btn btn-primary btn-sm mt-lg-3 mt-3 details'>
            <i class='bi bi-eye'></i>
          </button>
          <a Title="Cetak Nota" href="${linkUrl}/Nota-Transaksi/${data[i]['Number_Trans']}" target="_blank" class='btn btn-secondary btn-sm mt-lg-3 mt-3'>
            <i class='bi bi-receipt'></i>
          </a>`
      }

      values += `
      <div class="mt-3 mb-3">
      <div class="name-Kasir">
      <p class="title-name-kasir"><span class="text-white">Kasir : </span> <span class="text-white fw-bold" >${
        data[i]['NamaKasir']
      }</span></p>
      </div>
      <div class='shadow  bg-body-tertiary container-list'>
      <div class='row'>
        <div class='col-lg-2 col-12'>
          <p class='text-muted'>Tgl. Transaksi</p>
          <p class='fw-bold list-values'>${today.toLocaleDateString(
            'id-ID',
            options
          )}  ${today.getHours()}:${today.getMinutes()}</p>
        </div>
        <div class='col-lg-3 col-12'>
          <p class='text-muted'>No.Transaksi</p>
          <p class='fw-bold list-values'>${data[i]['Number_Trans']}</p>
        </div>
        <div class='col-lg-2 col-6'>
          <p class='text-muted'>Pelanggan</p>
          <p class='fw-bold list-values'>${data[i]['NamaCustomer']}</p>
        </div>
        <div class='col-lg-2 col-6'>
          <p class='text-muted'>Total</p>
          <p class='fw-bold list-values'>Rp. ${formatRupiah(
            data[i]['Total_Payment']
          )}</p>
        </div>
        <div class='col-lg-1 col-6'>
          <p class='text-muted'>Status</p>
          <p class='fw-bold list-values'>${status}</p>
        </div>
        <div class='col-lg-2 col-6 text-center'>
          ${button}
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

document.getElementById('btnfilter').addEventListener('click', function () {
  filterData.show()
})
document.getElementById('reset').addEventListener('click', function () {
  document.getElementById('status').value = ''
  document.getElementById('date').value = ''
  document.getElementById('asc').checked = false
  document.getElementById('desc').checked = true
  document.getElementById('textsort').innerHTML = 'Terbesar-Terkecil'
  document.getElementById('textstatus').classList.add('d-none')
  document.getElementById('texttanggal').classList.add('d-none')
  document.getElementById('textkasir').classList.add('d-none')
  TempData = {
    query: '1=1',
    sort: 'DESC',
    search: query.search,
    spanSort: 'Terbesar-Terkecil',
    spanStatus: '',
    spanTanggal: ''
  }
  datFilter = {
    sort: 'DESC',
    kasir: '',
    status: '',
    lastEdit: ''
  }

  query = TempData
  RequestData()
})

document.getElementById('textSearch').addEventListener('keyup', function () {
  let TempData = {
    query: query.query,
    sort: query.sort,
    search:
      "AND (t_transaction_manual.Number_Trans LIKE '%" +
      this.value +
      "%' OR m_customer.Name LIKE '%" +
      this.value +
      "%')"
  }
  // console.log(TempData)
  if (this.value != '') {
    query = TempData
  } else {
    TempData = {
      query: query.query,
      sort: query.sort,
      search: ``,
      spanSort: query.spanSort,
      spanStatus: query.spanStatus,
      spanTanggal: query.spanTanggal
    }
    query = TempData
  }
  RequestData()
})
function setSpans (isFilter, spanSort, spanStatus, spanTanggal, spanKasir) {
  if (isFilter == 0) {
    document.getElementById('textsort').innerHTML = spanSort
    if (spanSort == 'Terbesar-Terkecil') {
      document.getElementById('desc').checked = true
      document.getElementById('asc').checked = false
    } else {
      document.getElementById('asc').checked = true
      document.getElementById('desc').checked = false
    }
    if (spanKasir != '') {
      document.getElementById('textkasir').innerHTML = spanKasir
      document.getElementById('textkasir').classList.remove('d-none')
    }
    if (spanStatus != '') {
      document.getElementById('textstatus').innerHTML = spanStatus
      document.getElementById('textstatus').classList.remove('d-none')
      if (spanStatus == 'Draf') {
        document.getElementById('status').value = 1
      } else if (spanStatus == 'Tersimpan') {
        document.getElementById('status').value = 2
      } else if (spanStatus == 'Batal') {
        document.getElementById('status').value = 3
      } else if (spanStatus == 'Lunas') {
        document.getElementById('status').value = 4
      } else if (spanStatus == 'Hutang') {
        document.getElementById('status').value = 5
      } else if (spanStatus == 'Diteruskan') {
        document.getElementById('status').value = 6
      }
    }
    if (spanTanggal != '') {
      tanggalFormat[0].setDate(spanTanggal)
      document.getElementById('date').value = spanTanggal
      document.getElementById('texttanggal').innerHTML = spanTanggal
      document.getElementById('texttanggal').classList.remove('d-none')
    }
  }
}
document.getElementById('terapkan').addEventListener('click', function () {
  let sortdata = $('input[name="inlineRadioOptions"]:checked').val()
  let kasir = document.getElementById('kasir').value
  let status = document.getElementById('status').value
  let TanggalArray = document.getElementById('date').value.split(' to ')
  let onlyTanggalText = document.getElementById('date').value
  if (status == '' && onlyTanggalText == '' && kasir == '') {
    let setsort = 'Terbesar-Terkecil'
    if (sortdata == 'asc') {
      datFilter.sort = 'ASC'
      sort = 'Terkecil-Terbesar'
      document.getElementById('textsort').innerHTML = 'Terkecil-Terbesar'
    } else {
      datFilter.sort = 'DESC'
      document.getElementById('textsort').innerHTML = 'Terbesar-Terkecil'
    }
    document.getElementById('textstatus').classList.add('d-none')
    document.getElementById('textkasir').classList.add('d-none')
    document.getElementById('texttanggal').classList.add('d-none')

    let TempData = {
      query: '1=1',
      sort: sortdata,
      search: query.search,
      spanSort: setsort,
      spanStatus: query.spanStatus,
      spanTanggal: query.spanTanggal,
      spanKasir: query.spanKasir
    }
    query = TempData

    // console.log(query)
    RequestData()
  } else {
    let SetStatus = ''
    let SetKasir = ''
    let SetTanggal = ''
    let queryData = '1=1'
    if (status != '') {
      datFilter.status = status
      queryData += ` AND t_transaction_manual.Status = ${status} `
      if (status == 1) {
        document.getElementById('textstatus').innerHTML = 'Draft'
        SetStatus = 'Draft'
      } else if (status == 2) {
        document.getElementById('textstatus').innerHTML = 'Tersimpan'
        SetStatus = 'Tersimpan'
      } else if (status == 3) {
        document.getElementById('textstatus').innerHTML = 'Batal'
        SetStatus = 'Batal'
      } else if (status == 4) {
        document.getElementById('textstatus').innerHTML = 'Lunas'
        SetStatus = 'Lunas'
      } else if (status == 5) {
        document.getElementById('textstatus').innerHTML = 'Hutang'
        SetStatus = 'Hutang'
      } else if (status == 6) {
        document.getElementById('textstatus').innerHTML = 'Diteruskan'
        SetStatus = 'Diteruskan'
      }
      document.getElementById('textstatus').classList.remove('d-none')
    } else {
      document.getElementById('textstatus').classList.add('d-none')
    }
    if (document.getElementById('kasir').value != '') {
      queryData += ` AND t_transaction_manual.Operator = '${kasir}' `
      document.getElementById('textkasir').classList.remove('d-none')
      let IdxKasir = document.getElementById('kasir')
      let textKasir = IdxKasir.options[IdxKasir.selectedIndex].text

      document.getElementById('textkasir').innerHTML = textKasir
      SetKasir = textKasir
    } else {
      SetKasir = ''
      document.getElementById('textkasir').classList.add('d-none')
    }
    let setsort = 'Terbesar-Terkecil'
    if (sortdata == 'asc') {
      datFilter.sort = 'ASC'
      document.getElementById('textsort').innerHTML = 'Terkecil-Terbesar'
      setsort = 'Terkecil-Terbesar'
    } else {
      datFilter.sort = 'DESC'
      document.getElementById('textsort').innerHTML = 'Terbesar-Terkecil'
    }

    if (document.getElementById('date').value != '') {
      datFilter.lastEdit = document.getElementById('date').value
      if (TanggalArray.length == 1) {
        queryData +=
          " AND t_transaction_manual.CreatedDate = '" + TanggalArray[0] + "'"
        document.getElementById('texttanggal').innerHTML = TanggalArray[0]
        SetTanggal = TanggalArray[0]
        // queryText += `Tanggal Edit ${TanggalArray[0]}`
      } else {
        queryData +=
          " AND t_transaction_manual.CreatedDate >= '" +
          TanggalArray[0] +
          "' AND t_transaction_manual.CreatedDate <= '" +
          TanggalArray[1] +
          "'"
        // queryText += `Tanggal Edit ${TanggalArray[0]} - ${TanggalArray[1]}`
        document.getElementById('texttanggal').innerHTML =
          TanggalArray[0] + ' to ' + TanggalArray[1]
        SetTanggal = TanggalArray[0] + ' to ' + TanggalArray[1]
      }
      document.getElementById('texttanggal').classList.remove('d-none')
    }
    // console.log(queryData)
    let TempData = {
      query: queryData,
      sort: sortdata,
      search: query.search,
      spanSort: setsort,
      spanStatus: SetStatus,
      spanTanggal: SetTanggal,
      spanKasir: SetKasir
    }
    query = TempData
    // console.log(queryData)
    RequestData()
  }
  filterData.hide()
})
document
  .getElementById('closeModalFilter')
  .addEventListener('click', function () {
    //SORT
    if (datFilter.sort == 'ASC') {
      document.getElementById('asc').checked = true
      document.getElementById('desc').checked = false
    } else {
      document.getElementById('asc').checked = false
      document.getElementById('desc').checked = true
    }
    document.getElementById('status').value = datFilter.status
    document.getElementById('date').value = datFilter.lastEdit
    tanggalFormat[0].setDate(datFilter.lastEdit)
  })

$(document).on('click', '.details', function () {
  let id = $(this).data('id')
  window.location.href = linkUrl + 'Detail-Transaksi/' + id
})
$(document).on('click', '.edits', function () {
  let id = $(this).data('id')
  window.location.href = linkUrl + 'Edit-Transaksi/' + id
})
