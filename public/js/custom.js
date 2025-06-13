const ajaxCall = (url, method, data, successCallback, errorCallback) => {
  const isFormData = data instanceof FormData
  const isGet = method.toUpperCase() === 'GET'
  $.ajax({
    type: method,
    enctype: 'multipart/form-data',
    url,
    cache: false,
    data,
    data: isGet ? data : data,
    contentType: isGet
      ? false
      : isFormData
      ? false
      : 'application/x-www-form-urlencoded; charset=UTF-8',
    processData: isGet ? true : !isFormData,
    headers: {
      Accept: 'application/json',
      'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
    },
    dataType: 'json',
    success: function (response) {
      console.log(response)
      successCallback(response)
    },
    error: function (error) {
      errorCallback(error)
    }
  })
}

function confirmLogout () {
  swal
    .fire({
      title: 'Apakah Kamu Yakin?',
      text: 'Anda ingin logout!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Logout!',
      cancelButtonText: 'Batal'
    })
    .then(result => {
      if (result.isConfirmed) {
        ajaxCall(
          '/logout',
          'POST',
          null,
          function (response) {
            handleSuccess(response, null, '/')
          },
          function (error) {
            handleSimpleError(error)
          }
        )
      }
    })
}

const getModal = (targetId, url = null, fields = null) => {
  $(`#${targetId}`).modal('show')
  $(`#${targetId} .form-control`).removeClass('is-invalid')
  $(`#${targetId} .invalid-feedback`).html('')
  $(`#${targetId} small .text-danger`).html('')
  const cekLabelModal = $('#label-modal')
  if (cekLabelModal) {
    $('#id').val('')
    cekLabelModal.text('Tambah')
  }

  if (url) {
    cekLabelModal.text('Edit')
    const successCallback = function (response) {
      fields.forEach(field => {
        if (response.data[field]) {
          $(`#${targetId} #${field}`)
            .val(response.data[field])
            .trigger('change')
        }
      })
    }

    const errorCallback = function (error) {
      console.log(error)
    }
    ajaxCall(url, 'GET', null, successCallback, errorCallback)
  }
  $(`#${targetId} .form-control`).val('')
}

const handleSuccess = (response, modalId = null, redirect = null) => {
  if (modalId !== null) {
    $(`#${modalId}`).modal('hide')
  }
  const message = response.message
  showSwal('Berhasil', 'success', message, redirect)
}

function showSwal (title, icon, message, redirect = null) {
  swal
    .fire({
      title: title,
      icon: icon,
      text: message,
      timer: 2000
    })
    .then(function () {
      if (redirect) {
        window.location.href = redirect
      }
    })
}

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: toast => {
    toast.onmouseenter = Swal.stopTimer
    toast.onmouseleave = Swal.resumeTimer
  }
})

function showToast (icon, title) {
  Toast.fire({
    icon: icon,
    title: title
  })
}

window.initEditModal = function ({
  formSelector,
  url,
  fields = [],
  callback = null,
  onFetched = null
}) {
  console.log(url)
  $.get(`/${url}`, function (response) {
    const form = $(formSelector)[0]
    const data = response.data
    console.log(data, fields)

    $(formSelector).data('id', data.id)

    fields.forEach(field => {
      const input = $(form).find(`[name="${field}"]`)

      console.log(data[field], field, data)

      if (input.is(':checkbox')) {
        input.prop('checked', data[field])
      } else if (input.is(':radio')) {
        input.filter(`[value="${data[field]}"]`).prop('checked', true)
      } else {
        input.val(data[field])
      }
    })

    if (typeof callback === 'function') {
      callback(data)
    }

    if (typeof onFetched === 'function') {
      onFetched(data)
    }
  })
}

