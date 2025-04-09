let modalAdd = new bootstrap.Modal(document.getElementById('addData'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let formAddUser = new bootstrap.Modal(document.getElementById('formAddUser'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})

let formdata = 1
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
        text: `<i class="bi bi-plus"></i> Tambah Data`,
        className: 'btn-success m-lg-0 m-2 btn-sm',
        action: function (e, dt, node, config) {
          modalAdd.show()
          formdata = 1
          document.getElementById('labelAdd').innerHTML = 'Tambah Data'
          document.getElementById('Name').classList.remove('is-invalid')
          document.getElementById('Potong').classList.remove('is-invalid')
          document.getElementById('Lusin').classList.remove('is-invalid')
          document.getElementById('Kodi').classList.remove('is-invalid')

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

let addMember = $('#addMember').DataTable({
  responsive: true,
  pageLength: 10,
  lengthChange: false,
  searching: false,
  info: false,
  ordering: false,
  language: {
    searchPlaceholder: 'Pencarian',
    search: '',
    paginate: {
      next: `<i class="bi bi-arrow-right"></i>`,
      previous: `<i class="bi bi-arrow-left"></i>`
    },
    info: 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
    lengthMenu: 'Tampilkan _MENU_ entri',
    infoEmpty: 'Menampilkan 0 hingga 0 of 0 entri',
    infoFiltered: '(disaring dari _MAX_ total entri)',
    zeroRecords: `<img style="width:150px; padding:20px" src="${linkUrl}Asset/Icon/serach-empty.svg"><p>Tidak ada data yang cocok ditemukan</p>`,
    emptyTable: `<img style="width:150px;" src="${linkUrl}Asset/Icon/empty-data.svg"><p>Tidak ada data di dalam tabel</p>`
  }
})
let listMember = $('#listMember').DataTable({
  responsive: true,
  pageLength: 10,
  lengthChange: false,
  searching: false,
  info: false,
  ordering: false,
  language: {
    searchPlaceholder: 'Pencarian',
    search: '',
    paginate: {
      next: `<i class="bi bi-arrow-right"></i>`,
      previous: `<i class="bi bi-arrow-left"></i>`
    },
    info: 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
    lengthMenu: 'Tampilkan _MENU_ entri',
    infoEmpty: 'Menampilkan 0 hingga 0 of 0 entri',
    infoFiltered: '(disaring dari _MAX_ total entri)',
    zeroRecords: `<img style="width:150px; padding:20px" src="${linkUrl}Asset/Icon/serach-empty.svg"><p>Tidak ada data yang cocok ditemukan</p>`,
    emptyTable: `<img style="width:150px;" src="${linkUrl}Asset/Icon/empty-data.svg"><p>Tidak ada data di dalam tabel</p>`
  }
})

setDataTable()
setDataProduct()
function setDataProduct () {
  let url = window.location.href
  let arrayUrl = url.split('/')
  // console.log(arrayUrl[6])
  let dataQuery = {
    query: `CodeQr = '${arrayUrl[6]}'`
  }

  $.ajax({
    url: linkUrl + '/C_Product/getDataOne',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    // console.log(result)
    document.getElementById('NameProduct').innerHTML = result.Name
    document.getElementById('sizeProduk').innerHTML = result.Size
    document.getElementById('type').innerHTML = result.Jenis
    document.getElementById('bahan').innerHTML = result.Bahan
    document.getElementById('stok').innerHTML =
      result.Stock + ' / ' + result.singkatan
    if (result.singkatan == 'Potong') {
      document.getElementById('potong').innerHTML =
        formatRupiah(result.Stock) + ' ' + result.singkatan
    } else {
      let hitung = result.Stock_Piece / result.piecetype + ''
      let array = hitung.split('.')
      if (array.length == 1) {
        document.getElementById('stok').innerHTML =
          formatRupiah(result.Stock) + ' ' + result.singkatan
      } else {
        let getOne = array[0]
        let getTow = array[0] * result.piecetype
        let ressult2 = getTow - result.Stock_Piece
        document.getElementById('stok').innerHTML =
          formatRupiah(getOne) +
          ' ' +
          result.singkatan +
          ' ' +
          formatRupiah(ressult2 + '') +
          ' Potong'
      }
    }

    // document.getElementById('limit').innerHTML =
    //   result.Limit + ' ' + result.singkatanlimit
    document.getElementById('potong').innerHTML =
      'Rp. ' + formatRupiah(result.Per_Piece)
    document.getElementById('lusin').innerHTML =
      'Rp. ' + formatRupiah('' + result.Per_Doze + '')
    document.getElementById('kodi').innerHTML =
      'Rp. ' + formatRupiah('' + result.Per_Kodi + '')

    if (result.Image != null) {
      document.getElementById('imagep').src = linkUrl + '' + result.Image
    } else {
      document.getElementById('imagep').src =
        linkUrl + '/Asset/Icon/empty-image-produk.svg'
    }
  })
}
// console.log(1)

function setDataTable () {
  $.ajax({
    url: linkUrl + 'C_Product/getCustomPrice',
    dataType: 'JSON'
  }).done(result => {
    table.clear().draw()
    for (let i = 0; i < result.length; i++) {
      let aksi = `<button title="Aktifkan Data" class="btn btn-success btn-sm aktif" data-id="${result[i].Id}"><i class="bi bi-power"></i></button>`
      let status = `<span  class="badge bg-danger">Tidak Aktif</span>`

      if (result[i].Status == 1) {
        status = `<span  class="badge bg-success">Aktif</span>`

        aksi = `<button title="Edit Data" class="btn btn-warning m-1 btn-sm edit" data-id="${result[i].Id}"><i class="bi bi-pen"></i></button>
        <button title="Non-Aktifkan" class="btn btn-danger btn-sm m-1 nonaktif" data-id="${result[i].Id}"><i class="bi bi-power"></i></button>
        <button title="Tambah Anggota" class="btn btn-success m-1 btn-sm Add" data-id="${result[i].Id}"><i class="bi bi-person-add"></i></button>`
      }
      table.row
        .add([
          result[i].Name,
          'Rp. ' + formatRupiah(result[i].Per_Piece),
          'Rp. ' + formatRupiah(result[i].Per_Dozen),
          'Rp. ' + formatRupiah(result[i].Per_Kodi),
          status,
          aksi
        ])
        .draw()
    }
  })
}

$(document).on('click', '.nonaktif', function () {
  let id = $(this).data('id')
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menonaktifkan custom harga ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Non Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Product/UpdateStatusCustomPrice/' + id + '/0',
        dataType: 'JSON'
      }).done(hasil => {
        if (hasil == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setDataTable()
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Data tidak tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setDataTable()
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
    text: 'Mengaktifkan custom ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Aktifkan',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + '/C_Product/UpdateStatusCustomPrice/' + id + '/1',
        dataType: 'JSON'
      }).done(hasil => {
        if (hasil == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setDataTable()
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Data tidak tersimpan',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            setDataTable()
          })
        }
      })
    }
  })
})

