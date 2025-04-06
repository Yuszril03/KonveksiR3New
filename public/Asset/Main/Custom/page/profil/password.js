document.getElementById('simpan').addEventListener('click', function () {
  let data = {
    ktLama: document.getElementById('ktLama').value,
    ktBaru: document.getElementById('ktBaru').value,
    ktBaruKof: document.getElementById('ktBaruKof').value
  }
  $.ajax({
    url: linkUrl + 'C_Login/SavePassword',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(result => {
    let kondisi = result.kondisi
    let error = result.error
    if (kondisi == 0) {
      if (error.ktLama != null) {
        document.getElementById('ktLamaHelp').innerHTML = error.ktLama
        document.getElementById('ktLama').classList.add('is-invalid')
      } else {
        document.getElementById('ktLama').classList.remove('is-invalid')
      }
      if (error.ktBaru != null) {
        document.getElementById('ktBaruHelp').innerHTML = error.ktBaru
        document.getElementById('ktBaru').classList.add('is-invalid')
      } else {
        document.getElementById('ktBaru').classList.remove('is-invalid')
      }
      if (error.ktBaruKof != null) {
        document.getElementById('ktBaruKofHelp').innerHTML = error.ktBaruKof
        document.getElementById('ktBaruKof').classList.add('is-invalid')
      } else {
        document.getElementById('ktBaruKof').classList.remove('is-invalid')
      }
    } else if (kondisi == 2) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      })
      document.getElementById('ktLama').value = ''
      document.getElementById('ktBaru').value = ''
      document.getElementById('ktBaruKof').value = ''
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
        document.getElementById('ktLama').value = ''
        document.getElementById('ktBaru').value = ''
        document.getElementById('ktBaruKof').value = ''
        document.getElementById('ktLama').classList.remove('is-invalid')
        document.getElementById('ktBaru').classList.remove('is-invalid')
        document.getElementById('ktBaruKof').classList.remove('is-invalid')
      })
    }
  })
})
