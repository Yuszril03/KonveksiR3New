$('#btnCancelImage').hide()
$('#AddImage').hide()
$('.image-title').hide()
$('#NoneImage').show()
let contenProduct = 1
let contenPriceCustom = 1
let isAddCustom = 1
// let customPrice = new bootstrap.Modal(document.getElementById('customPrice'), {
//   keyboard: false,
//   backdrop: 'static',
//   focus: true
// })
let date = new Date()
let idTempCustom = '' + date.getTime() + ''
// console.log(idTempCustom)
getTypeProduct()
getMaterialProduct()
getTypeItem()
// console.log(1)
// window.location.reload(false)
function readURL (input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader()
    let arrSplit = input.files[0].type.split('/')
    // console.log(arrSplit)
    if (arrSplit[0] == 'image') {
      reader.onload = function (e) {
        $('.image-upload-wrap').hide()

        $('.file-upload-image').attr('src', e.target.result)
        $('.file-upload-content').show()

        $('.image-title').html(input.files[0].name)

        $('#AddImage').show()
        $('#NoneImage').hide()

        document.getElementById('AddImage').src = e.target.result
      }

      $('#btnCancelImage').show()
      $('.image-title').show()
      reader.readAsDataURL(input.files[0])
    } else {
      removeUpload()
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Upload file hanya gambar!'
      })
    }
  } else {
    removeUpload()
  }
}

function removeUpload () {
  document.getElementById('uploadFilee').value = ''
  // document.getElementById('tempfoto').value = ''
  $('#btnCancelImage').hide()
  $('#AddImage').hide()
  $('#NoneImage').show()
  $('.image-title').hide()
  $('.file-upload-input').replaceWith($('.file-upload-input').clone())

  $('.file-upload-content').hide()
  $('.image-upload-wrap').show()
}
$('.image-upload-wrap').bind('dragover', function () {
  $('.image-upload-wrap').addClass('image-dropping')
})
$('.image-upload-wrap').bind('dragleave', function () {
  $('.image-upload-wrap').removeClass('image-dropping')
})

// let table = $('#tableHarga').DataTable({
//   responsive: true,
//   pageLength: 10,
//   lengthChange: false,
//   searching: false,
//   language: {
//     searchPlaceholder: 'Pencarian',
//     search: '',
//     paginate: {
//       next: `<i class="bi bi-arrow-right"></i>`,
//       previous: `<i class="bi bi-arrow-left"></i>`
//     },
//     info: 'Menampilkan _START_ hingga _END_ dari _TOTAL_ entri',
//     lengthMenu: 'Tampilkan _MENU_ entri',
//     infoEmpty: 'Menampilkan 0 hingga 0 of 0 entri',
//     infoFiltered: '(disaring dari _MAX_ total entri)',
//     zeroRecords: `<img style="width:150px; padding:20px" src="${linkUrl}Asset/Icon/serach-empty.svg"><p>Tidak ada data yang cocok ditemukan</p>`,
//     emptyTable: `<img style="width:150px;" src="${linkUrl}Asset/Icon/empty-data.svg"><p>Tidak ada data di dalam tabel</p>`
//   },
//   dom: 'Bfrtip',
//   buttons: {
//     buttons: [
//       {
//         text: `<i class="bi bi-plus"></i> Tambah`,
//         className: 'btn-success m-lg-0 m-2 btn-sm',
//         action: function (e, dt, node, config) {
//           customPrice.show()
//           document.getElementById('labelCustomPrice').innerHTML = 'Tambah Data'
//           isAddCustom = 1
//           //trigger the bootstrap modal
//           // $('#exampleModal').show
//         }
//       }
//     ],
//     dom: {
//       button: {
//         tag: 'button',
//         className: 'btn'
//       }
//     }
//   }
// })

// document.getElementById('cancelCustom').addEventListener('click', function () {
//   if (isAddCustom == 1) {
//     customPrice.hide()
//   }
// })
// document.getElementById('saveCustom').addEventListener('click', function () {
//   let data = {
//     Name: document.getElementById('NameTypePrice').value,
//     Potong: document.getElementById('CustomPotong').value.replaceAll('.', ''),
//     Lusin: document.getElementById('CustomLusin').value.replaceAll('.', ''),
//     Kodi: document.getElementById('CustomKodi').value.replaceAll('.', '')
//   }
// })

