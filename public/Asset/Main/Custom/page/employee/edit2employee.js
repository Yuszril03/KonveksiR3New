let iti
let contenPersonal = 1
let contenPekerjaan = 1
let tempPosition = 0
let tempRole = ''
let tempPoisisi = ''

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

  setData()
  // Get Position
  //   getPosition(0)
}

document.getElementById('btnPersonal').addEventListener('click', function () {
  let iconPeronal = document.getElementById('iconPeronal')
  if (contenPersonal == 1) {
    $('#contenPersonal').hide(800)
    contenPersonal = 0
    iconPeronal.classList.remove('bi-chevron-up')
    iconPeronal.classList.add('bi-chevron-down')
  } else {
    contenPersonal = 1
    $('#contenPersonal').show(800)
    iconPeronal.classList.remove('bi-chevron-down')
    iconPeronal.classList.add('bi-chevron-up')
  }
})

document.getElementById('btnPekerjaan').addEventListener('click', function () {
  let iconPekerjaan = document.getElementById('iconPekerjaan')
  if (contenPekerjaan == 1) {
    $('#contenPekerjaan').hide(800)
    contenPekerjaan = 0
    iconPekerjaan.classList.remove('bi-chevron-up')
    iconPekerjaan.classList.add('bi-chevron-down')
  } else {
    contenPekerjaan = 1
    $('#contenPekerjaan').show(800)
    iconPekerjaan.classList.remove('bi-chevron-down')
    iconPekerjaan.classList.add('bi-chevron-up')
  }
})

document.getElementById('Back1').addEventListener('click', LeaveFrom)
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
function setData () {
  $.ajax({
    url: linkUrl + 'C_Employee/getDataFrom',
    dataType: 'JSON'
  }).done(result => {
    console.log(result)

    document.getElementById('Name').value = result.Name
    document.getElementById('Gender').value = result.Gender
    document.getElementById('Username').value = result.Username
    document.getElementById('Email').value = result.Email
    document.getElementById('Address').value = result.Address
    iti.setNumber(result.Telephone)
    tempPosition = result.IdPosition
    document.getElementById('tempTelephone').value = result.Telephone
    iti.setCountry(result.Country_Telephone)
    tempPoisisi = result.IdPosition
    tempRole = result.IdRole
    setRole(result.IdRole)
    setPosition(result.IdRole, result.IdPosition, result.Superior)
  })
}

function setFormSuperior (from, IdSuperior) {
  let SplitValue = from
  // console.log(this)

  if (SplitValue[0] == 0 || SplitValue[0] == '') {
    $('#Superior')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Atasan...</option>')
      .val('')
    document.getElementById('formSuperior').classList.add('d-none')
  } else {
    getSuperior(SplitValue[0], SplitValue[2], IdSuperior)
    document.getElementById('formSuperior').classList.remove('d-none')
  }
}

function getSuperior (idPosition, IdRole, IdSuperior) {
  $('#Superior')
    .find('option')
    .remove()
    .end()
    .append('<option value="">Pilih Atasan...</option>')
    .val('')

  $.ajax({
    url: linkUrl + 'C_Employee/getSuperior/' + idPosition + '/' + IdRole,
    dataType: 'JSON'
  }).done(result => {
    $('#Superior')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Atasan...</option>')
      .val('')
    for (let i = 0; i < result.length; i++) {
      // console.log(!(IdSuperior != document.getElementById('Username').value))
      if (document.getElementById('Username').value != result[i].Username) {
        let Superior = document.getElementById('Superior')
        let option = document.createElement('option')
        option.text = result[i].Name
        option.title = result[i].Name
        option.value = result[i].Username
        Superior.add(option)
      }

      if (result[i].Username == IdSuperior) {
        $('#Superior').val(result[i].Username)
      }
    }
  })
  // console.log(1)
}

