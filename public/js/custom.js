$(function () {
    $('#datatable').DataTable({
        "paging": true,
        "lengthChange": true,
        "iDisplayLength": 50,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $('#datatable1').DataTable({
        "paging": true,
        "lengthChange": true,
        "iDisplayLength": 10,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    $('#datatable2').DataTable({
        "paging": true,
        "lengthChange": true,
        "iDisplayLength": 10,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $('#datatable3').DataTable({
        "paging": true,
        "lengthChange": true,
        "pageLength" : 5,
        "lengthMenu" : [[5, 10, 20, -1], [5, 10, 50, 100]],
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

     flatpickr("#tgl_absen", {
        enableTime: false,
        // time_24hr: true,
        dateFormat: "Y-m-d",
        locale: "id",
    });

    // flatpickr("#tgl_absen_akhir", {
    //     enableTime: false,
    //     // time_24hr: true,
    //     dateFormat: "Y-m-d",
    //     locale: "id",
    // });

    flatpickr("#tanggal_lahir", {
        enableTime: false,
        // time_24hr: true,
        dateFormat: "Y-m-d",
        locale: "id",
    });

    flatpickr("#tgl_ovt", {
        enableTime: false,
        // time_24hr: true,
        dateFormat: "Y-m-d",
        locale: "id",
    });

    flatpickr("#jam", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    // Foto click
    $("#avatar").click(function () {
        $("#foto_ttd").click();
    });

    // Ketika file input change
    $("#foto_ttd").change(function () {
     setImage(this, "#avatar");
    });

    // document.addEventListener('DOMContentLoaded', function () {
    //     var jns_absen = document.getElementById('jns_absen');
    //     var tgl_absen_akhir_group = document.getElementById('tgl_absen_akhir_group');
    
    //     // Sembunyikan grup form tanggal absen akhir saat halaman dimuat
    //     tgl_absen_akhir_group.style.display = 'none';
    
    //     // Tampilkan atau sembunyikan grup form tanggal absen akhir berdasarkan pilihan jenis absensi
    //     jns_absen.addEventListener('change', function () {
    //         if (this.value === 'Cuti Melahirkan') {
    //             tgl_absen_akhir_group.style.display = 'block';
    //             applyFlatpickr(); // Terapkan flatpickr pada input tanggal akhir saat ditampilkan
    //         } else {
    //             tgl_absen_akhir_group.style.display = 'none';
    //         }
    //     });
    // });
    
    // document.addEventListener('DOMContentLoaded', function () {
    //     var tgl_absen_akhir_input = document.getElementById('tgl_absen_akhir_input');
    
    //     // Pasang Flatpickr pada elemen input tanggal absen akhir
    //     flatpickr(tgl_absen_akhir_input, {
    //         enableTime: false,
    //         dateFormat: "Y-m-d",
    //         locale: "id",
    //     });
    // });


});


function showPreload() {
    $(".preload").css("display", "flex");
    $("#loader").css("display", "block");
    $("#logo").css("display", "block");
}

function showMessage(type, mess, target = "body") {

    // Options
    toastr.options = {
        "showDuration": "3000",
        "hideDuration": "3000",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
    };

    // Target Agar bisa tampil pada saat full screen
    toastr.options.target = target;

    switch (type) {
        case "success":
            toastr.success(mess);
            break;
        case "info":
            toastr.info(mess);
            break;
        case "error":
            toastr.error(mess);
            break;
        case "warning":
            toastr.warning(mess);
            break;
    }
}

 // Ambil elemen alert
 var alert = $(".alert");

 // Tentukan durasi timeout dalam milidetik (misalnya, 5000 ms untuk 5 detik)
 var timeoutDuration = 5000;

 // Tunggu selama durasi timeout, lalu tutup alert
 setTimeout(function() {
     alert.alert('close');
 }, timeoutDuration);

 $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })

  // Read Image
function setImage(input, target) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      // Mengganti src dari object img#avatar
      reader.onload = function (e) {
        $(target).attr('src', e.target.result);
        $("#foto").val(e.target.result);
      }
  
      reader.readAsDataURL(input.files[0]);
    }
}
