let iti
loadINitial()

setData()

let modalEditData = new bootstrap.Modal(
  document.getElementById('modalEditData'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let modalEditFoto = new bootstrap.Modal(
  document.getElementById('modalEditFoto'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let kondisiFoto = 'Kosong'
function loadINitial () {
  let inputNomorHP = document.querySelector('#Telephone')
  iti = window.intlTelInput(inputNomorHP, {
    initialCountry: 'auto',
    geoIpLookup: callback => {
      fetch('https://ipapi.co/json')
        .then(res => res.json())
        .then(data => callback(data.country_code))
        .catch(() => callback('us'))
    },
    utilsScript:
      'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js' // just for formatting/placeholders etc
  })
}
function isNumberKey (evt) {
  var charCode = evt.which ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57)) return false
  return true
}

function setData () {
  $.ajax({
    url: linkUrl + '/C_Login/getDataProfil',
    dataType: 'JSON',
    method: 'GET'
  }).done(result => {
    // console.log(result.Country_Telephone)
    iti.setNumber(result.Telephone)
    document.getElementById('tempTelephone').value = result.Telephone
    iti.setCountry(result.Country_Telephone)
    document.getElementById('Name').innerHTML = result.Name
    document.getElementById('username').innerHTML = result.Username
    document.getElementById('TempEmail').value = result.Email
    document.getElementById('email').innerHTML =
      result.Email == null ? '-' : result.Email
    document.getElementById('telefon').innerHTML =
      result.Telephone == null ? '-' : result.Telephone
    document.getElementById('address').innerHTML =
      result.Address == null ? '-' : result.Address
    document.getElementById('posisi').innerHTML =
      result.NamePosition == null ? '-' : result.NamePosition

    document.getElementById('role').innerHTML =
      result.NameRole == null ? '-' : result.NameRole

    if (result.Gender == 1) {
      document.getElementById('gender').innerHTML = 'Laki-Laki'
    } else {
      document.getElementById('gender').innerHTML = 'Perempuan'
    }
    if (result.Status == 1) {
      document.getElementById(
        'status'
      ).innerHTML = `<span class="badge text-bg-success">Aktif</span>`
    } else {
      document.getElementById(
        'status'
      ).innerHTML = `<span class="badge text-bg-danger">Tidak Aktif</span>`
    }
    if (result.isSuperior == null) {
      document.getElementById('atasan').innerHTML = `Tidak Ada`
    } else {
      document.getElementById('atasan').innerHTML = result.atasan
    }
    let options = {
      // weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }

    let creted = new Date(result.CreatedDate)
    document.getElementById('created').innerHTML =
      creted.toLocaleDateString('id-ID', options) +
      ` ${creted.getHours()}:${creted.getMinutes()}`
    let modif = new Date(result.ModifiedDate)
    document.getElementById('modified').innerHTML =
      modif.toLocaleDateString('id-ID', options) +
      ` ${modif.getHours()}:${modif.getMinutes()}`
  })
}
document.getElementById('editData').addEventListener('click', function () {
  modalEditData.show()
  document.getElementById('NameM').value =
    document.getElementById('Name').innerHTML
  document.getElementById('UsernameM').value =
    document.getElementById('username').innerHTML
  document.getElementById('EmailM').value =
    document.getElementById('email').innerHTML
  if (document.getElementById('email').innerHTML == '-') {
    document.getElementById('EmailM').value = ''
  }
  document.getElementById('AddressM').value =
    document.getElementById('address').innerHTML
  if (document.getElementById('address').innerHTML == '-') {
    document.getElementById('AddressM').value = ''
  }

  document.getElementById('genderM').value =
    document.getElementById('gender').innerHTML
})
document.getElementById('batal').addEventListener('click', function () {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: 'Tidak menyimpan data ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      modalEditData.hide()
    }
  })
})

document.getElementById('simpan').addEventListener('click', function () {
  let data = {
    Telephone: iti.getNumber(intlTelInputUtils.numberFormat.E164),
    tempTelefon: document.getElementById('tempTelephone').value,
    CountryTelephone: iti.getSelectedCountryData().iso2,
    Email: document.getElementById('EmailM').value,
    TempEmail: document.getElementById('TempEmail').value,
    Address: document.getElementById('AddressM').value
  }
  $.ajax({
    url: linkUrl + 'C_Login/UpdateDataEmployee',
    data: data,
    dataType: 'JSON',
    method: 'POST'
  }).done(result => {
    let errors = result.error
    let kondisi = result.kondisi
    console.log(result)
    //Cek Error
    if (kondisi == 0) {
      if (
        errors.Telephone != null &&
        iti.getNumber(intlTelInputUtils.numberFormat.E164) !=
          document.getElementById('tempTelephone').value
      ) {
        document.getElementById('telefonHelp').innerHTML = errors.Telephone
        document.getElementById('Telephone').classList.add('is-invalid')
        document.getElementById('telefonHelp').classList.add('d-block')
      } else {
        document.getElementById('Telephone').classList.remove('is-invalid')
        document.getElementById('telefonHelp').classList.add('d-none')
      }
      if (errors.Email != null) {
        document.getElementById('emailnHelp').innerHTML = errors.Email
        document.getElementById('EmailM').classList.add('is-invalid')
      } else {
        document.getElementById('EmailM').classList.remove('is-invalid')
      }

      if (errors.Address != null) {
        document.getElementById('addressHelp').innerHTML = errors.Address
        document.getElementById('AddressM').classList.add('is-invalid')
      } else {
        document.getElementById('AddressM').classList.remove('is-invalid')
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
      }).then(hasil => {
        window.location.href = linkUrl
      })
    } else {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        setData()
        modalEditData.hide()
      })
    }
  })
})

document.getElementById('changeProfil').addEventListener('click', function () {
  if (document.getElementById('tempImage').value == '') {
    $('#btnCancelImage').hide()
    $('#AddImage').hide()
    $('.image-title').hide()
    $('#NoneImage').show()
  } else {
    $('#btnCancelImage').show()
    $('#NoneImage').hide()
    $('.image-upload-wrap').hide()
    $('.image-title').hide()
    kondisiFoto = 'Sudah'
    document.getElementById('AddImage').src =
      linkUrl + '/' + document.getElementById('tempImage').value
  }

  modalEditFoto.show()
})
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
  kondisiFoto = 'Ganti'
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
document.getElementById('cancelImage').addEventListener('click', function () {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: 'Tidak menyimpan data ini!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      modalEditFoto.hide()
    }
  })
})
document.getElementById('saveImage').addEventListener('click', function () {
  let isFoto = 0
  let formData = new FormData()
  if (document.getElementById('tempImage').value == '') {
    if (document.getElementById('uploadFilee').files[0] == undefined) {
      formData.append('IsFoto', 0)
      formData.append('Foto', document.getElementById('uploadFilee').files[0])
    } else {
      formData.append('IsFoto', 1)
      formData.append('Foto', document.getElementById('uploadFilee').files[0])
    }
  } else {
    if (kondisiFoto == 'Sudah') {
      formData.append('IsFoto', 2)
      formData.append('Foto', document.getElementById('uploadFilee').files[0])
    } else {
      if (document.getElementById('uploadFilee').files[0] == undefined) {
        formData.append('IsFoto', 0)
        formData.append('Foto', document.getElementById('uploadFilee').files[0])
      } else {
        formData.append('IsFoto', 1)
        formData.append('Foto', document.getElementById('uploadFilee').files[0])
      }
    }
  }
  $.ajax({
    url: linkUrl + 'C_Login/saveImage',
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
        window.location.reload()
      })
    }
  })
})
