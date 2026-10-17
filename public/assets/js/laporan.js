$(document).ready(function () {
  // DATATABLES
  let tabelLaporan = null;

  if ($("#tabelLaporan").length) {
    tabelLaporan = $("#tabelLaporan").DataTable({
      pageLength: 7,

      lengthMenu: [
        [7, 14, 21, 31],
        [7, 14, 21, 31],
      ],

      order: [[1, "desc"]],

      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ Data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data",
        zeroRecords: "Data tidak ditemukan",
        emptyTable: "Belum ada data laporan",
        paginate: {
          first: "‹‹",
          last: "››",
          next: "›",
          previous: "‹",
        },
      },
    });
  }

  // NOTIFIKASI SEDERHANA
  window.tampilkanToast = function (pesan, jenis = "success") {
    const warna = jenis === "success" ? "text-bg-success" : "text-bg-danger";

    let toast = $("#notifikasiLaporan");

    if (!toast.length) {
      $("body").append(`
        <div class="toast-container position-fixed top-0 end-0 p-3"
             style="z-index: 1100">
          <div id="notifikasiLaporan"
               class="toast ${warna} border-0"
               role="alert"
               aria-live="assertive"
               aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body"></div>
              <button type="button"
                      class="btn-close btn-close-white me-2 m-auto"
                      data-bs-dismiss="toast"></button>
            </div>
          </div>
        </div>
      `);

      toast = $("#notifikasiLaporan");
    }

    toast.removeClass("text-bg-success text-bg-danger").addClass(warna);
    toast.find(".toast-body").text(pesan);

    bootstrap.Toast.getOrCreateInstance(toast[0], {
      delay: 3500,
    }).show();
  };

  // SIDEBAR TOGGLE
  $("#sidebarToggle").on("click", function () {
    const sidebar = $("#sidebar");
    const mainWrapper = $("#mainWrapper");

    if (sidebar.hasClass("collapsed")) {
      sidebar.removeClass("collapsed").css("transform", "translateX(0)");
      mainWrapper.css("margin-left", "250px");
    } else {
      sidebar.addClass("collapsed").css("transform", "translateX(-250px)");
      mainWrapper.css("margin-left", "0");
    }
  });

  // TAMBAH LAPORAN + LAMPIRAN VIA AJAX
  $(document).on("submit", "#formTambah", function (e) {
    e.preventDefault();

    const form = this;
    const tombol = $(form).find('button[type="submit"]');
    const teksAwal = tombol.html();

    tombol
      .prop("disabled", true)
      .html(
        '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...',
      );

    $.ajax({
      url: form.action,
      type: "POST",
      data: new FormData(form),
      processData: false,
      contentType: false,
      dataType: "json",

      success: function (response) {
        if (!response.status) {
          tampilkanToast(
            response.message || "Laporan gagal disimpan.",
            "danger",
          );
          return;
        }

        bootstrap.Modal.getOrCreateInstance(
          document.getElementById("modalTambah"),
        ).hide();

        form.reset();

        tampilkanToast(response.message || "Laporan berhasil disimpan.");

        // DataTables akan mengambil data terbaru dari server.
        // Untuk sementara, refresh halaman diperlukan jika belum
        // tersedia endpoint khusus untuk memuat ulang tabel.
        window.location.reload();
      },

      error: function (xhr) {
        const response = xhr.responseJSON;
        let pesan = response?.message || "Laporan gagal disimpan.";

        if (response?.errors) {
          pesan += " " + Object.values(response.errors).join(" ");
        }

        tampilkanToast(pesan, "danger");
      },

      complete: function () {
        tombol.prop("disabled", false).html(teksAwal);
      },
    });
  });

  // EDIT: AMBIL DATA
  $(document).on("click", ".btn-edit", function () {
    const id = $(this).data("id");

    $.ajax({
      url: BASE_URL + "aktifitas/data/" + id,
      type: "GET",
      dataType: "json",

      success: function (response) {
        if (!response.status) {
          tampilkanToast(response.message || "Data tidak ditemukan.", "danger");
          return;
        }

        const data = response.data;

        $("#edit_tanggal").val(data.tanggal);
        $("#edit_uraian").val(data.uraian_aktifitas);
        $("#edit_pembelajaran").val(data.pembelajaran);
        $("#edit_kendala").val(data.kendala);

        $("#formEdit").attr("action", BASE_URL + "aktifitas/update/" + id);
      },

      error: function (xhr) {
        tampilkanToast(
          xhr.responseJSON?.message || "Gagal mengambil data laporan.",
          "danger",
        );
      },
    });
  });

  // EDIT: SIMPAN PERUBAHAN
  $(document).on("submit", "#formEdit", function (e) {
    e.preventDefault();

    const form = this;
    const tombol = $(form).find('button[type="submit"]');
    const teksAwal = tombol.html();

    tombol.prop("disabled", true).text("Menyimpan...");

    $.ajax({
      url: form.action,
      type: "POST",
      data: $(form).serialize(),
      dataType: "json",

      success: function (response) {
        if (response.csrfHash) {
          const csrf = $(form).find('input[type="hidden"]').first();
          $('input[name="' + csrf.attr("name") + '"]').val(response.csrfHash);
        }

        if (!response.status) {
          tampilkanToast(
            response.message || "Gagal memperbarui laporan.",
            "danger",
          );
          return;
        }

        tampilkanToast(response.message);

        bootstrap.Modal.getOrCreateInstance(
          document.getElementById("modalEdit"),
        ).hide();

        // Refresh untuk menampilkan data terbaru.
        setTimeout(() => window.location.reload(), 500);
      },

      error: function (xhr) {
        const response = xhr.responseJSON;
        const pesan = response?.errors
          ? Object.values(response.errors).join(" ")
          : response?.message || "Gagal memperbarui laporan.";

        if (response?.csrfHash) {
          const csrf = $(form).find('input[type="hidden"]').first();
          $('input[name="' + csrf.attr("name") + '"]').val(response.csrfHash);
        }

        tampilkanToast(pesan, "danger");
      },

      complete: function () {
        tombol.prop("disabled", false).html(teksAwal);
      },
    });
  });

  // HAPUS: SIMPAN ID UNTUK KONFIRMASI
  $(document).on("click", ".btn-hapus", function () {
    const id = $(this).data("id");

    $("#formHapus").attr("action", BASE_URL + "aktifitas/hapus/" + id);
  });

  // HAPUS: AJAX
  $(document).on("submit", "#formHapus", function (e) {
    e.preventDefault();

    const form = this;
    const tombol = $(form).find('button[type="submit"]');
    const teksAwal = tombol.html();

    tombol.prop("disabled", true).text("Menghapus...");

    $.ajax({
      url: form.action,
      type: "POST",
      data: $(form).serialize(),
      dataType: "json",

      success: function (response) {
        if (response.csrfHash) {
          const csrf = $(form).find('input[type="hidden"]').first();
          $('input[name="' + csrf.attr("name") + '"]').val(response.csrfHash);
        }

        if (!response.status) {
          tampilkanToast(
            response.message || "Gagal menghapus laporan.",
            "danger",
          );
          return;
        }

        bootstrap.Modal.getOrCreateInstance(
          document.getElementById("modalHapus"),
        ).hide();

        tampilkanToast(response.message);

        setTimeout(() => window.location.reload(), 500);
      },

      error: function (xhr) {
        const response = xhr.responseJSON;

        if (response?.csrfHash) {
          const csrf = $(form).find('input[type="hidden"]').first();
          $('input[name="' + csrf.attr("name") + '"]').val(response.csrfHash);
        }

        tampilkanToast(
          response?.message || "Gagal menghapus laporan.",
          "danger",
        );
      },

      complete: function () {
        tombol.prop("disabled", false).html(teksAwal);
      },
    });
  });

  // DARK / LIGHT
  $(".theme-option").on("click", function () {
    const theme = $(this).data("theme");

    if (theme === "dark") {
      $("html").attr("data-bs-theme", "dark");
      $("#themeIcon")
        .removeClass("bi-sun-fill bi-circle-half")
        .addClass("bi-moon-fill");
    } else if (theme === "light") {
      $("html").attr("data-bs-theme", "light");
      $("#themeIcon")
        .removeClass("bi-moon-fill bi-circle-half")
        .addClass("bi-sun-fill");
    } else {
      $("html").attr("data-bs-theme", "light");
      $("#themeIcon")
        .removeClass("bi-sun-fill bi-moon-fill")
        .addClass("bi-circle-half");
    }
  });

  // SELENGKAPNYA
  $(document).on("click", ".read-more", function () {
    const target = $("#" + $(this).data("target"));

    target.toggleClass("d-none");

    $(this).text(target.hasClass("d-none") ? "Selengkapnya" : "Sembunyikan");
  });
});
