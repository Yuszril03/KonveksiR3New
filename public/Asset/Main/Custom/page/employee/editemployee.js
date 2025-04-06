// let iti
// let contenPersonal = 1
// let contenPekerjaan = 1

// LoadInitial()

// function LoadInitial () {
//   let inputNomorHP = document.querySelector('#Telephone')
//   iti = window.intlTelInput(inputNomorHP, {
//     initialCountry: 'auto',
//     geoIpLookup: callback => {
//       fetch('https://ipapi.co/json')
//         .then(res => res.json())
//         .then(data => callback(data.country_code))
//         .catch(() => callback('us'))
//     },
//     utilsScript:
//       'https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js' // just for formatting/placeholders etc
//   })

//   //Get Role
//   $.ajax({
//     url: linkUrl + '/C_Employee/getRole',
//     dataType: 'JSON'
//   }).done(result => {
//     $('#IdRole')
//       .find('option')
//       .remove()
//       .end()
//       .append('<option value="">Pilih Role...</option>')
//       .val('')
//     for (let i = 0; i < result.length; i++) {
//       let IdRole = document.getElementById('IdRole')
//       let option = document.createElement('option')
//       option.text = result[i].Name
//       option.title = result[i].Name
//       option.value = result[i].Id
//       IdRole.add(option)
//     }
//   })
//   // Get Position
//   getPosition(0)
// }

// function getPosition (Id) {
//   if (Id == 0) {
//     $('#IdPosition')
//       .find('option')
//       .remove()
//       .end()
//       .append('<option value="">Pilih Posisi...</option>')
//       .val('')
//   } else {
//     $.ajax({
//       url: linkUrl + 'C_Employee/getPosition/' + Id,
//       dataType: 'JSON'
//     }).done(result => {
//       $('#IdPosition')
//         .find('option')
//         .remove()
//         .end()
//         .append('<option value="">Pilih Posisi...</option>')
//         .val('')
//       for (let i = 0; i < result.length; i++) {
//         let IdPosition = document.getElementById('IdPosition')
//         let option = document.createElement('option')
//         option.text = result[i].NamePosition
//         option.title = result[i].NamePosition
//         option.value =
//           result[i].Superior +
//           '-' +
//           result[i].IdPosition +
//           '-' +
//           result[i].NamePosition
//         IdPosition.add(option)
//       }
//     })
//   }
// }

// document.getElementById('btnPersonal').addEventListener('click', function () {
//   let iconPeronal = document.getElementById('iconPeronal')
//   if (contenPersonal == 1) {
//     $('#contenPersonal').hide(800)
//     contenPersonal = 0
//     iconPeronal.classList.remove('bi-chevron-up')
//     iconPeronal.classList.add('bi-chevron-down')
//   } else {
//     contenPersonal = 1
//     $('#contenPersonal').show(800)
//     iconPeronal.classList.remove('bi-chevron-down')
//     iconPeronal.classList.add('bi-chevron-up')
//   }
// })

// document.getElementById('btnPekerjaan').addEventListener('click', function () {
//   let iconPekerjaan = document.getElementById('iconPekerjaan')
//   if (contenPekerjaan == 1) {
//     $('#contenPekerjaan').hide(800)
//     contenPekerjaan = 0
//     iconPekerjaan.classList.remove('bi-chevron-up')
//     iconPekerjaan.classList.add('bi-chevron-down')
//   } else {
//     contenPekerjaan = 1
//     $('#contenPekerjaan').show(800)
//     iconPekerjaan.classList.remove('bi-chevron-down')
//     iconPekerjaan.classList.add('bi-chevron-up')
//   }
// })

// document.getElementById('IdRole').addEventListener('change', function () {
//   if (this.value == '') {
//     getPosition(0)
//     document.getElementById('formSuperior').classList.add('d-none')
//     document.getElementById('IdPosition').disabled = true
//   } else {
//     getPosition('' + this.value + '')
//     document.getElementById('IdPosition').disabled = false
//   }
// })

// document.getElementById('IdPosition').addEventListener('change', function () {
//   let SplitValue = this.value.split('-')
//   // console.log(this)

//   if (SplitValue[0] == 0 || SplitValue[0] == '') {
//     $('#Superior')
//       .find('option')
//       .remove()
//       .end()
//       .append('<option value="">Pilih Atasan...</option>')
//       .val('')
//     document.getElementById('formSuperior').classList.add('d-none')
//   } else {
//     getSuperior(SplitValue[0], document.getElementById('IdRole').value)
//     document.getElementById('formSuperior').classList.remove('d-none')
//   }
// })

// function getSuperior (idPosition, IdRole) {
//   $('#Superior')
//     .find('option')
//     .remove()
//     .end()
//     .append('<option value="">Pilih Atasan...</option>')
//     .val('')

