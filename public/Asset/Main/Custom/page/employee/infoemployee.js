RequestData()
function setLoadingItem (isLoading) {
  if (isLoading == 1) {
    document.getElementById('loadingDataBawahan').classList.add('d-none')
    document.getElementById('loadingDataLog').classList.add('d-none')
    // document.getElementById('kontenItem').classList.remove('d-none')
  } else {
    // document.getElementById('kontenItem').classList.add('d-none')
    document.getElementById('loadingDataBawahan').classList.remove('d-none')
    document.getElementById('loadingDataLog').classList.remove('d-none')
  }
}

let tanggalFormat = $('.selector').flatpickr({
  mode: 'range',
  dateFormat: 'Y-m-d',
  maxDate: 'today',
  onClose: function (selectedDates, dateStr, instance) {
    checkDate(selectedDates)
  }
})

function RequestData () {
  setLoadingItem(0)
  setTimeout(function () {
    setLoadingItem(1)
    setData()
  }, 2000)
}

function checkDate (dates) {
  let optionss = {
    // weekday: 'long',
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  }
  let start = new Date(dates[0])
  let end = new Date(dates[1])
  let data = {
    start:
      start.getFullYear() +
      '-' +
      (start.getMonth() + 1) +
      '-' +
      start.getDate(),
    end: end.getFullYear() + '-' + (end.getMonth() + 1) + '-' + end.getDate()
  }
  document.getElementById('loadingDataLog').classList.remove('d-none')
  document.getElementById('noneLog').classList.add('d-none')
  document.getElementById('valueLog').classList.add('d-none')

  setTimeout(function () {
    $.ajax({
      url: linkUrl + '/C_Employee/getLogEmployee',
      type: 'POST',
      data: data,
      dataType: 'JSON'
    }).done(Log => {
      if (Log.length == 0) {
        document.getElementById('noneLog').classList.remove('d-none')
        document.getElementById('valueLog').classList.add('d-none')
      } else {
        document.getElementById('valueLog').classList.remove('d-none')
        document.getElementById('noneLog').classList.add('d-none')
        let valueLog = ''
        let options = {
          // weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        }

        for (let i = 0; i < Log.length; i++) {
          let today = new Date(Log[i]['CreatedDate'])
          valueLog += ` <div class="d-flex bd-highlight mt-2">
                            <div class="d-lg-none d-none custom-padding bd-highlight">
                                <p class="text-muted custom-date">${today.toLocaleDateString(
                                  'id-ID',
                                  options
                                )} ${today.toLocaleTimeString('ru-RU', {
            timeZone: 'Asia/Jakarta',
            hourCycle: 'h23',

            hour: '2-digit',
            minute: '2-digit'
          })}</p>
                            </div>
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
                                  Log[i].Description
                                }</p>
                            </div>
                        </div>`
        }

        document.getElementById('valueLog').innerHTML = valueLog
      }
    })
    document.getElementById('loadingDataLog').classList.add('d-none')
  }, 2000)

  document.getElementById('valueDate').innerHTML =
    '(' +
    start.toLocaleDateString('id-ID', optionss) +
    ' - ' +
    end.toLocaleDateString('id-ID', optionss) +
    ')'
  // console.log(start.toLocaleDateString('id-ID', optionss))
}

document.getElementById('Back1').addEventListener('click', function () {
  window.location.href = linkUrl + '/Karyawan'
})

function setData () {
  $.ajax({
    type: 'GET',
    url: linkUrl + 'C_Employee/getInformationEmployee',
    dataType: 'JSON'
  }).done(result => {
    let Karyawan = result.Karyawan
    let Log = result.Log
    let Bawahan = result.Bawahan
    console.log(result)

    //set EMploye
    document.getElementById('nameEmploye').innerHTML = Karyawan.Name
    document.getElementById('username').innerHTML = Karyawan.Username
    document.getElementById('email').innerHTML =
      Karyawan.Email != '' ? Karyawan.Email : '-'
    document.getElementById('alamat').innerHTML = Karyawan.Address
    document.getElementById('gender').innerHTML =
      Karyawan.Gender == '2' ? 'Perempuan' : 'Laki-Laki'
    document.getElementById('telepon').innerHTML = Karyawan.Telephone
    document.getElementById('posisi').innerHTML = Karyawan.NamePosition
    document.getElementById('role').innerHTML = Karyawan.NameRole
    document.getElementById('atasan').innerHTML =
      Karyawan.Superior != null ? Karyawan.Superior : '-'
    document.getElementById('status').innerHTML =
      Karyawan.Status != 1 ? 'Tidak Aktif' : 'Aktif'
    let optionss = {
      // weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    }
    let created = new Date(Karyawan.CreatedDate)
    let updated = new Date(Karyawan.ModifiedDate)

    document.getElementById('created').innerHTML =
      created.toLocaleDateString('id-ID', optionss) +
      ' ' +
      created.toLocaleTimeString('ru-RU', {
        timeZone: 'Asia/Jakarta',
        hourCycle: 'h23',

        hour: '2-digit',
        minute: '2-digit'
      })
    document.getElementById('update').innerHTML =
      updated.toLocaleDateString('id-ID', optionss) +
      ' ' +
      updated.toLocaleTimeString('ru-RU', {
        timeZone: 'Asia/Jakarta',
        hourCycle: 'h23',

        hour: '2-digit',
        minute: '2-digit'
      })

    if (Karyawan.ImageProfile == null) {
      if (Karyawan.Gender == '2') {
        document.getElementById('detailImage').src =
          linkUrl + '/Asset/Main/compiled/jpg/3.jpg'
      } else {
        document.getElementById('detailImage').src =
          linkUrl + '/Asset/Main/compiled/jpg/2.jpg'
      }
    } else {
      document.getElementById('detailImage').src =
        linkUrl + '/' + Karyawan.ImageProfile
    }

    if (Log.length == 0) {
      document.getElementById('noneLog').classList.remove('d-none')
      document.getElementById('valueLog').classList.add('d-none')
    } else {
      document.getElementById('valueLog').classList.remove('d-none')
      document.getElementById('noneLog').classList.add('d-none')
      let valueLog = ''
      let options = {
        // weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      let optionsValue = {
        // weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      }
      let start = new Date(result.StartDate)
      let end = new Date(result.EndDate)
      document.getElementById('valueDate').innerHTML =
        '(' +
        start.toLocaleDateString('id-ID', optionsValue) +
        ' - ' +
        end.toLocaleDateString('id-ID', optionsValue) +
        ')'

      for (let i = 0; i < Log.length; i++) {
        let today = new Date(Log[i]['CreatedDate'])
        valueLog += ` <div class="d-flex bd-highlight mt-2">
                            <div class="d-lg-none d-none custom-padding bd-highlight">
                                <p class="text-muted custom-date">${today.toLocaleDateString(
                                  'id-ID',
                                  options
                                )} ${today.toLocaleTimeString('ru-RU', {
          timeZone: 'Asia/Jakarta',
          hourCycle: 'h23',

          hour: '2-digit',
          minute: '2-digit'
        })}</p>
                            </div>
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
                                  Log[i].Description
                                }</p>
                            </div>
                        </div>`
      }

      document.getElementById('valueLog').innerHTML = valueLog
    }

    if (Bawahan.length == 0) {
      document.getElementById('noneBawahan').classList.remove('d-none')
      document.getElementById('valueBawahan').classList.add('d-none')
    } else {
      document.getElementById('valueBawahan').classList.remove('d-none')
      document.getElementById('noneBawahan').classList.add('d-none')
      let values = ''
      for (let i = 0; i < Bawahan.length; i++) {
        let Status = 'Tidak Bekerja'
        if (Bawahan[i]['Status'] == 1) {
          Status = 'Masih Bekerja'
        }
        let foto = linkUrl + '/' + Bawahan[i]['ImageProfile']
        if (Bawahan[i]['ImageProfile'] == null) {
          if (Bawahan[i]['Gender'] == 2) {
            foto = linkUrl + '/Asset/Main/compiled/jpg/3.jpg'
          } else {
            foto = linkUrl + '/Asset/Main/compiled/jpg/2.jpg'
          }
        }

        values += `<div class="d-flex bd-highlight" style="margin-top: -10px;">
                      <div class="p-2 flex-shrink-1 bd-highlight">
                          <div class="avatar avatar-md2">
                              <img class="custom-img-online" src="${foto}" alt="Avatar">
                          </div>
                      </div>
                      <div class="p-2 w-100 bd-highlight">
                          <h6 class="mt-1">${Bawahan[i]['Name']}</h6>
                          <p style="margin-top: -5px;">${Status}</p>
                      </div>
                  </div>`
      }
      document.getElementById('valueBawahan').innerHTML = values
    }
  })
}
