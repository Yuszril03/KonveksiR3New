let addstok = new bootstrap.Modal(document.getElementById('addstok'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let filter = new bootstrap.Modal(document.getElementById('exampleModal'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
$('.selector').flatpickr({
  mode: 'range',
  dateFormat: 'Y-m-d'
})
let statusFilter = 0
let table = $('#table').DataTable({
  responsive: true,
  pageLength: 10,
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
        text: `<i class="bi bi-funnel"></i> Filter`,
        className: 'btn-secondary m-lg-0 m-2 btn-sm',
        action: function (e, dt, node, config) {
          filter.show()
          if (statusFilter == 0) {
            setDataFilter()
            document.getElementById('stokStatus').value = ''
            document.getElementById('status').value = ''
            document.getElementById('date').value = ''
          }
          //trigger the bootstrap modal
          // $('#exampleModal').show
        }
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
let dataQuery = {
  query: ''
}
setData('')

function setDataFilter () {
  //Bahan
  let dataQuery = {
    query: 'Status=1'
  }
  $.ajax({
    url: linkUrl + '/C_Product/getDataMaterialProduct',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    $('#bahan')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Bahan...</option>')
      .val('')
    for (let i = 0; i < result.length; i++) {
      let material = document.getElementById('bahan')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      material.add(option)
    }
  })

  //Jenis
  let dataQuery2 = {
    query: 'Status=1'
  }
  $.ajax({
    url: linkUrl + '/C_Product/getDataTypeProduct',
    data: dataQuery2,
    dataType: 'JSON'
  }).done(result => {
    $('#jenis')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Jenis...</option>')
      .val('')
    for (let i = 0; i < result.length; i++) {
      let type = document.getElementById('jenis')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      type.add(option)
    }
  })
}

function setData (stokStatus) {
  // let stokStatus = document.getElementById('stokStatus').value
  $.ajax({
    url: linkUrl + '/C_Product/getData',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    table.clear().draw()
    for (let i = 0; i < result.length; i++) {
      let statusstos = 0
      let Stok = `<span class="badge bg-danger">Habis</span>`
      let Status = `<span class="badge bg-danger">Tidak Aktif</span>`
      let Aksi = `<button  class="btn btn-info btn-sm m-1 "><i class="bi bi-info-circle"></i></button>
      <button data-id="${result[i].Id}" title="Mengaktifkan Data" class="btn btn-success aktif btn-sm m-1"><i class="bi bi-power"></i></button>`
      if (result[i].StatusProduk == 1) {
        Status = `<span class="badge bg-success">Aktif</span>`
        Aksi = `<a title="Edit Data"  href="${
          linkUrl + 'Edit-Produk/' + result[i].CodeQr
        }" class="btn btn-warning btn-sm m-1"><i class="bi bi-pen"></i></a>
      <button data-id="${
        result[i].Id
      }" title="Menonaktifkan Data" class="btn btn-danger nonaktif btn-sm m-1"><i class="bi bi-power"></i></button> 
     <div class="dropdown">
  <div class="dropdown">
  <button class="btn btn-secondary btn-sm m-1" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-grid-3x2-gap"></i>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a href="${linkUrl}Kustom-Harga-Produk/${
          result[i].CodeQr
        }" class=" btn dropdown-item " >Custom Harga</a></li>
    <li><button class="dropdown-item addstoks" data-id="${
      result[i].Id
    }">Tambah Stok</button></li>
    <li><a class="dropdown-item" href="${linkUrl}Informasi-Produk/${
          result[i].CodeQr
        }">Informasi Produk</a></li>
  </ul>
</div>
     `
      }

      if (parseFloat(result[i].Stock) > parseFloat(result[i].Limit)) {
        statusstos = 1
        Stok = `<span class="badge bg-success">Tersedia</span>`
      } else if (
        parseFloat(result[i].Stock) <= parseFloat(result[i].Limit) &&
        parseFloat(result[i].Stock) > 0
      ) {
        statusstos = 2
        Stok = `<span class="badge bg-warning">Hampir Habis</span>`
      } else if (parseFloat(result[i].Stock) <= 0) {
        statusstos = 3
        Stok = `<span class="badge bg-danger">Habis</span>`
      }
      var options = {
        // weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      var today = new Date(result[i].terakhiredit)
      if ('1' == stokStatus && statusstos == 1) {
        table.row
          .add([
            result[i].Name,
            result[i].Size,
            result[i].Jenis,
            result[i].Bahan,
            Stok,
            today.toLocaleDateString('id-ID', options) +
              ` ${today.getHours()}:${today.getMinutes()}`,
            Status,
            Aksi
          ])
          .draw()
      } else if ('2' == stokStatus && statusstos == 2) {
        table.row
          .add([
            result[i].Name,
            result[i].Size,
            result[i].Jenis,
            result[i].Bahan,
            Stok,
            today.toLocaleDateString('id-ID', options) +
              ` ${today.getHours()}:${today.getMinutes()}`,
            Status,
            Aksi
          ])
          .draw()
      } else if ('3' == stokStatus && statusstos == 3) {
        table.row
          .add([
            result[i].Name,
            result[i].Size,
            result[i].Jenis,
            result[i].Bahan,
            Stok,
            today.toLocaleDateString('id-ID', options) +
              ` ${today.getHours()}:${today.getMinutes()}`,
            Status,
            Aksi
          ])
          .draw()
      } else if ('' == stokStatus) {
        table.row
          .add([
            result[i].Name,
            result[i].Size,
            result[i].Jenis,
            result[i].Bahan,
            Stok,
            today.toLocaleDateString('id-ID', options) +
              ` ${today.getHours()}:${today.getMinutes()}`,
            Status,
            Aksi
          ])
          .draw()
      }
    }
  })
}

document.getElementById('resetData').addEventListener('click', function () {
  setDataFilter()
  document.getElementById('stokStatus').value = ''
  document.getElementById('status').value = ''
  document.getElementById('date').value = ''
  statusFilter = 0
  setData('')
  document.getElementById('parentTextFilter').classList.add('d-none')
})

document.getElementById('terapkanData').addEventListener('click', function () {
  let jenis = document.getElementById('jenis').value
  let bahan = document.getElementById('bahan').value
  let stokStatus = document.getElementById('stokStatus').value
  let status = document.getElementById('status').value
  let TanggalArray = document.getElementById('date').value.split(' to ')
  let ParetntText = document.getElementById('parentTextFilter')
  let textFilter = document.getElementById('textFilter')
  if (
    document.getElementById('date').value == '' &&
    status == '' &&
    jenis == '' &&
    bahan == '' &&
    stokStatus == ''
  ) {
    ParetntText.classList.add('d-none')
    dataQuery = {
      query: ''
    }
    statusFilter = 0
    setData('')
  } else {
    let queryData = '1=1 '
    let queryText = ''
    if (status != '') {
      queryData += `AND m_product.Status = ${status} `
      queryText += `Status ${$('#status option:selected').text()}, `
    }
    if (jenis != '') {
      queryData += `AND m_product.Id_Type_Product = ${jenis} `
      queryText += `Jenis ${$('#jenis option:selected').text()}, `
    }
    if (bahan != '') {
      queryData += `AND m_product.Id_Material_Product = ${bahan} `
      queryText += `Bahan ${$('#bahan option:selected').text()}, `
    }
    if (stokStatus != '') {
      // queryData += `AND m_product.Id_Material_Product = ${bahan} `
      queryText += `Stok ${$('#stokStatus option:selected').text()}, `
    }
    if (document.getElementById('date').value != '') {
      if (TanggalArray.length == 1) {
        queryData += `AND m_product.ModifiedDate >= ${TanggalArray[0]}`
        queryText += `Tanggal Edit ${TanggalArray[0]}`
      } else {
        queryData += `AND m_product.ModifiedDate >= ${TanggalArray[0]} AND m_product.ModifiedDate <= ${TanggalArray[1]}`
        queryText += `Tanggal Edit ${TanggalArray[0]} - ${TanggalArray[1]}`
      }
    }
    dataQuery = {
      query: queryData
    }
    statusFilter = 1
    setData(stokStatus)
    textFilter.innerHTML = queryText
    ParetntText.classList.remove('d-none')
  }
})

$(document).on('click', '.nonaktif', function () {
  let id = $(this).data('id')
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menonaktifkan produk ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Non Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Product/UpdateStatus/' + id + '/0',
        dataType: 'JSON'
      }).done(hasil => {
        if (hasil == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setData(document.getElementById('stokStatus').value)
          })
        } else if (hasil == 0) {
          Swal.fire({
            icon: 'error',
            title: 'Data tidak tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setData('')
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Session anda habis',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            window.location.href = linkUrl
          })
        }
      })
    }
  })
})
$(document).on('click', '.addstoks', function () {
  let id = $(this).data('id')
  document.getElementById('tempIDM').value = id
  addstok.show()
  getTypeItem()
  let dataQuery = {
    query: `m_product.Id = ${id}`
  }

  $.ajax({
    url: linkUrl + '/C_Product/getDataOne',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    console.log(result)
    document.getElementById('judulM').innerHTML =
      result.Name + ' - ' + result.Size
    document.getElementById('typeM').innerHTML = result.Jenis
    document.getElementById('bahanM').innerHTML = result.Bahan
    // console.log(result.Stock_Piece)
    if (result.singkatan == 'Potong') {
      document.getElementById('stokM').innerHTML =
        formatRupiah(result.Stock) + ' ' + result.singkatan
    } else {
      let hitung = result.Stock_Piece / result.piecetype + ''
      let array = hitung.split('.')
      if (array.length == 1) {
        document.getElementById('stokM').innerHTML =
          formatRupiah(result.Stock) + ' ' + result.singkatan
      } else {
        let getOne = array[0]
        let getTow = array[0] * result.piecetype
        let ressult2 = getTow - result.Stock_Piece
        document.getElementById('stokM').innerHTML =
          formatRupiah(getOne) +
          ' ' +
          result.singkatan +
          ' ' +
          formatRupiah(ressult2 + '') +
          ' Potong'
      }
    }

    document.getElementById('limitM').innerHTML =
      formatRupiah(result.Limit) + ' ' + result.singkatan
    if (result.Image != null) {
      document.getElementById('imagep').src = linkUrl + '' + result.Image
    }
    if (parseFloat(result.Stock) > parseFloat(result.Limit)) {
      Stok = `<span class="badge bg-success">Tersedia</span>`
    } else if (
      parseFloat(result.Stock) <= parseFloat(result.Limit) &&
      parseFloat(result.Stock) > 0
    ) {
      Stok = `<span class="badge bg-warning">Hampir Habis</span>`
    } else if (parseFloat(result.Stock) <= 0) {
      Stok = `<span class="badge bg-danger">Habis</span>`
    }
    document.getElementById('statusM').innerHTML = Stok
  })
})

