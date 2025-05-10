let query = {
  query: 'm_product.Status = 1'
}
let modaladdPrice = new bootstrap.Modal(
  document.getElementById('modaladdPrice'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)

let detailproduct = new bootstrap.Modal(
  document.getElementById('detailproduct'),
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

let modalConfirmTransaction = new bootstrap.Modal(
  document.getElementById('modalPembayaranTrans'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let modaladdTrans = new bootstrap.Modal(
  document.getElementById('modaladdTrans'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let modallAddPelanggan = new bootstrap.Modal(
  document.getElementById('modallAddPelanggan'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let TypeCart = ''
let TransReal
let iti
let selectName
let btnSatuan = 'None'

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

let idProduct = 0
let tablehargakhusus = $('#tablehargakhusus').DataTable({
  responsive: true,
  pageLength: 10,
  ordering: false,
  searching: false,
  paging: false,
  info: false,
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
    infoEmpty: '',
    infoFiltered: '(disaring dari _MAX_ total entri)',
    zeroRecords: `<img style="width:150px; padding:20px" src="${linkUrl}Asset/Icon/serach-empty.svg"><p>Tidak ada data yang cocok ditemukan</p>`,
    emptyTable: `<img style="width:150px; margin-bottom:10px; margin-top:10px" src="${linkUrl}Asset/Icon/add-data-price.svg"><br><button class="btn btn-success mb-2 btnaddprice" id="btnaddprice">Tambah Harga Khusus</button>`
  }
})

let tableInprice = $('#tableaddprice').DataTable({
  responsive: true,
  pageLength: 10,
  ordering: false,
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
  }
})

document
  .getElementById('canceladdProduct')
  .addEventListener('click', function () {
    detailproduct.hide()
    //   modaladdPrice.show()
  })
document
  .getElementById('btncloseaddprice')
  .addEventListener('click', function () {
    detailproduct.show()
    modaladdPrice.hide()
  })
checkTransaction()

document.getElementById('demoNota').addEventListener('click', function () {
  modalSukses.show()
})

function setDefaultTransaksi (type, data) {
  if (type == 1) {
    document.getElementById('idTrans').innerHTML = '-'
    document.getElementById('dateTrans').innerHTML = '-'
    document.getElementById('kasirTrans').innerHTML = '-'
    document.getElementById('namapelanggan').innerHTML = '-'
    document.getElementById('subtotal').innerHTML = '0'
    document.getElementById('hutang').innerHTML = '0'
    document.getElementById('total').innerHTML = '0'
    document.getElementById('bataltrans').disabled = true
    document.getElementById('simpantrans').disabled = true
    document.getElementById('bayartrans').disabled = true
    document.getElementById('noneCart').classList.remove('d-none')
    document.getElementById('tableCart').classList.add('d-none')
    document.getElementById('listProduct').innerHTML = ''
    document.getElementById('emptyproduct').classList.remove('d-none')
    document.getElementById('tambahTransaksi').classList.remove('d-none')
    //   document.getElementById('listProduct').innerHTML = ''
    document.getElementById('IdCustomer').value = ''
    setDataBank()
  } else if (type == 2) {
    document.getElementById('idTrans').innerHTML = data.Number_Trans
    var options = {
      // weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }
    var today = new Date(data.CreatedDate)

    document.getElementById('dateTrans').innerHTML =
      today.toLocaleDateString('id-ID', options) +
      ` ${today.getHours()}:${today.getMinutes()}`
    document.getElementById('kasirTrans').innerHTML = data.NamaKasir
    document.getElementById('namapelanggan').innerHTML = data.NamaCustomer
    document.getElementById('subtotal').innerHTML =
      'Rp. ' + formatRupiah(data.Sub_Total)
    document.getElementById('hutang').innerHTML =
      'Rp. ' + formatRupiah(data.Total_Dept)
    document.getElementById('total').innerHTML =
      'Rp. ' + formatRupiah(data.Total_Payment)
    document.getElementById('bataltrans').disabled = false
    document.getElementById('simpantrans').disabled = false
    document.getElementById('bayartrans').disabled = false

    document.getElementById('IdCustomer').value = data.IdCustomer
    document.getElementById('listProduct').innerHTML = ''
    document.getElementById('emptyproduct').classList.remove('d-none')
    document.getElementById('tambahTransaksi').classList.add('d-none')
    setProduct()
    setCart(data.Id)
    TransReal = data
  } else if (type == 3) {
  }
}

function setCart (IdRTransaction) {
  let data = {
    Id: IdRTransaction
  }
  $.ajax({
    url: linkUrl + 'C_Transaction/getCart',
    method: 'POST',
    data: data,
    dataType: 'JSON'
  }).done(Hasil => {
    let result = Hasil.Data
    let Total = Hasil.Total
    let SubTotal = Hasil.SubTotal
    let Hutang = Hasil.Hutang
    let Tunda = Hasil.Tunda
    // console.log(result.length)
    if (result.length == 0) {
      document.getElementById('bayartrans').disabled = true

      document.getElementById('noneCart').classList.remove('d-none')
      document.getElementById('tableCart').classList.add('d-none')
    } else {
      let values = ``
      document.getElementById('bodytableCart').innerHTML = ''
      for (let i = 0; i < result.length; i++) {
        let Unit = 'PT'
        let Item = result[i].Sum_Product_PerPiece
        if (result[i].Unit_Product == 'Lusin') {
          Unit = 'LS'
          Item = result[i].Sum_Product_PerPiece / 12
        } else if (result[i].Unit_Product == 'Kodi') {
          Unit = 'KD'
          Item = result[i].Sum_Product_PerPiece / 20
        }
        let Status = `<span class="badge bg-success">Tersedia</span>`
        if (result[i].Status == 8) {
          Status = `<span class="badge bg-danger">Belum Tersedia</span>`
        }
        let td1 = `<td>
        <p class="fw-bold">${result[i].Name_Product}</p>
        <p class="text-muted sub-product-cart" style="margin-bottom:0px">Rp. ${formatRupiah(
          result[i].Price_Product
        )} x ${Item} ${Unit}</p>
        ${Status}
        </td>`
        let td2 = `<td>
        <p class="sub-total-cart">Rp. ${result[i].Total_Payment}</p>
        </td>`
        let td3 = `<td>
        <button class="btn btn-sm text-end sub-button-cart editCart" data-id="${result[i].Id}"><i class="bi bi-pen"></i></button>
        </td>`
        let tr = `<tr>${td1}${td2}${td3}</tr>`
        values += tr
      }
      document.getElementById('subtotal').innerHTML =
        'Rp. ' + formatRupiah(SubTotal + '')
      document.getElementById('hutang').innerHTML =
        'Rp. ' + formatRupiah(Hutang + '')
      document.getElementById('total').innerHTML =
        'Rp. ' + formatRupiah(Total + '')

      document.getElementById('bodytableCart').innerHTML = values
      document.getElementById('noneCart').classList.add('d-none')
      document.getElementById('tableCart').classList.remove('d-none')

      if (Tunda > 0) {
        document.getElementById('bayartrans').disabled = true
      }
    }
  })
}

function setProduct () {
  document.getElementById('listProduct').innerHTML = ''
  $.ajax({
    url: linkUrl + 'C_Product/getData',
    data: query,
    method: 'POST',
    dataType: 'JSON'
  }).done(result => {
    if (result.length > 0) {
      document.getElementById('emptyproduct').classList.add('d-none')
      let div = `<div class="row">`
      for (let i = 0; i < result.length; i++) {
        let img = linkUrl + '/Asset/Icon/empty-image-produk.svg'
        // console.log(result[i].Image)
        if (result[i].Image != null) {
          img = linkUrl + '/' + result[i].Image
        }
        let Stok = 'Stok Habis'
        let clasStok = 'text-danger'
        if (parseFloat(result[i].Stock) > parseFloat(result[i].Limit)) {
          // statusstos = 1
          Stok = `Stok Tersedia`
          clasStok = 'text-success'
        } else if (
          parseFloat(result[i].Stock) <= parseFloat(result[i].Limit) &&
          parseFloat(result[i].Stock) > 0
        ) {
          // statusstos = 2
          Stok = `Hampir Habis`
          clasStok = 'text-warning'
        } else if (parseFloat(result[i].Stock) <= 0) {
          // statusstos = 3
          Stok = `Habis`
          clasStok = 'text-danger'
        }
        let nama = result[i].Name.length
        let tempnama = result[i].Name
        if (nama.length > 17) {
          tempnama = ''
          for (let j = 0; j < 17; j++) {
            tempnama += nama[j]
          }
          tempnama += '...'
        }
        div += `<div class="col-lg-4 col-md-4 col-6 mt-2">
                <button class="btn w-100 text-start btn-list-product addCart" data-id="${result[i].Id}">
                    <img src="${img}" class="img-list-product" alt="">
                    <span class="badge bg-primary mt-1 size-list-product">${result[i].Size}</span>
                    <span class="badge bg-secondary mt-1 material-list-product2">${result[i].Jenis}</span>
                    <span class="badge bg-info mt-1 material-list-product2">${result[i].Bahan}</span>

                    <p class=" mt-1 fw-bold title-list-product">${tempnama}</p>
                     <p class=" ${clasStok} fw-bold price-list-product">
                   ${Stok}
                    </p>
                </button>
            </div>`
      }
      document.getElementById('listProduct').innerHTML = div + '</div>'
    } else {
      document.getElementById('emptyproduct').classList.remove('d-none')
      //   console.log(document.getElementById('emptyproduct').classList)
    }
  })
}

function checkTransaction () {
  $.ajax({
    url: linkUrl + 'C_Transaction/checkTransaction',
    // data: data,
    method: 'GET',
    dataType: 'JSON'
  }).done(result => {
    // console.log(result)
    if (result.length == 0) {
      setDefaultTransaksi(1, null)
    } else {
      setDefaultTransaksi(2, result[0])
    }
  })
}

function getCustomer () {
  document.getElementById('tempPelanggan').value = ''
  let dataQuery = {
    query: `m_customer.Status=1`
  }
  $.ajax({
    url: linkUrl + '/C_Pelanggan/getData',
    data: dataQuery,
    dataType: 'JSON'
  }).done(result => {
    $('#select-tools')
      .find('option')
      .remove()
      .end()
      .append('<option value="">Pilih Pelanggan...</option>')
      .val('')
    let datass = []
    for (let i = 0; i < result.length; i++) {
      let pelanggans = document.getElementById('select-tools')
      let option = document.createElement('option')
      let temp = {
        id: result[i].Id,
        title: result[i].Name
      }
      datass.push(temp)
      //   option.text = result[i].Name
      //   option.title = result[i].Name
      //   option.value = result[i].Id
      //   pelanggans.add(option)
    }
    selectName = $('#select-tools').selectize({
      maxItems: 1,
      valueField: 'id',
      labelField: 'title',
      searchField: 'title',
      options: datass,
      create: false,
      onChange: function (value) {
        document.getElementById('tempPelanggan').value = value

        if (value[0] != '') {
          CheckHutang(value[0])
          checkSavingTrans(value[0])
        } else {
          document.getElementById('tempHutang').value = 0
          document.getElementById('tempSaving').value = 0
        }
      }
    })
  })
}

function checkSavingTrans (Id) {
  let data = {
    query: `t_transaction_manual.IdCustomer = '${Id}' AND t_transaction_manual.Status= 2`
  }
  $.ajax({
    url: linkUrl + '/C_Transaction/getTransaction',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(result => {
    // console.log(result)
    if (result.length > 0) {
      document.getElementById('tempSaving').value = 1
    } else {
      document.getElementById('tempSaving').value = 0
    }
  })
}

function CheckHutang (id) {
  let data = {
    query: `t_transaction_manual.IdCustomer = '${id}' AND t_transaction_manual.Status= 5`
  }
  $.ajax({
    url: linkUrl + '/C_Transaction/getTransaction',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(result => {
    if (result.length > 0) {
      document.getElementById('tempHutang').value = result[0].Id
    } else {
      document.getElementById('tempHutang').value = 0
    }
  })
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
function isNumberKey (angka, evt) {
  // var charCode = evt.which ? evt.which : evt.keyCode
  // if (charCode > 31 && (charCode < 48 || charCode > 57)) {
  //   return false
  // } else {
  angka.value = formatRupiah(angka.value)
  //   return true
  // }
}

document.getElementById('inputserch').addEventListener('keyup', function () {
  query = {
    query: `m_product.Status=1 AND (m_product.Name LIKE '%${this.value}%' OR m_material_product.Name LIKE '%${this.value}%' OR m_type_produk.Name LIKE '%${this.value}%')`
  }
  setProduct()
})

$(document).on('click', '.addCart', function () {
  let id = $(this).data('id')
  idProduct = id
  let datas = {
    query: `m_product.Id=${id}`
  }
  //   console.log(datas)

  $.ajax({
    url: linkUrl + 'C_Product/getData',
    data: datas,
    method: 'POST',
    dataType: 'JSON'
  }).done(result => {
    let dt = result[0]
    // console.log(dt)
    TypeCart = 'Add'
    let img = linkUrl + '/Asset/Icon/empty-image-produk.svg'
    // console.log(result[i].Image)
    if (dt.Image != null) {
      img = linkUrl + '/' + dt.Image
    }
    document.getElementById('detailImage').src = img

    document.getElementById('addTocart').classList.remove('d-none')
    document.getElementById('btnCart').classList.add('d-none')
    document.getElementById('titleProductM').innerHTML = dt.Name
    document.getElementById('sizeM').innerHTML = dt.Size
    document.getElementById('jenisM').innerHTML = dt.Jenis
    document.getElementById('bahanM').innerHTML = dt.Bahan
    document.getElementById('potongM').innerHTML =
      'Rp. ' + formatRupiah(dt.Per_Piece + '')
    document.getElementById('lusinM').innerHTML =
      'Rp. ' + formatRupiah(dt.Per_Doze + '')
    document.getElementById('kodiM').innerHTML =
      'Rp. ' + formatRupiah(dt.Per_Kodi + '')
    let Stok = `<span class="badge bg-success">Tersedia</span>`

    document.getElementById('btnKodi').classList.remove('d-none')
    document.getElementById('btnPotong').classList.remove('d-none')
    document.getElementById('btnLusin').classList.remove('d-none')

    if (dt.Per_Piece == 0) {
      document.getElementById('btnPotong').classList.add('d-none')
    }
    if (dt.Per_Doze == 0) {
      document.getElementById('btnLusin').classList.add('d-none')
    }

    if (dt.Per_Kodi == 0) {
      document.getElementById('btnKodi').classList.add('d-none')
    }

    if (parseFloat(dt.Stock) > parseFloat(dt.Limit)) {
      // statusstos = 1
      Stok = `<span class="badge bg-success">Tersedia</span>`
    } else if (
      parseFloat(dt.Stock) <= parseFloat(dt.Limit) &&
      parseFloat(dt.Stock) > 0
    ) {
      // statusstos = 2
      Stok = `<span class="badge bg-warning">Hampir Habis</span>`
    } else if (parseFloat(dt.Stock) <= 0) {
      // statusstos = 3
      Stok = `<span class="badge bg-danger">Habis</span>`
    }
    document.getElementById('tempIDProduct').value = dt.Id
    cekHargaKhusu(dt.Id)
    document.getElementById('stokM').innerHTML =
      formatRupiah(dt.Stock) + '/' + dt.singkatan + ' ' + Stok
  })
  document.getElementById('statusPersedian').innerHTML = ''

  document.getElementById('btnMinus').disabled = true
  document.getElementById('inputItem').value = '1'
  resizeInputItem(1 + '')
  btnSatuan = 'None'
  document.getElementById('btnPotong').classList.remove('btn-primary')
  document.getElementById('btnPotong').classList.add('btn-outline-primary')
  document.getElementById('btnLusin').classList.remove('btn-primary')
  document.getElementById('btnLusin').classList.add('btn-outline-primary')
  document.getElementById('btnKodi').classList.remove('btn-primary')
  document.getElementById('btnKodi').classList.add('btn-outline-primary')
  detailproduct.show()
})
$(document).on('click', '.editCart', function () {
  let id = $(this).data('id')
  document.getElementById('IdDetailTrans').value = id
  TypeCart = 'Edit'
  document.getElementById('btnCart').classList.remove('d-none')
  document.getElementById('addTocart').classList.add('d-none')
  let data = {
    query: `Id = '${id}'`
  }

  $.ajax({
    url: linkUrl + 'C_Transaction/EditCart',
    data: data,
    dataType: 'JSON',
    method: 'POST'
  }).done(result => {
    let dt = result.Produk
    let Trans = result.TranSaction

    let img = linkUrl + '/Asset/Icon/empty-image-produk.svg'
    // console.log(result[i].Image)
    if (dt.Image != null) {
      img = linkUrl + '/' + dt.Image
    }
    document.getElementById('detailImage').src = img

    document.getElementById('titleProductM').innerHTML = dt.Name
    document.getElementById('sizeM').innerHTML = dt.Size
    document.getElementById('jenisM').innerHTML = dt.Jenis
    document.getElementById('bahanM').innerHTML = dt.Bahan
    document.getElementById('potongM').innerHTML =
      'Rp. ' + formatRupiah(dt.Per_Piece + '')
    document.getElementById('lusinM').innerHTML =
      'Rp. ' + formatRupiah(dt.Per_Doze + '')
    document.getElementById('kodiM').innerHTML =
      'Rp. ' + formatRupiah(dt.Per_Kodi + '')
    let Stok = `<span class="badge bg-success">Tersedia</span>`
    if (dt.Per_Piece == 0) {
      document.getElementById('btnPotong').classList.add('d-none')
    }
    if (dt.Per_Doze == 0) {
      document.getElementById('btnLusin').classList.add('d-none')
    }

    if (dt.Per_Kodi == 0) {
      document.getElementById('btnKodi').classList.add('d-none')
    }

    if (parseFloat(dt.Stock) > parseFloat(dt.Limit)) {
      // statusstos = 1
      Stok = `<span class="badge bg-success">Tersedia</span>`
    } else if (
      parseFloat(dt.Stock) <= parseFloat(dt.Limit) &&
      parseFloat(dt.Stock) > 0
    ) {
      // statusstos = 2
      Stok = `<span class="badge bg-warning">Hampir Habis</span>`
    } else if (parseFloat(dt.Stock) <= 0) {
      // statusstos = 3
      Stok = `<span class="badge bg-danger">Habis</span>`
    }
    document.getElementById('tempIDProduct').value = dt.Id
    cekHargaKhusu(dt.Id)
    document.getElementById('stokM').innerHTML =
      formatRupiah(dt.Stock) + '/' + dt.singkatan + ' ' + Stok
    let piece = 1
    if (Trans.Unit_Product == 'Potong') {
      btnSatuan = 'Potong'
      document
        .getElementById('btnPotong')
        .classList.remove('btn-outline-primary')
      document.getElementById('btnPotong').classList.add('btn-primary')
      document.getElementById('btnLusin').classList.remove('btn-primary')
      document.getElementById('btnLusin').classList.add('btn-outline-primary')
      document.getElementById('btnKodi').classList.remove('btn-primary')
      document.getElementById('btnKodi').classList.add('btn-outline-primary')
    } else if (Trans.Unit_Product == 'Lusin') {
      piece = 12
      btnSatuan = 'Lusin'
      document.getElementById('btnPotong').classList.remove('btn-primary')
      document.getElementById('btnPotong').classList.add('btn-outline-primary')
      document
        .getElementById('btnLusin')
        .classList.remove('btn-outline-primary')
      document.getElementById('btnLusin').classList.add('btn-primary')
      document.getElementById('btnKodi').classList.remove('btn-primary')
      document.getElementById('btnKodi').classList.add('btn-outline-primary')
    } else if (Trans.Unit_Product == 'Kodi') {
      piece = 20
      btnSatuan = 'Kodi'
      document.getElementById('btnPotong').classList.remove('btn-primary')
      document.getElementById('btnPotong').classList.add('btn-outline-primary')
      document.getElementById('btnLusin').classList.remove('btn-primary')
      document.getElementById('btnLusin').classList.add('btn-outline-primary')
      document.getElementById('btnKodi').classList.remove('btn-outline-primary')
      document.getElementById('btnKodi').classList.add('btn-primary')
    }
    let SUMPIECE = Trans.Sum_Product_PerPiece / piece

    if (parseInt(dt.Stock_Piece) >= parseInt(Trans.Sum_Product_PerPiece)) {
      document.getElementById('statusPersedian').innerHTML = 'Tersedia'
    } else {
      document.getElementById('statusPersedian').innerHTML =
        'Stok Kurang ' +
        (Trans.Sum_Product_PerPiece - dt.Stock_Piece) +
        ' Potong'
    }

    document.getElementById('btnMinus').disabled = false
    document.getElementById('inputItem').value = SUMPIECE
    resizeInputItem(SUMPIECE + '0')
  })
  detailproduct.show()
})

function setEditProduct (id) {}
function cekHargaKhusu (IdProduk) {
  let IdCUstomer = document.getElementById('IdCustomer').value
  let data = {
    query: `m_customer_price_product.Id_Product = ${IdProduk} AND m_customer_price_product.Id_Customer = '${IdCUstomer}'`
  }
  let dataProduk = {
    query: `m_product.Id=${IdProduk}`
  }

  $.ajax({
    url: linkUrl + 'C_Product/getPriceCustomeTrans',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(result => {
    tablehargakhusus.clear().draw()
    if (result.length > 0) {
      document.getElementById('tambahHargaKhusus').classList.add('d-none')
      document.getElementById('hargaKhusus').classList.remove('d-none')
      if (result[0].StatusHarga == 1) {
        $.ajax({
          url: linkUrl + 'C_Product/getData',
          data: dataProduk,
          method: 'POST',
          dataType: 'JSON'
        }).done(hasilProduk => {
          document.getElementById(
            'potongM'
          ).innerHTML = `<span class="text-decoration-line-through" style="font-size:10pt;">Rp. ${formatRupiah(
            hasilProduk[0].Per_Piece + ''
          )}</span> <span>Rp. ${formatRupiah(result[0].Potong)}</span>`
          document.getElementById(
            'lusinM'
          ).innerHTML = `<span class="text-decoration-line-through" style="font-size:10pt;">Rp. ${formatRupiah(
            hasilProduk[0].Per_Doze
          )}</span> <span>Rp. ${formatRupiah(result[0].Lusin)}</span>`
          document.getElementById(
            'kodiM'
          ).innerHTML = `<span class="text-decoration-line-through" style="font-size:10pt;">Rp. ${formatRupiah(
            hasilProduk[0].Per_Kodi
          )}</span> <span>Rp. ${formatRupiah(result[0].Kodi)}</span>`
        })
        document.getElementById('hargaKhusus').classList.add('btn-danger')
        document.getElementById('hargaKhusus').classList.remove('btn-secondary')
        document.getElementById('statusHargaKhusus').classList.add('d-none')
      } else {
        document.getElementById('hargaKhusus').classList.remove('btn-danger')
        document.getElementById('hargaKhusus').classList.add('btn-secondary')

        document.getElementById('statusHargaKhusus').classList.remove('d-none')
      }
      document.getElementById('hargaKhusus').innerHTML =
        `<i class="bi bi-x-circle"></i> ` + result[0].NamaHarga
      document.getElementById('idTempIdPrice').value = result[0].IdPrice
      document.getElementById('IdTempMemberPrice').value = result[0].Id
    } else {
      $.ajax({
        url: linkUrl + 'C_Product/getData',
        data: dataProduk,
        method: 'POST',
        dataType: 'JSON'
      }).done(hasilProduk => {
        document.getElementById('potongM').innerHTML = `Rp. ${formatRupiah(
          hasilProduk[0].Per_Piece
        )}`
        document.getElementById('lusinM').innerHTML = `Rp. ${formatRupiah(
          hasilProduk[0].Per_Doze
        )}`
        document.getElementById('kodiM').innerHTML = `Rp. ${formatRupiah(
          hasilProduk[0].Per_Kodi
        )}`
      })

      document.getElementById('tambahHargaKhusus').classList.remove('d-none')
      document.getElementById('hargaKhusus').classList.add('d-none')
      document.getElementById('statusHargaKhusus').classList.add('d-none')
      document.getElementById('idTempIdPrice').value = 0
      document.getElementById('IdTempMemberPrice').value = 0
    }
  })
}
document.getElementById('hargaKhusus').addEventListener('click', function () {
  let data = {
    Id: document.getElementById('IdTempMemberPrice').value
  }
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menghapus harga khusus akan mempengaruhi pada transaksi yang berjalan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Hapus',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: linkUrl + 'C_Product/DeleteMemberPrice',
        data: data,
        method: 'POST',
        dataType: 'JSON'
      }).done(hasil => {
        if (hasil == 1) {
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil terhapus',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            cekHargaKhusu(document.getElementById('tempIDProduct').value)
          })
        } else if (hasil == 0) {
          Swal.fire({
            icon: 'error',
            title: 'Data tidak terhapus',
            showConfirmButton: false,
            timer: 1500
          }).then(result => {
            cekHargaKhusu(document.getElementById('tempIDProduct').value)
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

$(document).on('click', '.btnaddprice', function () {
  setHargaKhusus()
  detailproduct.hide()
  modaladdPrice.show()
})
document
  .getElementById('tambahHargaKhusus')
  .addEventListener('click', function () {
    setHargaKhusus()
    detailproduct.hide()
    modaladdPrice.show()
  })
$(document).on('click', '.addHargaKhusus', function () {
  let id = $(this).data('id')

  let Data = {
    IdCustomer: document.getElementById('IdCustomer').value,
    IdPriceProduct: id,
    IdProduct: document.getElementById('tempIDProduct').value
  }
  $.ajax({
    url: linkUrl + '/C_Product/AddMemberPriceTrans',
    data: Data,
    method: 'POST',
    dataType: 'JSON'
  }).done(hasil => {
    if (hasil == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        detailproduct.show()
        modaladdPrice.hide()
        cekHargaKhusu(document.getElementById('tempIDProduct').value)
      })
    } else if (hasil == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        detailproduct.show()
        modaladdPrice.hide()
        cekHargaKhusu(document.getElementById('tempIDProduct').value)
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
})

function setHargaKhusus () {
  let Data = {
    query: `m_price_product.Id_Product = ${
      document.getElementById('tempIDProduct').value
    } AND m_price_product.Status = 1`
  }

  $.ajax({
    url: linkUrl + '/C_Product/getPriceProductTrans',
    method: 'POST',
    data: Data,
    dataType: 'JSON'
  }).done(result => {
    tableInprice.clear().draw()

    for (let i = 0; i < result.length; i++) {
      let Buttons = `<button data-id="${result[i].Id}" title="Tambah Harga Khusus" class="btn btn-success btn-sm addHargaKhusus" ><i class="bi bi-plus"></i></button>`

      tableInprice.row
        .add([
          result[i].Name,
          'Rp ' + formatRupiah(result[i].Per_Piece),
          'Rp ' + formatRupiah(result[i].Per_Dozen),
          'Rp ' + formatRupiah(result[i].Per_Kodi),
          Buttons
        ])
        .draw()
    }
  })
}

document
  .getElementById('btntambahtransaksi')
  .addEventListener('click', function () {
    getCustomer()
    modaladdTrans.show()
  })
document.getElementById('bataladdTrans').addEventListener('click', function () {
  modaladdTrans.hide()
  selectName[0].selectize.clear()
})
document
  .getElementById('btnAddPelanggan')
  .addEventListener('click', function () {
    modaladdTrans.hide()
    modallAddPelanggan.show()
  })
document
  .getElementById('bataladdPelanggan')
  .addEventListener('click', function () {
    modaladdTrans.show()
    modallAddPelanggan.hide()
  })
document
  .getElementById('simpanaddPelanggan')
  .addEventListener('click', function () {
    let data = {
      Name: document.getElementById('NameCus').value,
      Telephone: iti.getNumber(intlTelInputUtils.numberFormat.E164),
      CountryTelephone: iti.getSelectedCountryData().iso2,
      Address: document.getElementById('address').value
    }

    $.ajax({
      url: linkUrl + '/SavePelangganTransaksi',
      data: data,
      method: 'POST',
      dataType: 'JSON'
    }).done(result => {
      let Error = result.error
      let Kondisi = result.kondisi
      if (Kondisi == 0) {
        if (Error.Name != null) {
          document.getElementById('NameCusHelp').innerHTML = Error.Name
          document.getElementById('NameCus').classList.add('is-invalid')
        } else {
          document.getElementById('NameCus').classList.remove('is-invalid')
        }
        if (Error.Address != null) {
          document.getElementById('addressHelp').innerHTML = Error.Address
          document.getElementById('address').classList.add('is-invalid')
        } else {
          document.getElementById('address').classList.remove('is-invalid')
        }
        if (Error.Telephone != null) {
          document.getElementById('telefonHelp').innerHTML = Error.Name
          document.getElementById('Telephone').classList.add('is-invalid')
        } else {
          document.getElementById('Telephone').classList.remove('is-invalid')
        }
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
          modaladdTrans.show()
          modallAddPelanggan.hide()
          getCustomer()
        })
      }
    })
  })

document.getElementById('btnAddTrans').addEventListener('click', function () {
  let Pelanggan = document.getElementById('tempPelanggan').value
  let hutang = document.getElementById('tempHutang').value
  let savingTrans = document.getElementById('tempSaving').value
  if (Pelanggan == '') {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Harap pilih nama pelanggan'
    })
  } else {
    // console.log(savingTrans)
    if (savingTrans == '0') {
      if (hutang == '0') {
        let data = {
          Pelanggan: Pelanggan,
          Hutang: 0
        }
        addTransaksiNew(data)
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Apakah anda yakin',
          text: 'Menambahkan dan melanjutkan transaksi ini dengan hutang sebelumnya ?',
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonText: 'Lanjut dengan menambah hutang',
          denyButtonText: `Lanjut tanpa menambah hutang`,
          cancelButtonText: `Batal`
        }).then(result => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            let data = {
              Pelanggan: Pelanggan,
              Hutang: 1
            }
            addTransaksiNew(data)
          } else if (result.isDenied) {
            let data = {
              Pelanggan: Pelanggan,
              Hutang: 0
            }
            addTransaksiNew(data)
          }
        })
      }
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Harap selesaikan dahulu transaksi yang sedang berlangsung'
      })
    }
  }
})

function addTransaksiNew (data) {
  // $.ajax({
  //   url: linkUrl + 'addTransaksi',
  //   method: 'POST',
  //   data: data,
  //   dataType: 'JSON'
  // }).done(result => {
  //   console.log(result)
  // })
  $.ajax({
    url: linkUrl + 'addTransaksi',
    method: 'POST',
    data: data,
    dataType: 'JSON'
  }).done(result => {
    let kondisi = result.kondisi
    let transData = result.data
    if (kondisi == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        modaladdTrans.hide()
        selectName[0].selectize.clear()
        checkTransaction()
      })
    } else if (kondisi == 2) {
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
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      })
    }
  })
}

document.getElementById('btnMinus').addEventListener('click', function () {
  let item = parseInt(document.getElementById('inputItem').value)
  item = item - 1
  if (item == 1) {
    document.getElementById('btnMinus').disabled = true
  }
  let stokArray = document.getElementById('stokM').innerHTML.split('/')
  let stok = parseInt(stokArray[0].replaceAll('.', ''))
  let jenisSatuan = 1
  if (btnSatuan == 'Lusin') {
    jenisSatuan = 12
  } else if (btnSatuan == 'Kodi') {
    jenisSatuan = 20
  } else {
    jenisSatuan = 1
  }
  let resultStok = item * jenisSatuan
  let textStok = 'Tersedia'
  if (stok >= resultStok) {
    textStok = 'Tersedia'
  } else if (stok < resultStok) {
    textStok = 'Stok Kurang ' + (resultStok - stok) + ' Potong'
  }
  if (btnSatuan != 'None') {
    document.getElementById('statusPersedian').innerHTML = textStok
  } else {
    document.getElementById('statusPersedian').innerHTML = ''
  }

  document.getElementById('inputItem').value = item
  resizeInputItem(item + '')
})
document.getElementById('btnPlus').addEventListener('click', function () {
  let item = parseInt(document.getElementById('inputItem').value)
  item = item + 1
  if (item > 1) {
    document.getElementById('btnMinus').disabled = false
  }
  let stokArray = document.getElementById('stokM').innerHTML.split('/')
  let stok = parseInt(stokArray[0].replaceAll('.', ''))
  let jenisSatuan = 1
  if (btnSatuan == 'Lusin') {
    jenisSatuan = 12
  } else if (btnSatuan == 'Kodi') {
    jenisSatuan = 20
  } else {
    jenisSatuan = 1
  }
  let resultStok = item * jenisSatuan
  let textStok = 'Tersedia'
  if (stok >= resultStok) {
    textStok = 'Tersedia'
  } else if (stok < resultStok) {
    textStok = 'Stok Kurang ' + (resultStok - stok) + ' Potong'
  }
  if (btnSatuan != 'None') {
    document.getElementById('statusPersedian').innerHTML = textStok
  } else {
    document.getElementById('statusPersedian').innerHTML = ''
  }

  document.getElementById('inputItem').value = item
  resizeInputItem(item + '')
})

document.getElementById('btnPotong').addEventListener('click', function () {
  if (btnSatuan == 'None') {
    btnSatuan = 'Potong'
    document.getElementById('btnPotong').classList.remove('btn-outline-primary')
    document.getElementById('btnPotong').classList.add('btn-primary')
  } else if (btnSatuan == 'Potong') {
    btnSatuan = 'None'
    document.getElementById('btnPotong').classList.remove('btn-primary')
    document.getElementById('btnPotong').classList.add('btn-outline-primary')
  } else {
    btnSatuan = 'Potong'
    document.getElementById('btnPotong').classList.remove('btn-outline-primary')
    document.getElementById('btnPotong').classList.add('btn-primary')
    document.getElementById('btnLusin').classList.remove('btn-primary')
    document.getElementById('btnLusin').classList.add('btn-outline-primary')
    document.getElementById('btnKodi').classList.remove('btn-primary')
    document.getElementById('btnKodi').classList.add('btn-outline-primary')
  }
  let item = parseInt(document.getElementById('inputItem').value)

  let stokArray = document.getElementById('stokM').innerHTML.split('/')
  let stok = parseInt(stokArray[0].replaceAll('.', ''))
  let jenisSatuan = 1
  if (btnSatuan == 'Lusin') {
    jenisSatuan = 12
  } else if (btnSatuan == 'Kodi') {
    jenisSatuan = 20
  } else {
    jenisSatuan = 1
  }
  let resultStok = item * jenisSatuan
  let textStok = 'Tersedia'
  if (stok >= resultStok) {
    textStok = 'Tersedia'
  } else if (stok < resultStok) {
    textStok = 'Stok Kurang ' + (resultStok - stok) + ' Potong'
  }
  if (btnSatuan != 'None') {
    document.getElementById('statusPersedian').innerHTML = textStok
  } else {
    document.getElementById('statusPersedian').innerHTML = ''
  }
})
document.getElementById('btnLusin').addEventListener('click', function () {
  if (btnSatuan == 'None') {
    btnSatuan = 'Lusin'
    document.getElementById('btnLusin').classList.remove('btn-outline-primary')
    document.getElementById('btnLusin').classList.add('btn-primary')
  } else if (btnSatuan == 'Lusin') {
    btnSatuan = 'None'
    document.getElementById('btnLusin').classList.remove('btn-primary')
    document.getElementById('btnLusin').classList.add('btn-outline-primary')
  } else {
    btnSatuan = 'Lusin'
    document.getElementById('btnPotong').classList.remove('btn-primary')
    document.getElementById('btnPotong').classList.add('btn-outline-primary')
    document.getElementById('btnLusin').classList.remove('btn-outline-primary')
    document.getElementById('btnLusin').classList.add('btn-primary')
    document.getElementById('btnKodi').classList.remove('btn-primary')
    document.getElementById('btnKodi').classList.add('btn-outline-primary')
  }
  let item = parseInt(document.getElementById('inputItem').value)

  let stokArray = document.getElementById('stokM').innerHTML.split('/')
  let stok = parseInt(stokArray[0].replaceAll('.', ''))
  let jenisSatuan = 1
  if (btnSatuan == 'Lusin') {
    jenisSatuan = 12
  } else if (btnSatuan == 'Kodi') {
    jenisSatuan = 20
  } else {
    jenisSatuan = 1
  }
  let resultStok = item * jenisSatuan
  let textStok = 'Tersedia'
  if (stok >= resultStok) {
    textStok = 'Tersedia'
  } else if (stok < resultStok) {
    textStok = 'Stok Kurang ' + (resultStok - stok) + ' Potong'
  }
  if (btnSatuan != 'None') {
    document.getElementById('statusPersedian').innerHTML = textStok
  } else {
    document.getElementById('statusPersedian').innerHTML = ''
  }
})
document.getElementById('btnKodi').addEventListener('click', function () {
  if (btnSatuan == 'None') {
    btnSatuan = 'Kodi'
    document.getElementById('btnKodi').classList.remove('btn-outline-primary')
    document.getElementById('btnKodi').classList.add('btn-primary')
  } else if (btnSatuan == 'Kodi') {
    btnSatuan = 'None'
    document.getElementById('btnKodi').classList.remove('btn-primary')
    document.getElementById('btnKodi').classList.add('btn-outline-primary')
  } else {
    btnSatuan = 'Kodi'
    document.getElementById('btnPotong').classList.remove('btn-primary')
    document.getElementById('btnPotong').classList.add('btn-outline-primary')
    document.getElementById('btnLusin').classList.remove('btn-primary')
    document.getElementById('btnLusin').classList.add('btn-outline-primary')
    document.getElementById('btnKodi').classList.remove('btn-outline-primary')
    document.getElementById('btnKodi').classList.add('btn-primary')
  }
  let item = parseInt(document.getElementById('inputItem').value)

  let stokArray = document.getElementById('stokM').innerHTML.split('/')
  let stok = parseInt(stokArray[0].replaceAll('.', ''))
  let jenisSatuan = 1
  if (btnSatuan == 'Lusin') {
    jenisSatuan = 12
  } else if (btnSatuan == 'Kodi') {
    jenisSatuan = 20
  } else {
    jenisSatuan = 1
  }
  let resultStok = item * jenisSatuan
  let textStok = 'Tersedia'
  if (stok >= resultStok) {
    textStok = 'Tersedia'
  } else if (stok < resultStok) {
    textStok = 'Stok Kurang ' + (resultStok - stok) + ' Potong'
  }
  if (btnSatuan != 'None') {
    document.getElementById('statusPersedian').innerHTML = textStok
  } else {
    document.getElementById('statusPersedian').innerHTML = ''
  }
})
document.getElementById('addTocart').addEventListener('click', function () {
  let items = document.getElementById('inputItem').value
  if (items == '') {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Pilih jumlah barang diisi dahulu...'
    })
  } else if (btnSatuan == 'None') {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Pilih jenis satuan dahulu...'
    })
  } else {
    let datas = {
      idTrans: document.getElementById('idTrans').innerHTML,
      IdProduct: document.getElementById('tempIDProduct').value,
      IdProductPrice: document.getElementById('idTempIdPrice').value,
      Satuan: btnSatuan,
      Jumlah: document.getElementById('inputItem').value
    }
    let checkData = document
      .getElementById('statusPersedian')
      .innerHTML.split('Kurang')
    if (checkData.length > 1) {
      Swal.fire({
        title: 'Apakah anda yakin',
        text: 'Memasukan keranjang dengan stok tidak sesuai',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Batal'
      }).then(result => {
        if (result.isConfirmed) {
          insertIntoCart(datas)
        }
      })
    } else {
      if (TypeCart == 'Add') {
        insertIntoCart(datas)
      }
    }
  }
})

