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

document.getElementById('cancelData').addEventListener('click', function () {
  if (isEdit == 1) {
    Swal.fire({
      title: 'Apakah anda yakin',
      text: 'Tidak menyimpan jenis produk ini!',
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
  let url = linkUrl + 'SaveDataTypeProduct'
  let Data = {
    Name: document.getElementById('Name').value,
    Description: document.getElementById('des').value
  }
  if (isEdit == 1) {
    let isNAme = 1
    if (
      document.getElementById('tempName').value ==
      document.getElementById('Name').value
    ) {
      isNAme = 0
    }
    Data = {
      Name: document.getElementById('Name').value,
      Description: document.getElementById('des').value,
      Id: saveID,
      IsName: isNAme
    }
    url = linkUrl + 'UpdateDataTypeProduct'
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
    }
  })
})
setData()
function setData () {
  table.clear().draw()
  $.ajax({
    url: linkUrl + '/C_Product/getDataTypeProduct',
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
          result[i].Description,
          today.toLocaleDateString('id-ID', options) +
            ` ${today.getHours()}:${today.getMinutes()}`,
          Status,
          Button
        ])
        .draw()
    }
  })
}

$(document).on('click', '.nonaktif', function () {
  let id = $(this).data('id')
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menonaktifkan jenis produk ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Non Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Product/UpdateStatusTypeProduct/' + id + '/0',
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
    text: 'Mengaktifkan jenis produk ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Product/UpdateStatusTypeProduct/' + id + '/1',
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
    query: `Id=${id}`
  }
  $.ajax({
    url: linkUrl + '/C_Product/getDataTypeProduct',
    data: data,
    dataType: 'JSON'
  }).done(result => {
    document.getElementById('Name').value = result[0].Name
    document.getElementById('tempName').value = result[0].Name
    document.getElementById('des').value = result[0].Description
  })
})

function resetFrom () {
  document.getElementById('Name').value = ''
  document.getElementById('des').value = ''
}

document.getElementById('resetData').addEventListener('click', function () {
  let ParetntText = document.getElementById('parentTextFilter')
  ParetntText.classList.add('d-none')
  dataQuery = {
    query: ''
  }
  setData()
})

document.getElementById('terapkanData').addEventListener('click', function () {
  let Status = document.getElementById('status').value
  let TanggalArray = document.getElementById('date').value.split(' to ')
  let ParetntText = document.getElementById('parentTextFilter')
  let textFilter = document.getElementById('textFilter')

  if (document.getElementById('date').value == '' && Status == '2') {
    ParetntText.classList.add('d-none')
    dataQuery = {
      query: ''
    }
    setData()
  } else {
    let queryData = '1=1 '
    let queryText = ''
    if (Status != '2') {
      queryData += `AND Status = ${Status} `
      queryText += `Status ${$('#status option:selected').text()}, `
    }
    if (document.getElementById('date').value != '') {
      if (TanggalArray.length == 1) {
        queryData += `AND ModifiedDate >= ${TanggalArray[0]}`
        queryText += `Tanggal Edit ${TanggalArray[0]}`
      } else {
        queryData += `AND ModifiedDate >= ${TanggalArray[0]} AND ModifiedDate <= ${TanggalArray[1]}`
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