document.getElementById('cancelData').addEventListener('click', function () {
  addstok.hide()
  document.getElementById('StokFrom').value = ''
})

document.getElementById('saveData').addEventListener('click', function () {
  let data = {
    Id: document.getElementById('tempIDM').value,
    Stok: document.getElementById('StokFrom').value,
    typeStok: document.getElementById('typeStokFrom').value
  }
  $.ajax({
    url: linkUrl + 'C_Product/addStok',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(result2 => {
    let kondisi = result2.kondisi
    let error = result2.error
    if (kondisi == 0) {
      if (error.typeStok != null) {
        if (error.Stok != null) {
          document.getElementById('StokFrom').classList.add('is-invalid')
          document.getElementById('typeStokFrom').classList.add('is-invalid')
          document.getElementById('StokFromHelp').innerHTML =
            'Stok dan jenis stok harus diisi'
        } else {
          document.getElementById('typeStokFrom').classList.add('is-invalid')
          document.getElementById('StokFromHelp').innerHTML = error.typeStok
          document.getElementById('StokFrom').classList.remove('is-invalid')
        }
      } else {
        document.getElementById('typeStokFrom').classList.remove('is-invalid')
        if (error.Stok != null) {
          document.getElementById('Stok').classList.add('is-invalid')
          document.getElementById('StokFromHelp').innerHTML = error.Stok
        } else {
          document.getElementById('StokFrom').classList.remove('is-invalid')
        }
      }
    } else if (kondisi == 2) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      })
    } else if (kondisi == 3) {
      Swal.fire({
        icon: 'error',
        title: 'Session anda telah habis',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        window.location.href = linkUrl
      })
    } else {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        addstok.hide()
        setData(document.getElementById('stokStatus').value)
        document.getElementById('StokFrom').value = ''
      })
    }
  })
})

function getTypeItem () {
  $.ajax({
    url: linkUrl + 'C_Product/getTypeItem',
    dataType: 'JSON',
    type: 'JSON'
  }).done(result => {
    $('#typeStokFrom')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Satuan...</option>')

    for (let i = 0; i < result.length; i++) {
      let typeStok = document.getElementById('typeStokFrom')
      let option = document.createElement('option')
      option.text = '/ ' + result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      typeStok.add(option)
    }
  })
}

$(document).on('click', '.aktif', function () {
  let id = $(this).data('id')
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Mengaktifkan produk ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Product/UpdateStatus/' + id + '/1',
        dataType: 'JSON'
      }).done(hasil => {
        if (hasil == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setData(document.getElementById('stokStatus').value)
          })
        } else if (hasil == 0) {
          Swal.fire({
            icon: 'error',
            title: 'Data tidak tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setData()
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Session anda habis',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            window.location.href = linkUrl
          })
        }
      })
    }
  })
})
function isNumberKey (angka, evt) {
  // var charCode = evt.which ? evt.which : evt.keyCode
  // if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  //   return false
  // } else {
  angka.value = formatRupiah(angka.value)
  //   return true
  // }
}

function formatRupiah (angka) {
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