function loadData (selector, url, tableSelector) {
  $.ajax({
    url: `${url}`,
    type: 'GET',
    success: function (res) {
      console.log(selector, url, tableSelector)
      // Masukkan konten terlebih dahulu ke DOM
      $(selector).html(res.data.view)

      // Tunggu sampai DOM siap (delay 50-100ms)
      setTimeout(() => {
        if ($(tableSelector).length) {
          initDatatable(tableSelector)
        } else {
          showToast('error', 'Tabel tidak ditemukan ')
        }
      }, 50)
    },
    error: function () {
      console.log(selector, url, tableSelector)
      showToast('error', 'Gagal memuat data.')
    }
  })
}

function dataLoad (selector, url) {
  $.ajax({
    url: `${url}`,
    type: 'GET',
    success: function (res) {
      $(selector).html(res.data.view)
    },
    error: function () {
      console.log(selector, url, tableSelector)
      showToast('error', 'Gagal memuat data.')
    }
  })
}

function initDatatable (selector) {
  const $table = $(selector)

  if (!$table.length) {
    console.error('Tabel tidak ditemukan:', selector)
    return
  }

  if (!$table.find('thead').length) {
    console.error('Tabel tidak memiliki thead:', $table.prop('outerHTML'))
    return
  }

  const thCount = $table.find('thead th').length
  const tdCount = $table.find('tbody tr:first td').length

  if (thCount !== tdCount) {
    console.error(`Jumlah kolom tidak sesuai! TH: ${thCount}, TD: ${tdCount}`)
    console.log('Contoh baris:', $table.find('tbody tr:first').html())
    return
  }

  try {
    $table.DataTable({
      destroy: true,
      autoWidth: true,
      responsive: true,
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
      }
    })
    console.log('DataTables berhasil diinisialisasi pada:', selector)
  } catch (e) {
    console.error('Error inisialisasi DataTables:', e.message)
    console.error('Stack trace:', e.stack)
  }
}

const loadSelectOptions = (selector, url, selectedValue = null) => {
  const selectElem = $(selector)

  // Kosongkan dulu opsi yang ada
  selectElem.empty()

  // Tambah opsi kosong dulu
  const emptyOption = $('<option></option>')
    .attr('value', '')
    .text('-- Pilih Data --')
  selectElem.append(emptyOption)

  const successCallback = function (response) {
    console.log(response)
    const responseList = response.data
    console.log(responseList)
    responseList.forEach(row => {
      const option = $('<option></option>')
        .attr('value', row.id)
        .text(
          row.ibu && row.ibu.nik && row.ibu.nama && row.anak_ke
            ? `${row.ibu.nik}, ${row.ibu.nama}, Kehamilan ke-${row.anak_ke}`
            : row.ibu && row.ibu.nik
            ? `${row.ibu.nik}${row.ibu.nama ? `, ${row.ibu.nama}` : ''}`
            : row.nama ?? ''
        )
      selectElem.append(option)
    })

    // Set pilihan default kalau ada
    if (selectedValue !== null) {
      selectElem.val(selectedValue)
    }
  }

  const errorCallback = function (error) {
    console.error(error)
  }

  const data = {
    mode: 'select'
  }

  ajaxCall(url, 'GET', data, successCallback, errorCallback)
}

const handleValidationErrors = (error, formId = null, fields = null) => {
    console.log(error.responseJSON);
  if (error.responseJSON.data && fields) {
    fields.forEach(field => {
      if (error.responseJSON.data[field]) {
        $(`#${formId} #${field}`).addClass('is-invalid')
        $(`#${formId} #error${field}`).html(error.responseJSON.data[field][0])
      } else {
        $(`#${formId} #${field}`).removeClass('is-invalid')
        $(`#${formId} #error${field}`).html('')
      }
    })
  } else {
    handleSimpleError(error)
  }
}

const handleSimpleError = error => {
  const message = error.responseJSON.message ?? error.message ?? error
  showSwal('Gagal', 'error', message)
}

