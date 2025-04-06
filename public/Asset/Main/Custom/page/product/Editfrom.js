let contenProduct = 1
let contenPriceCustom = 1
let isAddCustom = 1
let isImage = ''
// let customPrice = new bootstrap.Modal(document.getElementById('customPrice'), {
//   keyboard: false,
//   backdrop: 'static',
//   focus: true
// })
let date = new Date()
let idTempCustom = '' + date.getTime() + ''

setData()

function setData () {
  $.ajax({
    url: linkUrl + '/C_Product/getDataForm',
    dataType: 'JSON',
    method: 'GET'
  }).done(result => {
    document.getElementById('Name').value = result.Name
    document.getElementById('TempSlug').value = result.Slug
    document.getElementById('Size').value = result.Size
    getMaterialProduct(result.Id_Material_Product)
    getTypeProduct(result.Id_Type_Product)
    document.getElementById('ModalP').value = formatRupiah(result.Capital_Price)
    document.getElementById('Potong').value = formatRupiah(result.Per_Piece)
    document.getElementById('Lusin').value = formatRupiah(result.Per_Doze)
    document.getElementById('Kodi').value = formatRupiah(result.Per_Kodi)
    document.getElementById('Stok').value = formatRupiah(result.Stock)
    if (result.TypeStock == 1) {
      document.getElementById('Stok2').value =
        formatRupiah(result.Stock) + ' Potong'
    } else {
      let types = 12
      let singkatan = 'Lusin'
      if (result.TypeStock == 3) {
        types = 20
      }
      let hitung = result.Stock_Piece / types + ''
      let array = hitung.split('.')
      if (array.length == 1) {
        document.getElementById('Stok2').innerHTML =
          formatRupiah(result.Stock) + ' ' + singkatan
      } else {
        let getOne = array[0]
        let getTow = array[0] * types
        let ressult2 = getTow - result.Stock_Piece
        document.getElementById('Stok2').value =
          formatRupiah(getOne) +
          ' ' +
          singkatan +
          ' ' +
          formatRupiah(ressult2 + '') +
          ' Potong'
      }
    }

    document.getElementById('Limit').value = formatRupiah(result.Limit)
    getTypeItem(result.TypeStock, result.TypeLimit)
    if (result.Image == null) {
      $('#btnCancelImage').hide()
      $('#AddImage').hide()
      $('.image-title').hide()
      $('#NoneImage').show()
      isImage = 'Kosong'
    } else {
      $('#btnCancelImage').show()
      $('#NoneImage').hide()
      $('.image-upload-wrap').hide()
      $('.image-title').hide()

      document.getElementById('AddImage').src = linkUrl + '/' + result.Image
      isImage = 'Sudah'
    }
  })
}

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
  isImage = 'Ganti'

  // document.getElementById('tempfoto').value = ''
  $('#btnCancelImage').hide()
  $('#AddImage').hide()
  $('#NoneImage').show()
  $('.image-title').show()
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

function getMaterialProduct (Id) {
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

    for (let i = 0; i < result.length; i++) {
      let material = document.getElementById('material')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      material.add(option)
      if (result[i].Id == Id) {
        $('#material').val(result[i].Id)
      }
    }
  })
}

function getTypeItem (idstock, idlimit) {
  $.ajax({
    url: linkUrl + 'C_Product/getTypeItem',
    dataType: 'JSON',
    type: 'JSON'
  }).done(result => {
    $('#typeLimit')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Satuan...</option>')

    $('#typeStok')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Satuan...</option>')

    for (let i = 0; i < result.length; i++) {
      let typeStok = document.getElementById('typeStok')
      let typeLimit = document.getElementById('typeLimit')
      let option = document.createElement('option')
      let option2 = document.createElement('option')
      option.text = '/ ' + result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id

      option2.text = '/ ' + result[i].Name
      option2.title = result[i].Name
      option2.value = result[i].Id

      typeLimit.add(option2)
      typeStok.add(option)

      if (result[i].Id == idstock) {
        $('#typeStok').val(result[i].Id)
      }
      if (result[i].Id == idlimit) {
        $('#typeLimit').val(result[i].Id)
      }
    }
  })
}

document.getElementById('typeStok').addEventListener('change', function () {
  $('#typeLimit').val(this.value)
})
function getTypeProduct (Id) {
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

    for (let i = 0; i < result.length; i++) {
      let type = document.getElementById('type')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      type.add(option)
      if (result[i].Id == Id) {
        $('#type').val(result[i].Id)
      }
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
document.getElementById('Back1').addEventListener('click', function () {
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
  formData.append('TempSlug', document.getElementById('TempSlug').value)
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
  formData.append('Stok', document.getElementById('Stok').value)
  formData.append(
    'Limit',
    document.getElementById('Limit').value.replaceAll('.', '')
  )
  formData.append('typeStok', document.getElementById('typeStok').value)
  formData.append('typeLimit', document.getElementById('typeLimit').value)
  if (isImage == 'Ganti') {
    if (document.getElementById('uploadFilee').files[0] == undefined) {
      formData.append('IsFoto', 0)
      formData.append('Foto', document.getElementById('uploadFilee').files[0])
    } else {
      formData.append('IsFoto', 1)
      formData.append('Foto', document.getElementById('uploadFilee').files[0])
    }
  } else if (isImage == 'Kosong') {
    if (document.getElementById('uploadFilee').files[0] == undefined) {
      formData.append('IsFoto', 0)
      formData.append('Foto', document.getElementById('uploadFilee').files[0])
    } else {
      formData.append('IsFoto', 1)
      formData.append('Foto', document.getElementById('uploadFilee').files[0])
    }
  } else {
    formData.append('IsFoto', 2)
    formData.append('Foto', document.getElementById('uploadFilee').files[0])
  }

  // formData.append('Foto', document.getElementById('uploadFilee').files[0])
  formData.append('Slug', slug.toLowerCase())

  //   console.log(formData)
  $.ajax({
    url: linkUrl + 'saveEditProduct',
    method: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    dataType: 'JSON'
  }).done(result => {
    let kondisi = result.kondisi
    let error = result.error

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
