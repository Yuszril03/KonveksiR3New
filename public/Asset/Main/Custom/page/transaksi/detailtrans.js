document.getElementById('Back1').addEventListener('click', function () {
  window.location.href = linkUrl + '/Riwayat-Transaksi'
})
let modalPembayaranTrans = new bootstrap.Modal(
  document.getElementById('modalPembayaranTrans'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let modalWarningPayment = new bootstrap.Modal(
  document.getElementById('modalWarningPayment'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let modalSukses = new bootstrap.Modal(document.getElementById('modalSukses'), {
  keyboard: false,
  backdrop: 'static',
  focus: true
})
let sisaPembayaran = 0
let transModif = ''
let logs = 0
RequestData()
function setLoadingItem (isLoading) {
  if (isLoading == 1) {
    document.getElementById('loadingData').classList.add('d-none')
    document.getElementById('kontenItem').classList.remove('d-none')
  } else {
    document.getElementById('kontenItem').classList.add('d-none')
    document.getElementById('loadingData').classList.remove('d-none')
  }
}

function RequestData () {
  setLoadingItem(0)
  setTimeout(function () {
    setLoadingItem(1)
    setData()
  }, 2000)
}

let NoTranss = ''

// setData()
function setData () {
  $.ajax({
    url: linkUrl + 'C_Transaction/getDetailTrans',
    dataType: 'JSON'
  }).done(result => {
    let Trans = result.Trans
    let BeforeTrans = result.BeforeTrans
    let NextTrans = result.NextTrans
    let LogTrans = result.LogTrans
    let Item = result.Item
    // console.log(result)

    setItem(Item)
    setLog(LogTrans)
    let Iconstatus = document.getElementById('iconStatus').classList
    let StatusKonten = document.getElementById('statusKonten').classList
    let valueStatus = document.getElementById('valueStatus')

    transModif = Trans.transModif
    if (Trans.StatusTransakksi == '4') {
      Iconstatus.add('bi-check-circle')
      StatusKonten.add('alert-success')

      logsPayments(result.LogTransPayment)
      valueStatus.innerHTML = 'Transaksi sudah dibayar lunas'
    } else if (Trans.StatusTransakksi == '6') {
      Iconstatus.add('bi-fast-forward-fill')
      StatusKonten.add('alert-primary')
      logsPayments(result.LogTransPayment)
      valueStatus.innerHTML =
        'Transaksi sudah diteruskan ke <b>' + NextTrans.Number_Trans + '</b>'
    } else if (Trans.StatusTransakksi == '3') {
      Iconstatus.add('bi-x-circle')
      StatusKonten.add('alert-danger')
      valueStatus.innerHTML = 'Transaksi sudah dibatalkan'
    } else if (Trans.StatusTransakksi == '2') {
      Iconstatus.add('bi-floppy')
      StatusKonten.add('alert-warning')
      valueStatus.classList.add('fw-bold')
      valueStatus.innerHTML = 'Transaksi masih ditahap simpan'
    } else if (Trans.StatusTransakksi == '5') {
      document.getElementById('btnHutang').classList.remove('d-none')
      Iconstatus.add('bi-exclamation-triangle')
      StatusKonten.add('alert-danger')
      logsPayments(result.LogTransPayment)
      valueStatus.innerHTML =
        'Transaksi masih mempunyai hutang, klik untuk <a href="javascript:gotoPay();">Pembayaran</a>'
    } else {
      Iconstatus.add('bi-pencil-square')
      StatusKonten.add('alert-dark')
      valueStatus.innerHTML = 'Transaksi masih dalam draft'
    }
    if (BeforeTrans != null) {
      document.getElementById(
        'transTerusan'
      ).innerHTML = `<p<a href="${linkUrl}/Detail-Transaksi/${BeforeTrans.Number_Trans}">${BeforeTrans.Number_Trans}</a></p>`
    } else {
      document.getElementById('transTerusan').innerHTML = `<p>-</p>`
    }

    document.getElementById('nota').innerHTML = `<p>${Trans.Number_Trans}</p>`
    NoTranss = Trans.Number_Trans
    document.getElementById('namaKAsir').innerHTML = `<p>${Trans.NamaKasir}</p>`
    document.getElementById(
      'pelanggan'
    ).innerHTML = `<p>${Trans.NamaCustomer}</p>`
    var options = {
      // weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }
    let today = new Date(Trans.CreatedDate)
    document.getElementById('tglTrans').innerHTML =
      '<p>' +
      today.toLocaleDateString('id-ID', options) +
      ' ' +
      today.getHours() +
      ':' +
      today.getMinutes() +
      '</p>'

    document.getElementById('subtotal').innerHTML =
      'Rp ' + formatRupiah(result.SubTotal + '')
    document.getElementById('hutang').innerHTML =
      'Rp ' + formatRupiah(Trans.Total_Dept + '')
    let Total = parseInt(result.SubTotal) + parseInt(Trans.Total_Dept)
    let Kembalian = Trans.Payment - Total
    if (
      Trans.StatusTransakksi == 1 ||
      Trans.StatusTransakksi == 2 ||
      Trans.StatusTransakksi == 3
    ) {
      Kembalian = 0
    } else if (Trans.StatusTransakksi == 5 || Trans.StatusTransakksi == 6) {
      sisaPembayaran = Math.abs(Kembalian)
      document.getElementById('titleKembalian').innerHTML = 'Sisa Pembayaran'
    }
    document.getElementById('total').innerHTML =
      'Rp ' + formatRupiah(Total + '')
    document.getElementById('bayar').innerHTML =
      'Rp ' + formatRupiah(Trans.Payment + '')
    document.getElementById('kembalian').innerHTML =
      'Rp ' + formatRupiah(Kembalian + '')
  })
}

function logsPayments (data) {
  let valueOtherBayar = document.getElementById('valueOtherBayar')
  let valueOriBayar = document.getElementById('valueOriBayar')
  if (data.length > 1) {
    let values = ''
    valueOriBayar.classList.add('d-none')
    let lastBayar = 0
    for (let i = 0; i < data.length; i++) {
      // let splitString = data[i]['Description'].split(' ')
      let textBayar = formatRupiah('' + data[i].Payment)
      values += `
      <div class="row">
            <div class="col-lg-10 col-7">
                <p>Bayar Tahap ${i + 1}</p>
            </div>
            <div class="col-lg col">
                <div ">Rp ${textBayar}</div>
            </div>
        </div>
      `
      lastBayar = i + 1
    }
    document.getElementById('titleKembalian').innerHTML =
      'Kembalian Tahap ' + lastBayar
    valueOtherBayar.innerHTML = values
  } else {
    valueOtherBayar.classList.add('d-none')
  }
}

function setItem (data) {
  if (data.length == 0) {
    document.getElementById(
      'kontenItem'
    ).innerHTML = `<div class="text-center mt-3">
    <img class="imgEmpty" src="${linkUrl}/Asset/Icon/empty-cart.svg" >
    <h6 class="mt-3">Tidak ada item yang dipilih</h6>
    </div>`
  } else {
    let values = ``
    for (let i = 0; i < data.length; i++) {
      // console.log(data[i]['Foto'])
      let foto = linkUrl + '/Asset/Icon/empty-image-produk.svg'
      if (data[i]['Foto'] != null) {
        foto = linkUrl + '/' + data[i]['Foto']
      }
      values += `<div class="row mt-3 custom-contain-item  p-2">
      <div class="col-lg-8 col-12">
                  <div class="d-flex bd-highlight">
                      <div class="p-2 flex-shrink-1 bd-highlight">
                          <img style="width: 70px;" class="img-thumbnail" src="${foto}" alt="">
                      </div>
                      <div class="p-2 w-100 bd-highlight">
                          <p class="mb-0 fw-bold mt-lg-2">${
                            data[i]['NamaProduk']
                          } - ${data[i]['Ukuran']}</p>
                          <p class="mb-lg-0 mb-2">Rp ${formatRupiah(
                            data[i]['Harga'] + ''
                          )} X ${data[i]['Item']} ${data[i]['Unit']}</p>
                      </div>
                  </div>
              </div>

              <div class="col-lg col ">
                  <div class="d-flex bd-highlight float-lg-start text-lg-start float-end text-end ">
                      <div class="p-2 w-100 bd-highlight ">
                          <p class="mb-0  mt-lg-2">Sub Total</p>
                          <p class="mb-0 fw-bold">Rp ${formatRupiah(
                            data[i]['Total'] + ''
                          )}</p>
                      </div>
                  </div>
              </div></div>`
    }
    document.getElementById('kontenItem').innerHTML = values
  }
}

function formatRupiah (angka) {
  if (angka == 0) {
    return ''
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

function setLog (data) {
  if (data.length == 0) {
  } else {
    let values = ''
    var options = {
      // weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }

    for (let i = 0; i < data.length; i++) {
      let today = new Date(data[i]['CreatedDate'])

      if (data[i]['Image'] == null) {
        values += `
              <div class="d-flex bd-highlight mt-2">
                  <div class="d-lg-none d-none custom-padding bd-highlight"><p class="text-muted custom-date">${today.toLocaleDateString(
                    'id-ID',
                    options
                  )} ${today.toLocaleTimeString('ru-RU', {
          timeZone: 'Asia/Jakarta',
          hourCycle: 'h23',

          hour: '2-digit',
          minute: '2-digit'
        })}</p></div>
                  <div class="customLeghty bd-highlight"></div>
                  <div class="custom-padding bd-highlight">
                      <p class="d-lg-block d-block text-muted custom-date">${today.toLocaleDateString(
                        'id-ID',
                        options
                      )} ${today.toLocaleTimeString('ru-RU', {
          timeZone: 'Asia/Jakarta',
          hourCycle: 'h23',

          hour: '2-digit',
          minute: '2-digit'
        })}</p>
                      <p class="mb-0 fw-bold">${data[i]['Description']}</p>
                  </div>
              </div>`
      } else {
        values += `
              <div class="d-flex bd-highlight mt-2">
                  <div class="d-lg-none d-none custom-padding bd-highlight"><p class="text-muted custom-date">${today.toLocaleDateString(
                    'id-ID',
                    options
                  )} ${today.toLocaleTimeString('ru-RU', {
          timeZone: 'Asia/Jakarta',
          hourCycle: 'h23',

          hour: '2-digit',
          minute: '2-digit'
        })}</p></div>
                  <div class="customLeghty bd-highlight"></div>
                  <div class="custom-padding bd-highlight">
                      <p class="d-lg-block d-block text-muted custom-date">${today.toLocaleDateString(
                        'id-ID',
                        options
                      )} ${today.toLocaleTimeString('ru-RU', {
          timeZone: 'Asia/Jakarta',
          hourCycle: 'h23',

          hour: '2-digit',
          minute: '2-digit'
        })}</p>
                      <p class="mb-0 fw-bold">${
                        data[i]['Description']
                      } (<a href="javascript:openBuktiTF('${
          data[i]['Image']
        }');">Bukti Pembayaran</a>)</p>
                  </div>
              </div>`
      }
    }
    document.getElementById('kontenlog').innerHTML = values
  }
}

// ezoom.onInit($('#imgTf'))

function openBuktiTF (link) {
  document.getElementById('imgTf').src = linkUrl + '/' + link
  let photo = [{ src: linkUrl + '/' + link, title: 'Image Caption 1' }]
  let option = {
    // Enable modal to drag
    draggable: false,

    // Enable modal to resize
    resizable: true,

    // Enable image to move
    movable: true,

    // Enable keyboard navigation
    keyboard: true,

    // Shows the title
    title: true,

    // Min width of modal
    modalWidth: 400,

    // Min height of modal
    modalHeight: 400,
    fixed: true,

    // Disable the image viewer maximized on init
    initMaximized: false,

    // Threshold of modal to browser window
    gapThreshold: 0.02,

    // Threshold of image ratio
    ratioThreshold: 0.1,

    // Min ratio of image when zoom out
    minRatio: 0.05,

    // Max ratio of image when zoom in
    maxRatio: 16,
    // Toolbar options in footer
    footerToolbar: [
      'zoomIn',
      'zoomOut',
      'prev',
      'fullscreen',
      'next',
      'actualSize',
      'rotateRight'
    ]
  }
  new PhotoViewer(photo, option)
}

document.getElementById('btnHutang').addEventListener('click', function () {
  $.ajax({
    url: linkUrl + 'C_transaction/getStatusTransPay',
    dataType: 'JSON',
    method: 'GET'
  }).done(result => {
    // console.log(result)
    if (result.status == 1) {
      if (transModif == result.lastModif) {
        modalPembayaranTrans.show()
      } else {
        document.getElementById('btnNonRelod').classList.remove('d-none')
        document.getElementById('btnReload').classList.add('d-none')
        document.getElementById('titleWarPay').innerHTML =
          'Transaksi Mengalami Perubahan'
        document.getElementById('subtitleWarPay').innerHTML =
          'Mohon untuk melakukan muat ulang pada halaman'
        modalWarningPayment.show()
      }
    } else if (result.status == 0) {
      document.getElementById('btnNonRelod').classList.remove('d-none')
      document.getElementById('btnReload').classList.add('d-none')
      document.getElementById('titleWarPay').innerHTML = result.title
      document.getElementById('subtitleWarPay').innerHTML = result.subtitle
      modalWarningPayment.show()
    } else if (result.status == 2) {
      document.getElementById('btnNonRelod').classList.add('d-none')
      document.getElementById('btnReload').classList.remove('d-none')
      document.getElementById('titleWarPay').innerHTML = result.title
      document.getElementById('subtitleWarPay').innerHTML = result.subtitle
      modalWarningPayment.show()
    }
  })
})

document.getElementById('btnReload').addEventListener('click', function () {
  window.location.reload()
})

document.getElementById('payments').addEventListener('change', function () {
  if (this.value == 0) {
    document.getElementById('content-bayar').classList.add('d-none')
  } else {
    document.getElementById('content-bayar').classList.remove('d-none')
  }
})

document.getElementById('batalPay').addEventListener('click', function () {
  resetPayment()
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

function resetPayment () {
  document.getElementById('content-bayar').classList.add('d-none')
  document.getElementById('payments').value = ''
  document.getElementById('nominalbayar').value = ''
  document.getElementById('nominalbayarHelp').classList.remove('d-block')
  document.getElementById('nominalbayar').classList.remove('is-invalid')
  document.getElementById('payments').classList.remove('is-invalid')
  document.getElementById('fileBuktiKirim').classList.remove('is-invalid')
  document.getElementById('fileBuktiKirim').value = ''
}

document.getElementById('nextPay').addEventListener('click', function () {
  let typePayment = document.getElementById('payments').value
  let nominal = document
    .getElementById('nominalbayar')
    .value.replaceAll('.', '')

  // let total = document.getElementById('total').innerHTML.split(' ')
  let ImageBUktiTF = document.getElementById('fileBuktiKirim').files[0]
  let formData = new FormData()
  // formData.append('idTrans', document.getElementById('idTrans').innerHTML)
  formData.append('typePayment', typePayment)
  formData.append('nominal', nominal)
  formData.append('ImageBUktiTF', ImageBUktiTF)
  // let kondisiNominal =
  // console.log(kondisiNominal)

  if (nominal == '') {
    sendToPayment(formData)
  } else if (sisaPembayaran == parseInt(nominal)) {
    formData.append('Kurang', 0)
    sendToPayment(formData)
  } else if (sisaPembayaran < parseInt(nominal)) {
    formData.append('Kurang', 0)
    sendToPayment(formData)
  } else if (sisaPembayaran > parseInt(nominal)) {
    formData.append('Kurang', 1)
    Swal.fire({
      title: 'Apakah anda yakin',
      text: 'Jika melanjutkan akan masuk daftar hutang!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Iya,Lanjut',
      cancelButtonText: 'Batal'
    }).then(result => {
      if (result.isConfirmed) {
        sendToPayment(formData)
      }
    })
  }
})

function sendToPayment (formData) {
  $.ajax({
    url: linkUrl + 'paymentTransactionDebt',
    method: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    dataType: 'JSON'
  }).done(result => {
    // console.log(result)
    let error = result.error
    let kondisi = result.kondisi
    if (kondisi == 3) {
      Swal.fire({
        icon: 'error',
        title: 'Session anda habis',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        window.location.href = linkUrl
      })
    } else if (kondisi == 2 || kondisi == 4) {
      Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan saat melanjutkan pembayaran',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {})
    } else if (kondisi == 1) {
      if (result.Jenis == 1) {
        Swal.fire({
          title: 'Pembayaran Berhasil',
          text: 'Pembayaran sudah dilakukan',
          icon: 'success',
          showCancelButton: false,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Okey'
        }).then(result => {
          if (result.isConfirmed) {
            window.location.reload()
          }
        })
      } else {
        modalPembayaranTrans.hide()
        modalSukses.show()

        // Swal.fire({
        //   title: 'Pembayaran Berhasil',
        //   text: 'Pembayaran sudah dilakukan',
        //   icon: 'success',
        //   showCancelButton: true,
        //   confirmButtonColor: '#3085d6',
        //   cancelButtonColor: '#d33',
        //   confirmButtonText: 'Cetak Nota',
        //   cancelButtonText: 'Kembali Menu Riwayat'
        // }).then(result => {
        //   if (result.isConfirmed) {
        //     let kode = document.getElementById('nota').innerHTML
        //     window.open(`${linkUrl}/Nota-Transaksi/${kode}`, '_blank')
        //   } else {
        //     window.location.href = linkUrl + 'Riwayat-Transaksi'
        //   }
        // })
      }
    } else {
      if (error.typePayment != null) {
        document.getElementById('payments').classList.add('is-invalid')
        document.getElementById('paymentsHelp').innerHTML = error.typePayment
      } else {
        document.getElementById('payments').classList.remove('is-invalid')
      }
      if (error.nominal != null) {
        document.getElementById('nominalbayar').classList.add('is-invalid')
        document.getElementById('nominalbayarHelp').innerHTML = error.nominal
        document.getElementById('nominalbayarHelp').classList.add('d-block')
      } else {
        document.getElementById('nominalbayarHelp').classList.remove('d-block')
        document.getElementById('nominalbayar').classList.remove('is-invalid')
      }
      if (error.ImageBUktiTF != null) {
        document.getElementById('fileBuktiKirim').classList.add('is-invalid')
        document.getElementById('fileBuktiKirimHelp').innerHTML =
          error.ImageBUktiTF
      } else {
        document.getElementById('fileBuktiKirim').classList.remove('is-invalid')
      }
    }
  })
}

// document.getElementById('cetakNota').addEventListener('click', function () {
//   let kode = NoTranss
//   window.open(`${linkUrl}/Nota-Transaksi/${kode}`, '_blank')
// })
document.getElementById('cetakNota').addEventListener('click', function () {
  let kode = NoTranss
  $.ajax({
    url:linkUrl+"C_Transaction/printCetakNow/"+kode,
    method:"GET"
  })
})
document.getElementById('download').addEventListener('click', function () {
  let kode = NoTranss
  window.open(`${linkUrl}/Nota-Transaksi/${kode}`, '_blank')
})
document.getElementById('prevRiwayat').addEventListener('click', function () {
  window.location.href = linkUrl + 'Riwayat-Transaksi'
})

document.getElementById('btnLog').addEventListener('click', function () {
  if (logs == 0) {
    logs = 1
    document.getElementById('iconLog').classList.remove('bi-chevron-down')
    document.getElementById('iconLog').classList.add('bi-chevron-up')
  } else {
    logs = 0
    document.getElementById('iconLog').classList.remove('bi-chevron-up')
    document.getElementById('iconLog').classList.add('bi-chevron-down')
  }
})

function gotoPay () {
  document.getElementById('paymentConten').scrollIntoView()
  // window.scrollTo(ele.offsetTop)
}
