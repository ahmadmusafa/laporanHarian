$(document).ready(function () {
  const tabel = $("#tabelLampiran").DataTable({
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
      infoEmpty: "Belum ada data",
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
      const info = this.api().page.info();

      this.api()
        .column(0, { page: "current" })
        .nodes()
        .each(function (cell, index) {
          cell.innerHTML = info.start + index + 1;
        });
    },
  });

  // Konfirmasi sebelum menghapus lampiran
  $(document).on("click", ".btnHapus", function () {
    console.log("Tombol Hapus diklik");
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
