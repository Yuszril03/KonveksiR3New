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
  pageLength: 5,
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
  query: '1=1'
}
setData()
function setData () {
  table.clear().draw()
  $.ajax({
    url: linkUrl + 'C_Employee/getData',
    data: dataQuery,
    dataType: 'JSON',
    type: 'POST'
  }).done(result => {
    console.log(result)
    for (let i = 0; i < result.length; i++) {
      let status = `<span class="badge bg-danger">Tidak Aktif</span>`
      let button = `
      <button title="Aktifkan" data-id="${result[i].Id}" class="btn btn-success btn-sm m-1 aktif"><i class="bi bi-power"></i></button>
      <a title="Informasi Pelanggan" class="btn btn-info btn-sm m-1"><i class="bi bi-info-lg"></i></a>`
      let root = `<i class="bi bi-x-circle text-secondary"></i>`
      if (result[i].Root == 1) {
        button = `
      <a href="${
        linkUrl + 'Informasi-Karyawan/' + result[i].Slug
      }" class="btn btn-info btn-sm m-1" title="Informasi Karyawan"><i class="bi bi-info-lg"></i></a>`
      }
      let KaryawanSaya = ''
      let KaryawanSayaRoot = ''

      var options = {
        // weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      var today = new Date(result[i].ModifiedDate)
      // console.log(result[i])
      if (result[i].Level != '1') {
        KaryawanSaya = `<li><a class="dropdown-item d-none" href="#">Karyawan Saya</a></li>`
        KaryawanSayaRoot = `
      <a class="btn btn-secondary d-none btn-sm m-1" title="Karyawan Saya"><i class="bi bi-diagram-3"></i></a>`
      }

      if (result[i].Status == 1) {
        if (result[i].Root == 1) {
          root = `<i class="bi bi-check-circle text-success"></i>`
          button = `
      <a href="${
        linkUrl + 'Informasi-Karyawan/' + result[i].Slug
      }" class="btn btn-info btn-sm m-1" title="Informasi Karyawan"><i class="bi bi-info-lg"></i></a>
      ${KaryawanSayaRoot}`
        } else {
          button = `<a title="Edit Data" href="${
            linkUrl + 'Edit-Karyawan/' + result[i].Slug
          }" class="btn btn-warning btn-sm m-1"><i class="bi bi-pencil"></i></a>
      <button title="Non-Aktifkan" data-id="${
        result[i].Id
      }"class="btn btn-danger btn-sm m-1 nonaktif"><i class="bi bi-power"></i></button>
      <button  class="btn btn-secondary btn-sm m-1  " type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Informasi Karyawan"><i class="bi bi-grid-3x2-gap"></i></button>
      <div class="dropdown-center">
      <ul class="dropdown-menu shadow p-1 mb-5 bg-body-tertiary rounded">
    <li><button class=" btn dropdown-item resetSandi" data-id="${
      result[i].Id
    }" >Reset Kata Sandi</button></li>
    <li><a href="${
      linkUrl + 'Informasi-Karyawan/' + result[i].Slug
    }" class="dropdown-item" href="#">Informasi Karyawan</a></li>
    ${KaryawanSaya}
  </ul>
      </div>`
        }
        status = `<span class="badge bg-success">Aktif</span>`
      }

      table.row
        .add([
          result[i].Name,
          result[i].Username,
          result[i].NamePosition,
          result[i].NameRole,
          root,
          today.toLocaleDateString('id-ID', options) +
            ` ${today.getHours()}:${today.getMinutes()}`,
          status,
          button
        ])
        .draw()
    }
  })
}

$(document).on('click', '.nonaktif', function () {
  let id = $(this).data('id')
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menonaktifkan karyawan ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Non Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Employee/UpdateStatus/' + id + '/0',
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
    text: 'Mengaktifkan karyawan ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Employee/UpdateStatus/' + id + '/1',
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
  console.log(id)
  resetSandi.show()
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
      url: linkUrl + '/C_Employee/updatePassword',
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
          title: 'Session anda telah habis',
          showConfirmButton: false,
          timer: 1500
        }).then(result => {
          window.location.href = linkUrl
        })
      }
    })
  }
})

document.getElementById('terapkanData').addEventListener('click', function () {
  let Status = document.getElementById('status').value
  let TanggalArray = document.getElementById('date').value.split(' to ')
  let Role = document.getElementById('Role').value
  let Posisi = document.getElementById('Position').value
  let Root = document.getElementById('account').value
  let ParetntText = document.getElementById('parentTextFilter')
  let textFilter = document.getElementById('textFilter')

  if (
    Status == '2' &&
    document.getElementById('date').value == '' &&
    Role == '' &&
    Posisi == '' &&
    Root == 2
  ) {
    ParetntText.classList.add('d-none')
    dataQuery = {
      query: '1=1'
    }
    setData()
  } else {
    let queryData = '1=1 '
    let queryText = ''
    if (Posisi != '') {
      queryData += `AND IdPosition = ${Posisi} `
      queryText += `Posisi ${$('#Position option:selected').text()}, `
    }
    if (Role != '') {
      queryData += `AND IdRole = ${Role} `
      queryText += `Role ${$('#Role option:selected').text()}, `
    }
    if (Root != '2') {
      queryData += `AND Root = ${Root} `
      queryText += `Akun Root ${$('#account option:selected').text()}, `
    }
    if (Status != '2') {
      queryData += `AND M_Employee.Status = ${Status} `
      queryText += `Status ${$('#status option:selected').text()}, `
    }
    if (document.getElementById('date').value != '') {
      if (TanggalArray.length == 1) {
        queryData += `AND M_Employee.ModifiedDate >= ${TanggalArray[0]}`
        queryText += `Tanggal Edit ${TanggalArray[0]}`
      } else {
        queryData += `AND M_Employee.ModifiedDate >= ${TanggalArray[0]} AND M_Employee.ModifiedDate <= ${TanggalArray[1]}`
        queryText += `Tanggal Edit ${TanggalArray[0]} - ${TanggalArray[1]}`
      }
    }
    dataQuery = {
      query: queryData
    }
    // console.log(dataQuery)
    setData()
    textFilter.innerHTML = queryText
    ParetntText.classList.remove('d-none')
  }
})
getPosition()

function getPosition () {
  $.ajax({
    url: linkUrl + 'C_Employee/getPostionRoleAll',
    dataType: 'JSON'
  }).done(result => {
    let Role = result.Role
    let Posisi = result.Posisi

    //Role
    $('#Role')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Role...</option>')
      .val('')

    for (let i = 0; i < Role.length; i++) {
      let Roles = document.getElementById('Role')
      let option = document.createElement('option')
      option.text = Role[i].Name
      option.title = Role[i].Name
      option.value = Role[i].Id
      Roles.add(option)
    }

    //Position
    $('#Position')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Posisi...</option>')
      .val('')

    for (let i = 0; i < Posisi.length; i++) {
      let Positions = document.getElementById('Position')
      let option = document.createElement('option')
      option.text = Posisi[i].Name
      option.title = Posisi[i].Name
      option.value = Posisi[i].Id
      Positions.add(option)
    }
  })
}

document.getElementById('resetData').addEventListener('click', function () {
  let ParetntText = document.getElementById('parentTextFilter')
  ParetntText.classList.add('d-none')
  dataQuery = {
    query: '1=1'
  }
  setData()
})
