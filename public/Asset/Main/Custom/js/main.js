var linkUrl = document.getElementById('linkURL').value
let alertAccount = new bootstrap.Modal(
  document.getElementById('alertAccount'),
  {
    keyboard: false,
    backdrop: 'static',
    focus: true
  }
)
let myInterval = setInterval(myTimer, 1000)

function myTimer () {
  $.ajax({
    url: linkUrl + '/C_Login/cekUthActive',
    dataType: 'JSON'
  }).done(result => {
    if (result == 0) {
      myStop()
    }
  })
}

function myStop () {
  clearInterval(myInterval)
  alertAccount.show()
}

document
  .getElementById('btnLogoutAlert')
  .addEventListener('click', function () {
    window.location.href = linkUrl + '/C_Login/logoutAlert'
  })

let LoadingData = `;<div class='timeline-item'>
  <div class='animated-background'></div>
</div>
`
// document.documentElement.setAttribute('data-bs-theme', 'light')