$(document).on('click', '.edit', function () {
  let id = $(this).data('id')
  document.getElementById('tempIdCustom').value = id
  document.getElementById('labelAdd').innerHTML = 'Edit Data'
  document.getElementById('Name').classList.remove('is-invalid')
  document.getElementById('Potong').classList.remove('is-invalid')
  document.getElementById('Lusin').classList.remove('is-invalid')
  document.getElementById('Kodi').classList.remove('is-invalid')

  setDataCustomFrom(id)
})
$(document).on('click', '.Add', function () {
  let id = $(this).data('id')
  setDataListMember(id)
  document.getElementById('tempIdCustomprice').value = id
  addMember.clear().draw()
  document.getElementById('serachData').value = ''
  // document.getElementById('tempIdCustom').value = id
  document.getElementById('modalLabelUser').innerHTML = 'Form Anggota'
  formAddUser.show()
})
document.getElementById('Back1').addEventListener('click', function () {
  Swal.fire({
    title: 'Apakah Anda Yakin?',
    text: 'Keluar dari halaman ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya!',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      window.location.href = linkUrl + '/Produk'
    }
  })
})

function setDataCustomFrom (id) {
  $.ajax({
    url: linkUrl + 'C_Product/getOneCustomPrice/' + id,
    dataType: 'JSON'
  }).done(result => {
    document.getElementById('Name').value = result.Name
    document.getElementById('tempName').value = result.Name
    document.getElementById('Potong').value = formatRupiah(
      result.Per_Piece + ''
    )
    document.getElementById('Lusin').value = formatRupiah(result.Per_Dozen + '')
    document.getElementById('Kodi').value = formatRupiah(result.Per_Kodi + '')
    formdata = 0
    modalAdd.show()
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

function isNumberKey (angka, evt) {
  // var charCode = evt.which ? evt.which : evt.keyCode
  // if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  //   return false
  // } else {
  angka.value = formatRupiah(angka.value)
  //   return true
  // }
}

document.getElementById('CancelData').addEventListener('click', function () {
  if (formdata == 0) {
    Swal.fire({
      title: 'Apakah Anda Yakin',
      text: 'Tidak menyimpan data ini!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Iya',
      cancelButtonText: 'Iya'
    }).then(result => {
      if (result.isConfirmed) {
        modalAdd.hide()
      }
    })
  } else {
    document.getElementById('Name').value = ''
    document.getElementById('Potong').value = ''
    document.getElementById('Lusin').value = ''
    document.getElementById('Kodi').value = ''

    modalAdd.hide()
  }
})

document.getElementById('SaveData').addEventListener('click', function () {
  let data = {}
  let link = linkUrl + 'C_Product/AddCustomPrice'
  if (formdata == 1) {
    data = {
      Name: document.getElementById('Name').value,
      Potong: document.getElementById('Potong').value.replaceAll('.', ''),
      Lusin: document.getElementById('Lusin').value.replaceAll('.', ''),
      Kodi: document.getElementById('Kodi').value.replaceAll('.', '')
    }
  } else {
    link = linkUrl + 'C_Product/UpdateCustomPrice'
    let isName = 0
    if (
      document.getElementById('tempName').value !=
      document.getElementById('Name').value
    ) {
      isName = 1
    }
    data = {
      Name: document.getElementById('Name').value,
      IsName: isName,
      Id: document.getElementById('tempIdCustom').value,
      Potong: document.getElementById('Potong').value.replaceAll('.', ''),
      Lusin: document.getElementById('Lusin').value.replaceAll('.', ''),
      Kodi: document.getElementById('Kodi').value.replaceAll('.', '')
    }
  }

  $.ajax({
    url: link,
    data: data,
    dataType: 'JSON',
    method: 'POST'
  }).done(result => {
    let kondisi = result.kondisi
    let error = result.error
    if (kondisi == 0) {
      if (error.Name != null) {
        document.getElementById('Name').classList.add('is-invalid')
        document.getElementById('nameHelp').innerHTML = error.Name
      } else {
        document.getElementById('Name').classList.remove('is-invalid')
      }
      if (error.Potong != null) {
        document.getElementById('Potong').classList.add('is-invalid')
        document.getElementById('potongHelp').innerHTML = error.Potong
      } else {
        document.getElementById('Potong').classList.remove('is-invalid')
      }
      if (error.Lusin != null) {
        document.getElementById('Lusin').classList.add('is-invalid')
        document.getElementById('lusinHelp').innerHTML = error.Lusin
      } else {
        document.getElementById('Lusin').classList.remove('is-invalid')
      }
      if (error.Kodi != null) {
        document.getElementById('Kodi').classList.add('is-invalid')
        document.getElementById('kodiHelp').innerHTML = error.Kodi
      } else {
        document.getElementById('Kodi').classList.remove('is-invalid')
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
        document.getElementById('Name').value = ''
        document.getElementById('Potong').value = ''
        document.getElementById('Lusin').value = ''
        document.getElementById('Kodi').value = ''
        setDataTable()
        modalAdd.hide()
      })
    }
  })
})

function setDataListMember (id) {
  $.ajax({
    url: linkUrl + 'C_Product/getDataMemberPrice/' + id,
    dataType: 'JSON'
  }).done(result => {
    listMember.clear().draw()
    for (let i = 0; i < result.length; i++) {
      let text = `<div class=" shadow-sm bg-body-tertiary rounded d-flex">
      <div class="p-2 w-100">${result[i].Name}</div>
      <div class="  p-1 flex-shrink-1"><button data-id="${result[i].Id}" class="btn deleteMember"><i class="bi bi-x-circle text-danger"></i></button></div>
  </div>`
      listMember.row.add([text]).draw()
    }
  })
}

document.getElementById('serachData').addEventListener('keyup', function () {
  let idProdCus = document.getElementById('tempIdCustomprice').value
  let data = {
    query1: this.value,
    idProdCus: idProdCus
  }
  if (this.value == '') {
    addMember.clear().draw()
  } else {
    $.ajax({
      url: linkUrl + 'C_Product/getDataAddMemberPrice',
      data: data,
      dataType: 'JSON',
      method: 'POST'
    }).done(result => {
      // console.log(result)
      addMember.clear().draw()
      for (let i = 0; i < result.length; i++) {
        let text = `<div class=" shadow-sm bg-body-tertiary rounded d-flex">
      <div class="p-2 w-100">${result[i].Name}</div>
      <div class="  p-1 flex-shrink-1"><button data-id="${result[i].Id}" class="btn addMembers"><i class="bi bi-plus-circle text-success"></i></button></div>
  </div>`
        addMember.row.add([text]).draw()
      }
    })
  }
})

$(document).on('click', '.addMembers', function () {
  let id = $(this).data('id')
  let data = {
    IdCus: id,
    IdPricepRo: document.getElementById('tempIdCustomprice').value
  }
  $.ajax({
    url: linkUrl + 'C_Product/AddMemberPrice',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(kondisi => {
    if (kondisi == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      })
    } else if (kondisi == 2) {
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
        document.getElementById('serachData').value = ''
        addMember.clear().draw()
        // modalAdd.hide()
        setDataListMember(document.getElementById('tempIdCustomprice').value)
      })
    }
  })
})

$(document).on('click', '.deleteMember', function () {
  let id = $(this).data('id')
  let data = {
    Id: id
  }
  Swal.fire({
    title: 'Apakah Anda Yakin',
    text: 'Menghapus Pelanggan ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya',
    cancelButtonText: 'Batal'
  }).then(result1 => {
    if (result1.isConfirmed) {
      $.ajax({
        url: linkUrl + 'C_Product/DeleteMemberPrice',
        data: data,
        method: 'POST',
        dataType: 'JSON'
      }).done(kondisi => {
        if (kondisi == 0) {
          Swal.fire({
            icon: 'error',
            title: 'Data tidak terhapus',
            showConfirmButton: false,
            timer: 1500
          })
        } else if (kondisi == 2) {
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
            title: 'Data berhasil terhapus',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            document.getElementById('serachData').value = ''
            addMember.clear().draw()
            // modalAdd.hide()
            setDataListMember(
              document.getElementById('tempIdCustomprice').value
            )
          })
        }
      })
    }
  })
})
