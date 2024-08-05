$(function () {
    $('#datatable').DataTable({
        "paging": true,
        "lengthChange": true,
        "iDisplayLength": 10,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });

    $('#datatable1').DataTable({
        "paging": true,
        "lengthChange": true,
        "iDisplayLength": 5,
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": true,
    });

    $('#datatable2').DataTable({
        "paging": true,
        "lengthChange": true,
        "iDisplayLength": 5,
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

    flatpickr("#jam_awal", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    flatpickr("#jam_akhir", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    flatpickr("#tgl_awal", {
        enableTime: false,
        dateFormat: "Y-m-d",
        locale: "id",
    });

    flatpickr("#tgl_akhir", {
        enableTime: false,
        dateFormat: "Y-m-d",
        locale: "id",
    });

    flatpickr("#tgl_awal_input", {
        enableTime: false,
        dateFormat: "Y-m-d",
        locale: "id",
    });

    flatpickr("#tgl_akhir_input", {
        enableTime: false,
        dateFormat: "Y-m-d",
        locale: "id",
    });

    $("#avatar").click(function () {
        $("#file").click();
    });

    $("#file").change(function () {
     setImage(this, "#avatar");
    });
});


function showPreload() {
    $(".preload").css("display", "flex");
    $("#loader").css("display", "block");
    $("#logo").css("display", "block");
}

function showMessage(type, mess, target = "body") {

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "showDuration": "3000",
        "hideDuration": "3000",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
    };

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


 $(function () {
    $('.select2').select2()
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })

function setImage(input, target) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $(target).attr('src', e.target.result);
        $("#foto").val(e.target.result);
      }
  
      reader.readAsDataURL(input.files[0]);
    }
}
