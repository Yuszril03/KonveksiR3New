let iti
LoadInitial()

function LoadInitial () {
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

document.getElementById('cancel').addEventListener('click', LeaveFrom)

function LeaveFrom () {
  Swal.fire({
    title: 'Apakah kamu yakin ?',
    text: 'Keluar tanpa melakukan simpan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Keluar!',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      window.location.href = linkUrl + '/Karyawan'
    }
  })
}

document.getElementById('save').addEventListener('click', function () {
  let formData = new FormData()

  formData.append('Name', document.getElementById('Name').value)
  formData.append(
    'Telephone',
    iti.getNumber(intlTelInputUtils.numberFormat.E164)
  )
  formData.append('CountryTelephone', iti.getSelectedCountryData().iso2)

  formData.append('Email', document.getElementById('Email').value)
  formData.append('Address', document.getElementById('Address').value)

  $.ajax({
    url: linkUrl + '/SavePelanggan',
    data: formData,
    method: 'POST',
    dataType: 'JSON',
    contentType: false,
    processData: false,
    cache: false
  }).done(result => {
    // console.log(result)
    let Error = result.error
    let Kondisi = result.kondisi
    if (Kondisi == 0) {
      document.getElementById('nameHelp').innerHTML = Error.Name
        ? Error.Name
        : ''
      document.getElementById('telefonHelp').innerHTML = Error.Telephone
        ? Error.Telephone
        : ''
      document.getElementById('emailHelp').innerHTML = Error.Email
        ? Error.Email
        : ''
      document.getElementById('addressHelp').innerHTML = Error.Address
        ? Error.Address
        : ''
    } else if (Kondisi == 2) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      })
    } else if (Kondisi == 3) {
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
        window.location.href = linkUrl + 'Pelanggan'
      })
    }
  })
})
function isValidEmail (email) {
  if (email.indexOf('@') != -1 && email.indexOf('.') != -1) {
    return 1
  } else {
    return 0
  }
}

function isNumberKey (evt) {
  var charCode = evt.which ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57)) return false
  return true
}