//   $.ajax({
//     url: linkUrl + 'C_Employee/getSuperior/' + idPosition + '/' + IdRole,
//     dataType: 'JSON'
//   }).done(result => {
//     $('#Superior')
//       .find('option')
//       .remove()
//       .end()
//       .append('<option value="">Pilih Atasan...</option>')
//       .val('')
//     for (let i = 0; i < result.length; i++) {
//       let Superior = document.getElementById('Superior')
//       let option = document.createElement('option')
//       option.text = result[i].Name
//       option.title = result[i].Name
//       option.value = result[i].Username
//       Superior.add(option)
//     }
//   })
//   // console.log(1)
// }

// function randomNumbers () {
//   let num = Math.random().toString().substring(2, 6)
//   return num
// }

// document.getElementById('save').addEventListener('click', function () {
//   let SplitPosition = document.getElementById('IdPosition').value.split('-')

//   let data = {
//     Name: document.getElementById('Name').value,
//     Gender: document.getElementById('Gender').value,
//     Telephone: iti.getNumber(intlTelInputUtils.numberFormat.E164),
//     CountryTelephone: iti.getSelectedCountryData().iso2,
//     Email: document.getElementById('Email').value,
//     Username: document.getElementById('Username').value,
//     Address: document.getElementById('Address').value,
//     IdRole: document.getElementById('IdRole').value,
//     IdPosition: SplitPosition[1],
//     IsSuperior: SplitPosition[0],
//     Superior: document.getElementById('Superior').value
//   }
//   $.ajax({
//     url: linkUrl + 'SaveEmployee',
//     type: 'POST',
//     data: data,
//     dataType: 'JSON'
//   }).done(result => {
//     let errors = result.error
//     let kondisi = result.kondisi
//     //Cek Error
//     if (kondisi == 0) {
//       if (errors.Name != null) {
//         document.getElementById('nameHelp').innerHTML = errors.Name
//         document.getElementById('Name').classList.add('is-invalid')
//       } else {
//         document.getElementById('Name').classList.remove('is-invalid')
//       }

//       if (errors.Gender != null) {
//         document.getElementById('genderHelp').innerHTML = errors.Gender
//         document.getElementById('Gender').classList.add('is-invalid')
//       } else {
//         document.getElementById('Gender').classList.remove('is-invalid')
//       }
//       if (errors.Telephone != null) {
//         document.getElementById('telefonHelp').innerHTML = errors.Telephone
//         document.getElementById('Telephone').classList.add('is-invalid')
//         document.getElementById('telefonHelp').classList.add('d-block')
//       } else {
//         document.getElementById('Telephone').classList.remove('is-invalid')
//         document.getElementById('telefonHelp').classList.add('d-none')
//       }
//       if (errors.Email != null) {
//         document.getElementById('emailHelp').innerHTML = errors.Email
//         document.getElementById('Email').classList.add('is-invalid')
//       } else {
//         document.getElementById('Email').classList.remove('is-invalid')
//       }

//       if (errors.Username != null) {
//         document.getElementById('usernameHelp').innerHTML = errors.Username
//         document.getElementById('Username').classList.add('is-invalid')
//       } else {
//         document.getElementById('Username').classList.remove('is-invalid')
//       }

//       if (errors.Address != null) {
//         document.getElementById('addressHelp').innerHTML = errors.Address
//         document.getElementById('Address').classList.add('is-invalid')
//       } else {
//         document.getElementById('Address').classList.remove('is-invalid')
//       }

//       if (errors.IdRole != null) {
//         document.getElementById('IdRoleHelp').innerHTML = errors.IdRole
//         document.getElementById('IdRole').classList.add('is-invalid')
//       } else {
//         document.getElementById('IdRole').classList.remove('is-invalid')
//       }
//       if (errors.IdPosition != null) {
//         document.getElementById('IdPositionHelp').innerHTML = errors.IdPosition
//         document.getElementById('IdPosition').classList.add('is-invalid')
//       } else {
//         document.getElementById('IdPosition').classList.remove('is-invalid')
//       }
//       if (errors.Superior != null) {
//         document.getElementById('SuperiorHelp').innerHTML = errors.Superior
//         document.getElementById('Superior').classList.add('is-invalid')
//       } else {
//         document.getElementById('Superior').classList.remove('is-invalid')
//       }
//     } else if (kondisi == 2) {
//       Swal.fire({
//         icon: 'error',
//         title: 'Data tidak tersimpan',
//         showConfirmButton: false,
//         timer: 1500
//       })
//     } else {
//       Swal.fire({
//         icon: 'success',
//         title: 'Data berhasil tersimpan',
//         showConfirmButton: false,
//         timer: 1500
//       }).then(result => {
//         window.location.href = linkUrl + 'Karyawan'
//       })
//     }
//   })
// })
// function isNumberKey (evt) {
//   var charCode = evt.which ? evt.which : evt.keyCode
//   if (charCode > 31 && (charCode < 48 || charCode > 57)) return false
//   return true
// }
