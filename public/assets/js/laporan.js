$(document).ready(function () {
  // DATATABLES
  if ($("#tabelLaporan").length) {
    $("#tabelLaporan").DataTable({
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

  // SIDEBAR TOGGLE
  $("#sidebarToggle").on("click", function () {
    const sidebar = $("#sidebar");
    const mainWrapper = $("#mainWrapper");

    if (sidebar.hasClass("collapsed")) {
      // BUKA SIDEBAR
      sidebar.removeClass("collapsed").css("transform", "translateX(0)");

      mainWrapper.css("margin-left", "250px");
    } else {
      // TUTUP SIDEBAR
      sidebar.addClass("collapsed").css("transform", "translateX(-250px)");

      mainWrapper.css("margin-left", "0");
    }
  });

  // EDIT DATA
  $(document).on("click", ".btn-edit", function () {
    const id = $(this).data("id");

    console.log("ID Edit:", id);

    $.ajax({
      url: BASE_URL + "aktifitas/data/" + id,

      type: "GET",

      dataType: "json",

      success: function (response) {
        console.log("Data diterima:", response);

        if (response.status === true) {
          const data = response.data;

          $("#edit_tanggal").val(data.tanggal);

          $("#edit_uraian").val(data.uraian_aktifitas);

          $("#edit_pembelajaran").val(data.pembelajaran);

          $("#edit_kendala").val(data.kendala);

          $("#formEdit").attr("action", BASE_URL + "aktifitas/update/" + id);
        } else {
          alert(response.message);
        }
      },

      error: function (xhr) {
        console.error("Gagal mengambil data:", xhr.responseText);

        alert("Gagal mengambil data.");
      },
    });
  });

  // HAPUS DATA
  $(document).on("click", ".btn-hapus", function () {
    const id = $(this).data("id");

    $("#btnKonfirmasiHapus").attr("href", BASE_URL + "aktifitas/hapus/" + id);
  });

  // TANGGAL & WAKTU
  function updateTanggalWaktu() {
    const now = new Date();

    $("#tanggalHari").text(
      now.toLocaleDateString("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
      }),
    );

    $("#waktuSekarang").text(now.toLocaleTimeString("id-ID") + " WIB");
  }

  setInterval(updateTanggalWaktu, 1000);
  updateTanggalWaktu();

  // Dark/Light
  $(".theme-option").click(function () {
    let theme = $(this).data("theme");

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

  // ==================================================
  // READ MORE - MAKSIMAL 100 KARAKTER
  // ==================================================
  function tampilkanReadMore() {
    $(".read-more").each(function () {
      const elemen = $(this);

      // Simpan teks asli satu kali
      if (elemen.data("teks-asli") === undefined) {
        elemen.data("teks-asli", elemen.text().trim());
      }

      const teks = elemen.data("teks-asli");
      const batas = 100;

      if (teks.length > batas) {
        elemen.html(
          $("<span>").text(teks.substring(0, batas) + "...")[0].outerHTML +
            ' <button type="button" class="btn btn-link btn-sm p-0 btn-readmore">Selengkapnya</button>',
        );
      } else {
        elemen.text(teks);
      }
    });
  }

  // SELENGKAPNYA
  $(document).on("click", ".read-more", function () {
    const target = $("#" + $(this).data("target"));

    target.toggleClass("d-none");

    $(this).text(target.hasClass("d-none") ? "Selengkapnya" : "Sembunyikan");
  });
});