function setPosition (idRole, IdPositions, IdSuperior) {
  if (IdPositions == 0 && idRole == 0) {
    $('#IdPosition')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Posisi...</option>')
      .val('')
    document.getElementById('formSuperior').classList.add('d-none')
    document.getElementById('IdPosition').disabled = true
  } else {
    document.getElementById('IdPosition').disabled = false

    //   console.log(1)
    $.ajax({
      url: linkUrl + 'C_Employee/getPosition/' + idRole,
      dataType: 'JSON'
    }).done(result => {
      $('#IdPosition')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Pilih Posisi...</option>')
        .val('')
      for (let i = 0; i < result.length; i++) {
        let IdPosition = document.getElementById('IdPosition')
        let option = document.createElement('option')
        option.text = result[i].NamePosition
        option.title = result[i].NamePosition
        option.value =
          result[i].Superior +
          '-' +
          result[i].IdPosition +
          '-' +
          result[i].NamePosition
        IdPosition.add(option)
        if (result[i].IdPosition == IdPositions) {
          //   console.log(1)
          setFormSuperior(
            result[i].Superior +
              '-' +
              result[i].IdPosition +
              '-' +
              result[i].IdRole,
            IdSuperior
          )

          $('#IdPosition').val(
            result[i].Superior +
              '-' +
              result[i].IdPosition +
              '-' +
              result[i].NamePosition
          )
        }
      }
    })
  }
}

function setRole (id) {
  //Get Role
  $.ajax({
    url: linkUrl + '/C_Employee/getRole',
    dataType: 'JSON'
  }).done(result => {
    $('#IdRole')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Role...</option>')

    for (let i = 0; i < result.length; i++) {
      let IdRole = document.getElementById('IdRole')
      let option = document.createElement('option')
      option.text = result[i].Name
      option.title = result[i].Name
      option.value = result[i].Id
      IdRole.add(option)
    }
    $('#IdRole').val(id)
  })
}

document.getElementById('IdRole').addEventListener('change', function () {
  if (this.value == '') {
    getPosition(0)
    document.getElementById('formSuperior').classList.add('d-none')
    document.getElementById('IdPosition').disabled = true
  } else {
    getPosition('' + this.value + '')
    document.getElementById('IdPosition').disabled = false
  }
})

document.getElementById('IdPosition').addEventListener('change', function () {
  let SplitValue = this.value.split('-')

  if (SplitValue[0] == 0 || SplitValue[0] == '') {
    $('#Superior')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Atasan...</option>')
      .val('')
    document.getElementById('formSuperior').classList.add('d-none')
  } else {
    // console.log(parseInt(tempPosition) == parseInt(SplitValue[1]))
    if (
      parseInt(tempPosition) == parseInt(SplitValue[1]) &&
      parseInt(SplitValue[1]) == 2
    ) {
      document.getElementById(
        'labelSuperior'
      ).innerHTML = `Atasan <span class="text-danger"><sup>*</sup></span>`
      document.getElementById('formSwitchSuperior').classList.add('d-none')
    } else {
      document.getElementById(
        'labelSuperior'
      ).innerHTML = `Atasan Sekarang <span class="text-danger"><sup>*</sup></span>`
      document.getElementById('formSwitchSuperior').classList.remove('d-none')
    }
    switchSuperior()
    getSuperior(SplitValue[0], document.getElementById('IdRole').value, '')
    document.getElementById('formSuperior').classList.remove('d-none')
  }
})

function switchSuperior () {
  $('#SwitchSuperior')
    .find('option')
    .remove()
    .end()
    .append('<option value="">Pilih Atasan...</option>')
    .val('')

  $.ajax({
    url: linkUrl + 'C_Employee/getSuperior/' + tempPoisisi + '/' + tempRole,
    dataType: 'JSON'
  }).done(result => {
    $('#SwitchSuperior')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Atasan...</option>')
      .val('')
    for (let i = 0; i < result.length; i++) {
      // console.log(!(IdSuperior != document.getElementById('Username').value))
      if (document.getElementById('Username').value != result[i].Username) {
        let Superior = document.getElementById('SwitchSuperior')
        let option = document.createElement('option')
        option.text = result[i].Name
        option.title = result[i].Name
        option.value = result[i].Username
        Superior.add(option)
      }
    }
  })
}