function confirmDelete (
  url,
  selector = null,
  route = null,
  tableSelector = null
) {
  swal
    .fire({
      title: 'Apakah Kamu Yakin?',
      text: 'Anda ingin menghapus data ini!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus!',
      cancelButtonText: 'Batal'
    })
    .then(result => {
      if (result.isConfirmed) {
        const data = null

        const successCallback = function (response) {
          handleSuccess(response)
          if (selector && route && tableSelector) {
            loadData(selector, route, tableSelector)
          }
        }

        const errorCallback = function (error) {
          handleSimpleError(error)
        }

        ajaxCall(url, 'DELETE', data, successCallback, errorCallback)
      }
    })
}

const setButtonLoadingState = (buttonSelector, isLoading, title = 'Simpan') => {
  const buttonText = isLoading
    ? `<i class="fas fa-spinner fa-spin mr-1"></i> ${title}`
    : title
  $(buttonSelector).prop('disabled', isLoading).html(buttonText)
}

const select2ToJson = (selector, url, modal = null, jenis = 'null') => {
  const selectElem = $(selector)

  if (selectElem.children().length > 0) {
    return
  }

  const successCallback = function (response) {
    const emptyOption = $('<option></option>')
    emptyOption.attr('value', '')
    emptyOption.text('-- Pilih Data --')
    selectElem.append(emptyOption)

    const responseList = response.data
    responseList.forEach(function (row) {
      const option = $('<option></option>')
      option.attr('value', row.id)
      const label = row.nama ? row.nama : row.judul
      option.text(label)
      selectElem.append(option)
    })

    selectElem.select2({})
  }

  const errorCallback = function (error) {
    console.log(error)
  }

  ajaxCall(url, 'GET', null, successCallback, errorCallback)
}

const togglePasswordVisibility = (inputSelector, iconSelector) => {
  let passwordInput = $(inputSelector)
  let toggleIcon = $(iconSelector)

  console.log(inputSelector, iconSelector)

  if (passwordInput.attr('type') === 'password') {
    passwordInput.attr('type', 'text')
    toggleIcon.removeClass('fas fa-eye').addClass('fas fa-eye-slash')
  } else {
    passwordInput.attr('type', 'password')
    toggleIcon.removeClass('fas fa-eye-slash').addClass('fas fa-eye')
  }
}

const createChart = (labels, berkunjung, peminjaman, pengembalian) => {
  const statistics_chart = $('#myChart')

  if (statistics_chart.data('chart')) {
    statistics_chart.data('chart').destroy()
  }

  const ctx = statistics_chart[0].getContext('2d')

  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Kunjungan',
          data: berkunjung,
          borderWidth: 5,
          borderColor: '#47c363',
          backgroundColor: 'rgba(71, 195, 99, 0.3)',
          pointBackgroundColor: '#fff',
          pointBorderColor: '#47c363',
          pointRadius: 4
        },
        {
          label: 'Peminjaman Buku',
          data: peminjaman,
          borderWidth: 5,
          borderColor: '#ffa426',
          backgroundColor: 'rgba(255, 164, 38, 0.3)',
          pointBackgroundColor: '#fff',
          pointBorderColor: '#ffa426',
          pointRadius: 4
        },
        {
          label: 'Pengembalian Buku',
          data: pengembalian,
          borderWidth: 5,
          borderColor: '#fc544b',
          backgroundColor: 'rgba(252, 84, 75, 0.3)',
          pointBackgroundColor: '#fff',
          pointBorderColor: '#fc544b',
          pointRadius: 4
        }
      ]
    },
    options: {
      legend: {
        display: true
      },
      scales: {
        yAxes: [
          {
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              beginAtZero: true,
              stepSize: 50
            }
          }
        ],
        xAxes: [
          {
            gridLines: {
              color: '#fbfbfb',
              lineWidth: 2
            }
          }
        ]
      }
    }
  })

  statistics_chart.data('chart', myChart)
}
