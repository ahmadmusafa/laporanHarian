$(document).ready(function () {
  // DataTables
  $("#tabelLampiran").DataTable({
    pageLength: 7,
    lengthMenu: [7, 14, 21, 28],
    order: [[3, "desc"]],

    columnDefs: [
      {
        targets: [0, 4],
        orderable: false,
        searchable: false,
      },
    ],

    language: {
      search: "Cari:",
      searchPlaceholder: "Cari lampiran...",
      lengthMenu: "Tampilkan _MENU_ data",
      info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
      infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
      infoFiltered: "(difilter dari _MAX_ total data)",
      zeroRecords: "Data tidak ditemukan",
      emptyTable: "Belum ada lampiran",

      paginate: {
        first: "Pertama",
        last: "Terakhir",
        next: "Berikutnya",
        previous: "Sebelumnya",
      },
    },

    drawCallback: function () {
      const api = this.api();
      const info = api.page.info();

      api
        .column(0, { page: "current" })
        .nodes()
        .each(function (cell, index) {
          cell.innerHTML = info.start + index + 1;
        });
    },
  });

  // Modal konfirmasi hapus
  $(document).on("click", ".btnHapus", function () {
    const id = $(this).data("id");
    const nama = $(this).data("nama");

    $("#namaLampiranHapus").text(nama);

    $("#formHapusLampiran").attr(
      "action",
      window.lampiranConfig.deleteUrl + "/" + id,
    );

    bootstrap.Modal.getOrCreateInstance(
      document.getElementById("modalHapusLampiran"),
    ).show();
  });
});