function getPosition (Id) {
  if (Id == 0) {
    $('#IdPosition')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Posisi...</option>')
      .val('')
  } else {
    $.ajax({
      url: linkUrl + 'C_Employee/getPosition/' + Id,
      dataType: 'JSON'
    }).done(result => {
      $('#IdPosition')
        .find('option')
        .remove()
        .end()
        .append('<option value="">Pilih Posisi...</option>')
        .val('')
      for (let i = 0; i < result.length; i++) {
        let IdPosition = document.getElementById('IdPosition')
        let option = document.createElement('option')
        option.text = result[i].NamePosition
        option.title = result[i].NamePosition
        option.value =
          result[i].Superior +
          '-' +
          result[i].IdPosition +
          '-' +
          result[i].NamePosition
        IdPosition.add(option)
      }
    })
  }
}

document.getElementById('save').addEventListener('click', function () {
  let SplitPosition = document.getElementById('IdPosition').value.split('-')
  let IsSwitch = 0
  if (document.getElementById('formSwitchSuperior').classList.length == 1) {
    IsSwitch = 1
  }
  //   console.log(1)
  let data = {
    Name: document.getElementById('Name').value,
    Gender: document.getElementById('Gender').value,
    Telephone: iti.getNumber(intlTelInputUtils.numberFormat.E164),
    tempTelefon: document.getElementById('tempTelephone').value,
    CountryTelephone: iti.getSelectedCountryData().iso2,
    Email: document.getElementById('Email').value,
    Username: document.getElementById('Username').value,
    Address: document.getElementById('Address').value,
    IdRole: document.getElementById('IdRole').value,
    IdPosition: SplitPosition[1],
    IsSuperior: SplitPosition[0],
    IsSwitchSuperior: IsSwitch,
    Superior: document.getElementById('Superior').value,
    SwitchSuperior: document.getElementById('SwitchSuperior').value
  }
  // console.log(data)

  $.ajax({
    url: linkUrl + 'updateEmployee',
    type: 'POST',
    data: data,
    dataType: 'JSON'
  }).done(result => {
    let errors = result.error
    let kondisi = result.kondisi
    //Cek Error
    if (kondisi == 0) {
      if (errors.Name != null) {
        document.getElementById('nameHelp').innerHTML = errors.Name
        document.getElementById('Name').classList.add('is-invalid')
      } else {
        document.getElementById('Name').classList.remove('is-invalid')
      }

      if (errors.Gender != null) {
        document.getElementById('genderHelp').innerHTML = errors.Gender
        document.getElementById('Gender').classList.add('is-invalid')
      } else {
        document.getElementById('Gender').classList.remove('is-invalid')
      }
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
        document.getElementById('emailHelp').innerHTML = errors.Email
        document.getElementById('Email').classList.add('is-invalid')
      } else {
        document.getElementById('Email').classList.remove('is-invalid')
      }

      if (errors.Address != null) {
        document.getElementById('addressHelp').innerHTML = errors.Address
        document.getElementById('Address').classList.add('is-invalid')
      } else {
        document.getElementById('Address').classList.remove('is-invalid')
      }

      if (errors.IdRole != null) {
        document.getElementById('IdRoleHelp').innerHTML = errors.IdRole
        document.getElementById('IdRole').classList.add('is-invalid')
      } else {
        document.getElementById('IdRole').classList.remove('is-invalid')
      }
      if (errors.IdPosition != null) {
        document.getElementById('IdPositionHelp').innerHTML = errors.IdPosition
        document.getElementById('IdPosition').classList.add('is-invalid')
      } else {
        document.getElementById('IdPosition').classList.remove('is-invalid')
      }
      if (errors.Superior != null) {
        document.getElementById('SuperiorHelp').innerHTML = errors.Superior
        document.getElementById('Superior').classList.add('is-invalid')
      } else {
        document.getElementById('Superior').classList.remove('is-invalid')
      }
      if (errors.SuperiorSwitch != null) {
        document.getElementById('SwcithSuperiorHelp').innerHTML =
          errors.Superior
        document.getElementById('SwitchSuperior').classList.add('is-invalid')
      } else {
        document.getElementById('SwitchSuperior').classList.remove('is-invalid')
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
        window.location.href = linkUrl + 'Karyawan'
      })
    }
  })
})
