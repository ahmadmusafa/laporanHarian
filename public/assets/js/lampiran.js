$(document).ready(function () {
  // Konfirmasi hapus lampiran
  $(document).on("click", ".btnHapus", function (e) {
    e.preventDefault();

    const id = $(this).data("id");
    const nama = $(this).data("nama");

    if (!id) return;

    $("#namaLampiranHapus").text(nama);

    $("#formHapusLampiran").attr("action", BASE_URL + "/lampiran/delete/" + id);

    bootstrap.Modal.getOrCreateInstance(
      document.getElementById("modalHapusLampiran"),
    ).show();
  });
});