document.getElementById('UpdateTocart').addEventListener('click', function () {
  let items = document.getElementById('inputItem').value
  if (items == '') {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Pilih jumlah barang diisi dahulu...'
    })
  } else if (btnSatuan == 'None') {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Pilih jenis satuan dahulu...'
    })
  } else {
    let datas = {
      idTrans: document.getElementById('idTrans').innerHTML,
      IdTransDetail: document.getElementById('IdDetailTrans').value,
      IdProduct: document.getElementById('tempIDProduct').value,
      // IdProductPrice: document.getElementById('idTempIdPrice').value,
      Satuan: btnSatuan,
      Jumlah: document.getElementById('inputItem').value
    }
    let checkData = document
      .getElementById('statusPersedian')
      .innerHTML.split('Kurang')
    if (checkData.length > 1) {
      Swal.fire({
        title: 'Apakah anda yakin',
        text: 'Memasukan keranjang dengan stok tidak sesuai',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Batal'
      }).then(result => {
        if (result.isConfirmed) {
          UpdateCart(datas)
        }
      })
    } else {
      if (TypeCart != 'Add') {
        UpdateCart(datas)
      }
    }
  }
})

function insertIntoCart (data) {
  // $.ajax({
  //   url: linkUrl + 'addToCart',
  //   data: data,
  //   method: 'POST',
  //   dataType: 'JSON'
  // }).done(hasil => {
  //   console.log(hasil)
  // })
  $.ajax({
    url: linkUrl + 'addToCart',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(hasil => {
    if (hasil == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        detailproduct.hide()
        setProduct()
        checkTransaction()
      })
    } else if (hasil == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        //
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

document.getElementById('CancelTocart').addEventListener('click', function () {
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menghapus produk pada keranjang!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya, Hapus',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      let datas = {
        idTrans: document.getElementById('idTrans').innerHTML,
        IdTransDetail: document.getElementById('IdDetailTrans').value
      }
      deleteToCart(datas)
    }
  })
})
function deleteToCart (data) {
  $.ajax({
    url: linkUrl + 'deleteToCart',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(hasil => {
    if (hasil == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil terhapus',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        setProduct()
        detailproduct.hide()
        checkTransaction()
      })
    } else if (hasil == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak terhapus',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        checkTransaction()
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

function UpdateCart (data) {
  // console.log(data)
  // $.ajax({
  //   url: linkUrl + 'updateToCart',
  //   data: data,
  //   method: 'POST',
  //   dataType: 'JSON'
  // }).done(hasil => {
  //   console.log(hasil)
  // })

  $.ajax({
    url: linkUrl + 'updateToCart',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(hasil => {
    if (hasil == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        setProduct()
        detailproduct.hide()
        checkTransaction()
      })
    } else if (hasil == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Data tidak tersimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        //
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

document.getElementById('bataltrans').addEventListener('click', function () {
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Membatalkan transaksi yang sedang berlangsung!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      let datas = {
        idTrans: document.getElementById('idTrans').innerHTML
      }
      cancelTransaction(datas)
    }
  })
})

function cancelTransaction (data) {
  // $.ajax({
  //   url: linkUrl + 'cancelTrasaction',
  //   data: data,
  //   method: 'POST',
  //   dataType: 'JSON'
  // }).done(result => {
  //   console.log(result)
  // })
  $.ajax({
    url: linkUrl + 'cancelTrasaction',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(hasil => {
    if (hasil == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Transaksi berhasil dibatalkan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        checkTransaction()
      })
    } else if (hasil == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Transaksi tidak berhasil dibatalkan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        checkTransaction()
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

document.getElementById('simpantrans').addEventListener('click', function () {
  Swal.fire({
    title: 'Apakah anda yakin',
    text: 'Menyimpan transaksi yang sedang berlangsung!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Iya',
    cancelButtonText: 'Batal'
  }).then(result => {
    if (result.isConfirmed) {
      let datas = {
        idTrans: document.getElementById('idTrans').innerHTML
      }
      saveTransactions(datas)
    }
  })
})
function saveTransactions (data) {
  // $.ajax({
  //   url: linkUrl + 'cancelTrasaction',
  //   data: data,
  //   method: 'POST',
  //   dataType: 'JSON'
  // }).done(result => {
  //   console.log(result)
  // })
  $.ajax({
    url: linkUrl + 'savingTrasaction',
    data: data,
    method: 'POST',
    dataType: 'JSON'
  }).done(hasil => {
    if (hasil == 1) {
      Swal.fire({
        icon: 'success',
        title: 'Transaksi berhasil disimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        checkTransaction()
      })
    } else if (hasil == 0) {
      Swal.fire({
        icon: 'error',
        title: 'Transaksi tidak berhasil disimpan',
        showConfirmButton: false,
        timer: 1500
      }).then(result => {
        checkTransaction()
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

document.getElementById('bayartrans').addEventListener('click', function () {
  document.getElementById('payments').value = ''
  document.getElementById('nominalbayar').value = ''
  document.getElementById('fileBuktiKirim').value = ''
  document.getElementById('content-bayar').classList.add('d-none')
  modalConfirmTransaction.show()
})

document.getElementById('payments').addEventListener('change', function () {
  if (this.value == 0) {
    document.getElementById('content-bayar').classList.add('d-none')
  } else {
    document.getElementById('content-bayar').classList.remove('d-none')
  }
})

function setDataBank () {
  // let data = {
  //   query: `m_payment_method.Status = 1`
  // }
  // $.ajax({
  //   url: linkUrl + '/C_PaymentMethod/getData',
  //   data: data,
  //   dataType: 'JSON'
  // }).done(result => {
  //   document.getElementById('kontenPayment').innerHTML = ''
  //   let values = `<div class="form-check">
  //                     <input class="form-check-input" type="radio" name="inputChoicePayment" value="0" id="flexRadioDefault1">
  //                     <label class="form-check-label" for="flexRadioDefault1">
  //                         Tunai
  //                     </label>
  //                 </div>`
  //   for (let i = 0; i < result.length; i++) {
  //     values += `<div class="form-check">
  //                     <input class="form-check-input" type="radio" name="inputChoicePayment" value="  ${result[i]['Id_Bank']}" id="flexRadioDefault1">
  //                     <label class="form-check-label" for="flexRadioDefault1">
  //                        Transfer ${result[i]['Bank']} (${result[i]['Name']})
  //                     </label>
  //                 </div>`
  //   }
  //   document.getElementById('kontenPayment').innerHTML = values
  // })
}

document.getElementById('nextPay').addEventListener('click', function () {
  let typePayment = document.getElementById('payments').value
  let nominal = document
    .getElementById('nominalbayar')
    .value.replaceAll('.', '')

  let total = document.getElementById('total').innerHTML.split(' ')
  let ImageBUktiTF = document.getElementById('fileBuktiKirim').files[0]
  let formData = new FormData()
  formData.append('idTrans', document.getElementById('idTrans').innerHTML)
  formData.append('typePayment', typePayment)
  formData.append('nominal', nominal)
  formData.append('ImageBUktiTF', ImageBUktiTF)

  if (nominal == '') {
    sendToPayment(formData)
  } else if (parseInt(nominal) < total[1].replaceAll('.', '')) {
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
  } else {
    sendToPayment(formData)
  }
})

document.getElementById('cetakNota').addEventListener('click', function () {
  let kode = document.getElementById('idTrans').innerHTML
  $.ajax({
    url:linkUrl+"C_Transaction/printCetakNow/"+kode,
    method:"GET"
  })
})
document.getElementById('download').addEventListener('click', function () {
  let kode = document.getElementById('idTrans').innerHTML
  window.open(`${linkUrl}/Nota-Transaksi/${kode}`, '_blank')
})
document.getElementById('nextTrans').addEventListener('click', function () {
  // modalConfirmTransaction.hide()
  modalSukses.hide()
  checkTransaction()
})

function sendToPayment (formData) {
  $.ajax({
    url: linkUrl + 'paymentTransaction',
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
      modalConfirmTransaction.hide()
      modalSukses.show()

      // Swal.fire({
      //   title: 'Pembayaran Berhasil',
      //   text: 'Pembayaran sudah dilakukan',
      //   icon: 'success',
      //   showCancelButton: true,
      //   confirmButtonColor: '#3085d6',
      //   cancelButtonColor: '#d33',
      //   confirmButtonText: 'Cetak Nota',
      //   cancelButtonText: 'Lanjut Transaksi Baru',
      //   focusConfirm: true
      // }).then(result => {
      //   if (result.isConfirmed) {
      //     let kode = document.getElementById('idTrans').innerHTML
      //     window.open(`${linkUrl}/Nota-Transaksi/${kode}`, '_blank')
      //   } else {
      //     modalConfirmTransaction.hide()
      //     checkTransaction()
      //   }
      // })
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
      } else {
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

$('#fileBuktiKirim').on('change', function () {
  if ($('#fileBuktiKirim')[0].files.length > 1) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Upload bukti pembayaran hanya 1 saja'
    })
    document.getElementById('fileBuktiKirim').value = ''
  }
})

document.getElementById('inputItem').addEventListener('input', function () {
  this.style.width = this.value.length + 1 + 'ch'
  if (this.value == '' || parseInt(this.value) < 1) {
    this.value = ''
    this.style.width = 2 + 'ch'
    document.getElementById('btnMinus').disabled = true
  } else {
    document.getElementById('btnMinus').disabled = false
  }
  let item = parseInt(this.value)

  let stokArray = document.getElementById('stokM').innerHTML.split('/')
  let stok = parseInt(stokArray[0].replaceAll('.', ''))
  let jenisSatuan = 1
  if (btnSatuan == 'Lusin') {
    jenisSatuan = 12
  } else if (btnSatuan == 'Kodi') {
    jenisSatuan = 20
  } else {
    jenisSatuan = 1
  }
  let resultStok = item * jenisSatuan
  let textStok = 'Tersedia'
  if (stok >= resultStok) {
    textStok = 'Tersedia'
  } else if (stok < resultStok) {
    textStok = 'Stok Kurang ' + (resultStok - stok) + ' Potong'
  }
  if (btnSatuan != 'None' && (this.value != '' || parseInt(this.value) < 1)) {
    document.getElementById('statusPersedian').innerHTML = textStok
  } else {
    document.getElementById('statusPersedian').innerHTML = ''
  }
})
function resizeInputItem (item) {
  let inputan = document.getElementById('inputItem')
  inputan.style.width = item.length + 1 + 'ch'
}

// document.getElementById('bodys').addEventListener('mouseover', function () {
//   console.log(1)
// })
let mouseover = 1
$('body').mouseover(function () {
  mouseover++
})
setInterval(function () {
  if (mouseover > 1) {
    console.log(mouseover)
    mouseover = 1
  } else {
    console.log(mouseover)
  }
}, 300000)