// document.getElementById('btnProduct').addEventListener('click', function () {
//   let iconPeronal = document.getElementById('iconProduct')
//   if (contenProduct == 1) {
//     $('#contenProduct').hide(800)
//     contenProduct = 0
//     iconPeronal.classList.remove('bi-chevron-up')
//     iconPeronal.classList.add('bi-chevron-down')
//   } else {
//     contenProduct = 1
//     $('#contenProduct').show(800)
//     iconPeronal.classList.remove('bi-chevron-down')
//     iconPeronal.classList.add('bi-chevron-up')
//   }
// })

// document
//   .getElementById('btnPriceCustom')
//   .addEventListener('click', function () {
//     let iconPekerjaan = document.getElementById('iconPriceCustom')

//     if (contenPriceCustom == 1) {
//       $('#contenPriceCustom').hide(800)
//       contenPriceCustom = 0
//       iconPekerjaan.classList.remove('bi-chevron-up')
//       iconPekerjaan.classList.add('bi-chevron-down')
//     } else {
//       contenPriceCustom = 1
//       $('#contenPriceCustom').show(800)
//       iconPekerjaan.classList.remove('bi-chevron-down')
//       iconPekerjaan.classList.add('bi-chevron-up')
//     }
//   })
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

function getMaterialProduct () {
  let dataQuery = {
    query: 'Status=1'
  }
  $.ajax({
    url: linkUrl + '/C_Product/getDataMaterialProduct',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    $('#material')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Bahan...</option>')
      .val('')
    for (let i = 0; i < result.length; i++) {
      let material = document.getElementById('material')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      material.add(option)
    }
  })
}

function getTypeItem () {
  $.ajax({
    url: linkUrl + 'C_Product/getTypeItem',
    dataType: 'JSON',
    type: 'JSON'
  }).done(result => {
    $('#typeLimit').find('option').remove().end()
    // .append('<option value="">Satuan</option>')
    // .val('')
    $('#typeStok').find('option').remove().end()
    // .append('<option value="">Pilih Satuan...</option>')
    // .val('')
    for (let i = 0; i < result.length; i++) {
      let typeStok = document.getElementById('typeStok')
      let typeLimit = document.getElementById('typeLimit')
      let option = document.createElement('option')
      let option2 = document.createElement('option')
      if (result[i].Name == 'Potong') {
        option.text = '/ ' + result[i].Name
        option.title = result[i].Name
        option.value = result[i].Id

        option2.text = '/ ' + result[i].Name
        option2.title = result[i].Name
        option2.value = result[i].Id

        typeLimit.add(option2)
        typeStok.add(option)
        $('#typeStok').val(result[i].Id)
        $('#typeLimit').val(result[i].Id)
      }
    }
  })
}

document.getElementById('typeStok').addEventListener('change', function () {
  $('#typeLimit').val(this.value)
})

function getTypeProduct () {
  let dataQuery = {
    query: 'Status=1'
  }
  $.ajax({
    url: linkUrl + '/C_Product/getDataTypeProduct',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    $('#type')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Jenis...</option>')
      .val('')
    for (let i = 0; i < result.length; i++) {
      let type = document.getElementById('type')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      type.add(option)
    }
  })
}

