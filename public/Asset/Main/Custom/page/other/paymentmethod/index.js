let filter = new bootstrap.Modal(document.getElementById('exampleModal'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let formModal = new bootstrap.Modal(document.getElementById('formModal'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let dataQuery = {
  query: '1=1'
}
let saveID = ''
let isFilter = 0
let isEdit = 0
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
          if (isFilter == 0) {
            setBankFilter()
          }
          //trigger the bootstrap modal
          // $('#exampleModal').show
        }
      },
      {
        text: `<i class="bi bi-plus"></i> Tambah Data`,
        className: 'btn-success m-lg-0 m-2 btn-sm',
        action: function (e, dt, node, config) {
          formModal.show()
          isEdit = 0
          resetFrom()
          getDataBank(0, '')
          document.getElementById('modalLabelForm').innerHTML = 'Tambah Data'
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

setData()
function setData () {
  table.clear().draw()
  $.ajax({
    url: linkUrl + '/C_PaymentMethod/getData',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    for (let i = 0; i < result.length; i++) {
      let Status = `<span class="badge bg-danger">Tidak Aktif</span>`
      let Button = `
      <button title="Aktifkan" data-id="${result[i].Id}" class="btn btn-success btn-sm m-1 aktif"><i class="bi bi-power"></i></button>`
      if (result[i].Status == 1) {
        Status = `<span class="badge bg-success">Aktif</span>`
        Button = `<button title="Edit Data" data-id="${result[i].Id}"class="btn btn-warning btn-sm m-1 editData"><i class="bi bi-pencil"></i></button>
      <button title="Non-Aktifkan" data-id="${result[i].Id}"class="btn btn-danger btn-sm m-1 nonaktif"><i class="bi bi-power"></i></button>
     `
      }
      var options = {
        // weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      var today = new Date(result[i].ModifiedDate)

      table.row
        .add([
          result[i].Name,
          result[i].Bank,
          result[i].Number_Account,
          today.toLocaleDateString('id-ID', options) +
            ` ${today.getHours()}:${today.getMinutes()}`,
          Status,
          Button
        ])
        .draw()
    }
  })
}

function setBankFilter () {
  $.ajax({
    url: linkUrl + 'C_PaymentMethod/getTypeBankFilter',
    method: 'GET',
    dataType: 'JSON'
  }).done(result => {
    $('#bankFilter')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Bank...</option>')
    for (let i = 0; i < result.length; i++) {
      let bank = document.getElementById('bankFilter')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      bank.add(option)
    }
  })
}

function getDataBank (Id, Name) {
  let DataBank = {
    query: `Status = 1`
  }
  $.ajax({
    url: linkUrl + '/C_PaymentMethod/getDataBank',
    data: DataBank,
    dataType: 'JSON'
  }).done(result => {
    $('#bank')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Bank...</option>')

    if (Id == 0) {
      for (let i = 0; i < result.length; i++) {
        let bank = document.getElementById('bank')
        let option = document.createElement('option')
        option.text = result[i].Name
        option.title = result[i].Name
        option.value = result[i].Id
        bank.add(option)
      }
    } else {
      let isTrue = 0
      for (let i = 0; i < result.length; i++) {
        let bank = document.getElementById('bank')
        let option = document.createElement('option')
        option.text = result[i].Name
        option.title = result[i].Name
        option.value = result[i].Id
        bank.add(option)
        if (Id == result[i].Id) {
          $('#bank').val(result[i].Id)
          isTrue = 1
        }
      }
      if (isTrue == 0) {
        let bank = document.getElementById('bank')
        let option = document.createElement('option')
        option.text = Name
        option.title = Name
        option.value = Id
        $('#bank').val(Id)
      }
    }
  })
}

document.getElementById('cancelData').addEventListener('click', function () {
  if (isEdit == 1) {
    Swal.fire({
      title: 'Apakah anda yakin',
      text: 'Tidak menyimpan bahan produk ini!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Iya!',
      cancelButtonText: 'Batal'
    }).then(result => {
      if (result.isConfirmed) {
        formModal.hide()
      }
    })
  } else {
    formModal.hide()
  }
})

document.getElementById('saveData').addEventListener('click', function () {
  let url = linkUrl + 'SaveDataMethodPayment'
  let Data = {
    Name: document.getElementById('Name').value,
    Bank: document.getElementById('bank').value,
    Rekening: document.getElementById('Rek').value
  }
  if (isEdit == 1) {
    let IsTrue = 0
    if (
      document.getElementById('tempBank').value ==
        document.getElementById('bank').value &&
      document.getElementById('tempRek').value ==
        document.getElementById('Rek').value
    ) {
      IsTrue = 1
    }
    Data = {
      Name: document.getElementById('Name').value,
      Bank: document.getElementById('bank').value,
      Rekening: document.getElementById('Rek').value,
      Id: saveID,
      IsTrue: IsTrue
    }
    url = linkUrl + 'EditDataMethodPayment'
  }

  $.ajax({
    url: url,
    data: Data,
    type: 'POST',
    dataType: 'JSON'
  }).done(result => {
    let kondisi = result.kondisi
    let error = result.error
    // console.log(result)
    if (kondisi == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(hasil => {
        formModal.hide()
        setData()
      })
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
      }).then(hasil => {
        window.location.href = linkUrl
      })
    } else {
      if (error.Name != null) {
        document.getElementById('nameHelp').innerHTML = error.Name
        document.getElementById('Name').classList.add('is-invalid')
      } else {
        document.getElementById('Name').classList.remove('is-invalid')
      }

      if (error.Bank != null) {
        document.getElementById('bankHelp').innerHTML = error.Bank
        document.getElementById('bank').classList.add('is-invalid')
      } else {
        document.getElementById('bank').classList.remove('is-invalid')
      }

      if (error.Rekening != null) {
        document.getElementById('RekHelp').innerHTML = error.Rekening
        document.getElementById('Rek').classList.add('is-invalid')
      } else {
        document.getElementById('Rek').classList.remove('is-invalid')
      }
    }
  })
})

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
      separator = sisa ? '' : ''
      rupiah += separator + ribuan.join('')
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah
    return prefix == undefined ? rupiah : rupiah ? rupiah : ''
  }
}

function isNumberKey (angka, evt) {
  // var charCode = evt.which ? evt.which : evt.keyCode
  // if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  //   return false
  // } else {
  angka.value = formatRupiah(angka.value)
  //   return true
  // }
}

function resetFrom () {
  document.getElementById('Name').value = ''
  document.getElementById('Rek').value = ''
  getDataBank(0, '')
}

$(document).on('click', '.nonaktif', function () {
  let id = $(this).data('id')
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menonaktifkan metode bayar ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Non Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_PaymentMethod/UpdateStatus/' + id + '/0',
        dataType: 'JSON'
      }).done(hasil => {
        if (hasil == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setData()
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
$(document).on('click', '.aktif', function () {
  let id = $(this).data('id')
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Mengaktifkan metode bayar ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_PaymentMethod/UpdateStatus/' + id + '/1',
        dataType: 'JSON'
      }).done(hasil => {
        if (hasil == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setData()
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

$(document).on('click', '.editData', function () {
  let id = $(this).data('id')
  saveID = id
  formModal.show()
  isEdit = 1
  document.getElementById('modalLabelForm').innerHTML = 'Edit Data'
  let data = {
    query: `m_payment_method.Id=${id}`
  }
  $.ajax({
    url: linkUrl + '/C_PaymentMethod/getData',
    data: data,
    dataType: 'JSON'
  }).done(result => {
    getDataBank(result[0].Id_Bank, result[0].Bank)
    document.getElementById('Name').value = result[0].Name
    document.getElementById('tempName').value = result[0].Name
    // document.getElementById('bank').value = result[0].Id_Bank
    document.getElementById('tempBank').value = result[0].Id_Bank
    document.getElementById('Rek').value = result[0].Number_Account
    document.getElementById('tempRek').value = result[0].Number_Account
  })
})

document.getElementById('resetData').addEventListener('click', function () {
  document.getElementById('status').value = '2'
  document.getElementById('date').value = ''
  let ParetntText = document.getElementById('parentTextFilter')
  ParetntText.classList.add('d-none')
  dataQuery = {
    query: ''
  }
  isFilter = 0
  setData()
})

document.getElementById('terapkanData').addEventListener('click', function () {
  let Status = document.getElementById('status').value
  let Bank = document.getElementById('bankFilter').value
  let TanggalArray = document.getElementById('date').value.split(' to ')
  let ParetntText = document.getElementById('parentTextFilter')
  let textFilter = document.getElementById('textFilter')

  if (
    document.getElementById('date').value == '' &&
    Status == '2' &&
    Bank == ''
  ) {
    ParetntText.classList.add('d-none')
    dataQuery = {
      query: ''
    }
    isFilter = 0
    setData()
  } else {
    isFilter = 1
    let queryData = '1=1 '
    let queryText = ''
    if (Bank != '') {
      queryData += `AND m_payment_method.Id_Bank = ${Bank} `
      queryText += `Jenis ${$('#bankFilter option:selected').text()}, `
    }

    if (Status != '2') {
      queryData += `AND m_payment_method.Status = ${Status} `
      queryText += `Status ${$('#status option:selected').text()}, `
    }

    if (document.getElementById('date').value != '') {
      if (TanggalArray.length == 1) {
        queryData += `AND m_payment_method.ModifiedDate >= ${TanggalArray[0]}`
        queryText += `Tanggal Edit ${TanggalArray[0]}`
      } else {
        queryData += `AND m_payment_method.ModifiedDate >= ${TanggalArray[0]} AND m_payment_method.ModifiedDate <= ${TanggalArray[1]}`
        queryText += `Tanggal Edit ${TanggalArray[0]} - ${TanggalArray[1]}`
      }
    }
    dataQuery = {
      query: queryData
    }
    setData()
    textFilter.innerHTML = queryText
    ParetntText.classList.remove('d-none')
  }
})
