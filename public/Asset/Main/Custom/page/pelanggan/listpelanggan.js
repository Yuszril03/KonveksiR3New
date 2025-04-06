let filter = new bootstrap.Modal(document.getElementById('exampleModal'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let resetSandi = new bootstrap.Modal(document.getElementById('resetSandi'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let SaveID = ''
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

$('.selector').flatpickr({
  mode: 'range',
  dateFormat: 'Y-m-d'
})

let dataQuery = {
  query: ''
}
setData()
function setData () {
  table.clear().draw()
  $.ajax({
    url: linkUrl + '/C_Pelanggan/getData',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    for (let i = 0; i < result.length; i++) {
      let Status = `<span class="badge bg-danger">Tidak Aktif</span>`
      let Button = `
      <button title="Aktifkan" data-id="${result[i].Id}" class="btn btn-success btn-sm m-1 aktif"><i class="bi bi-power"></i></button>
      <a title="Informasi Pelanggan" class="btn btn-info btn-sm m-1"><i class="bi bi-info-lg"></i></a>`
      if (result[i].Status == 1) {
        Status = `<span class="badge bg-success">Aktif</span>`
        Button = `<a title="Edit Data" href="${
          linkUrl + '/Edit-Pelanggan/' + result[i].Slug
        }" class="btn btn-warning btn-sm m-1"><i class="bi bi-pencil"></i></a>
      <button title="Non-Aktifkan" data-id="${
        result[i].Id
      }"class="btn btn-danger btn-sm m-1 nonaktif"><i class="bi bi-power"></i></button>
      <button data-id="${
        result[i].Id
      }"class="btn btn-light d-none btn-sm m-1 resetSandi" title="Reset Kata Sandi"><i class="bi bi-lock"></i></button>
      <a href="${
        linkUrl + 'Informasi-Pelanggan/' + result[i].Slug
      }" class="btn btn-info btn-sm m-1" title="Informasi Pelanggan"><i class="bi bi-info-lg"></i></a>`
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
          result[i].Telephone,
          result[i].Address,
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
    text: 'Menonaktifkan pelanggan ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Non Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Pelanggan/UpdateStatus/' + id + '/0',
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
    text: 'Mengaktifkan pelanggan ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Pelanggan/UpdateStatus/' + id + '/1',
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

$(document).on('click', '.resetSandi', function () {
  let id = $(this).data('id')
  SaveID = id
  resetSandi.show()
})
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

document.getElementById('simpanSandi').addEventListener('click', function () {
  let ArrayData = ['Pass', 'PassConf']
  let Data = {
    Id: SaveID,
    Pass: ''
  }
  let jumlah = 0

  for (let i = 0; i < ArrayData.length; i++) {
    if (i == 0) {
      if (document.getElementById(ArrayData[i]).value == '') {
        document.getElementById(ArrayData[i]).classList.add('is-invalid')
        document.getElementById(ArrayData[i] + 'Help').innerHTML =
          'Kolom Harus Diisi'
        jumlah++
      } else if (document.getElementById(ArrayData[i]).value.length < 8) {
        document.getElementById(ArrayData[i]).classList.add('is-invalid')
        document.getElementById(ArrayData[i] + 'Help').innerHTML =
          'Kata Sandi Kurang Dari 8 Karakter'
        jumlah++
      } else {
        document.getElementById(ArrayData[i]).classList.remove('is-invalid')
        Data = {
          Id: SaveID,
          Pass: document.getElementById(ArrayData[i]).value
        }
      }
    } else if (i == 1) {
      if (document.getElementById(ArrayData[i]).value == '') {
        document.getElementById(ArrayData[i]).classList.add('is-invalid')
        document.getElementById(ArrayData[i] + 'Help').innerHTML =
          'Kolom Harus Diisi'
        jumlah++
      } else if (document.getElementById(ArrayData[i]).value.length < 8) {
        document.getElementById(ArrayData[i]).classList.add('is-invalid')
        document.getElementById(ArrayData[i] + 'Help').innerHTML =
          'Kata Sandi Kurang Dari 8 Karakter'
        jumlah++
      } else {
        document.getElementById(ArrayData[i]).classList.remove('is-invalid')
      }
    }
  }

  if (jumlah == 0) {
    $.ajax({
      url: linkUrl + '/C_Pelanggan/updatePassword',
      data: Data,
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
          resetSandi.hide()
        })
      } else if (hasil == 0) {
        Swal.fire({
          icon: 'error',
          title: 'Data tidak tersimpan',
          showConfirmButton: false,
          timer: 1500
        }).then(result => {
          setData()
          resetSandi.hide()
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