document.getElementById('cancelData').addEventListener('click', function () {
  Swal.fire({
    title: 'Apakah Anda Yakin?',
    text: 'Tidak Menyimpan Data!',
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

document.getElementById('saveData').addEventListener('click', function () {
  let slug =
    document.getElementById('Name').value.replaceAll(' ', '-') +
    '-' +
    document.getElementById('Size').value.replaceAll(' ', '-')
  let formData = new FormData()
  formData.append('Name', document.getElementById('Name').value)
  formData.append('Size', document.getElementById('Size').value)
  formData.append('Type', document.getElementById('type').value)
  formData.append('Material', document.getElementById('material').value)
  formData.append(
    'Modal',
    document.getElementById('ModalP').value.replaceAll('.', '')
  )
  formData.append(
    'Potong',
    document.getElementById('Potong').value.replaceAll('.', '')
  )
  formData.append(
    'Lusin',
    document.getElementById('Lusin').value.replaceAll('.', '')
  )
  formData.append(
    'Kodi',
    document.getElementById('Kodi').value.replaceAll('.', '')
  )
  formData.append(
    'Stok',
    document.getElementById('Stok').value.replaceAll('.', '')
  )
  formData.append(
    'Limit',
    document.getElementById('Limit').value.replaceAll('.', '')
  )
  formData.append('typeStok', document.getElementById('typeStok').value)
  formData.append('typeLimit', document.getElementById('typeLimit').value)
  if (document.getElementById('uploadFilee').files[0] == undefined) {
    formData.append('IsFoto', 0)
    formData.append('Foto', document.getElementById('uploadFilee').files[0])
  } else {
    formData.append('IsFoto', 1)
    formData.append('Foto', document.getElementById('uploadFilee').files[0])
  }
  // formData.append('Foto', document.getElementById('uploadFilee').files[0])
  formData.append('Slug', slug.toLowerCase())

  // console.log(formData)
  $.ajax({
    url: linkUrl + 'saveProduct',
    method: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    dataType: 'JSON'
  }).done(result => {
    let kondisi = result.kondisi
    let error = result.error
    // console.log(error)
    if (kondisi == 0) {
      if (error.Slug != null) {
        document.getElementById('nameHelp').innerHTML = error.Slug
        document.getElementById('Name').classList.add('is-invalid')
        document.getElementById('sizeHelp').innerHTML = error.Slug
        document.getElementById('Size').classList.add('is-invalid')
      } else {
        document.getElementById('Size').classList.remove('is-invalid')
        document.getElementById('Name').classList.remove('is-invalid')
        if (error.Name != null) {
          document.getElementById('Name').classList.add('is-invalid')
          document.getElementById('nameHelp').innerHTML = error.Name
        } else {
          document.getElementById('Name').classList.remove('is-invalid')
        }

        if (error.Size != null) {
          document.getElementById('Size').classList.add('is-invalid')
          document.getElementById('sizeHelp').innerHTML = error.Size
        } else {
          document.getElementById('Size').classList.remove('is-invalid')
        }
      }

      if (error.Type != null) {
        document.getElementById('type').classList.add('is-invalid')
        document.getElementById('typeHelp').innerHTML = error.Type
      } else {
        document.getElementById('type').classList.remove('is-invalid')
      }

      if (error.Material != null) {
        document.getElementById('material').classList.add('is-invalid')
        document.getElementById('materialHelp').innerHTML = error.Material
      } else {
        document.getElementById('material').classList.remove('is-invalid')
      }

      if (error.Material != null) {
        document.getElementById('material').classList.add('is-invalid')
        document.getElementById('materialHelp').innerHTML = error.Material
      } else {
        document.getElementById('material').classList.remove('is-invalid')
      }
      if (error.Modal != null) {
        document.getElementById('ModalP').classList.add('is-invalid')
        document.getElementById('modalHelp').innerHTML = error.Modal
      } else {
        document.getElementById('ModalP').classList.remove('is-invalid')
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
      if (error.Foto != null) {
        document.getElementById('fotoHelp').classList.remove('d-none')
        document.getElementById('fotoHelp').classList.add('d-block')
        document.getElementById('fileUploass').classList.add('border-danger')
        document.getElementById('fotoHelp').innerHTML = error.Foto
      } else {
        document.getElementById('fileUploass').classList.remove('border-danger')
        document.getElementById('fotoHelp').classList.add('d-none')
        document.getElementById('fotoHelp').classList.remove('d-block')
      }
      if (error.typeStok != null) {
        if (error.Stok != null) {
          document.getElementById('Stok').classList.add('is-invalid')
          document.getElementById('typeStok').classList.add('is-invalid')
          document.getElementById('stokHelp').innerHTML =
            'Stok dan jenis stok harus diisi'
        } else {
          document.getElementById('typeStok').classList.add('is-invalid')
          document.getElementById('stokHelp').innerHTML = error.typeStok
          document.getElementById('Stok').classList.remove('is-invalid')
        }
      } else {
        document.getElementById('typeStok').classList.remove('is-invalid')
        if (error.Stok != null) {
          document.getElementById('Stok').classList.add('is-invalid')
          document.getElementById('stokHelp').innerHTML = error.Stok
        } else {
          document.getElementById('Stok').classList.remove('is-invalid')
        }
      }
      if (error.typeLimit != null) {
        if (error.Limit != null) {
          document.getElementById('Limit').classList.add('is-invalid')
          document.getElementById('typeLimit').classList.add('is-invalid')
          document.getElementById('limitHelp').innerHTML =
            'Limit dan jenis limit harus diisi'
        } else {
          document.getElementById('typeLimit').classList.add('is-invalid')
          document.getElementById('limitHelp').innerHTML = error.typeLimit
          document.getElementById('Limit').classList.remove('is-invalid')
        }
      } else {
        document.getElementById('typeLimit').classList.remove('is-invalid')
        if (error.Limit != null) {
          document.getElementById('Limit').classList.add('is-invalid')
          document.getElementById('limitHelp').innerHTML = error.Limit
        } else {
          document.getElementById('Limit').classList.remove('is-invalid')
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
        window.location.href = linkUrl + 'Produk'
      })
    }
  })
})
