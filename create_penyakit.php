<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $kode_penyakit = isset($_POST['kode_penyakit']) ? $_POST['kode_penyakit'] : '';
    $nama_penyakit = isset($_POST['nama_penyakit']) ? $_POST['nama_penyakit'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO penyakit VALUES (?, ?, ?)');
    $stmt->execute([$id, $kode_penyakit, $nama_penyakit]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?= template_header('Create') ?>

<div class="content update">
    <h2>Halaman Tambah Penyakit</h2>
    <form action="create_penyakit.php" method="post">
        <label for="id">No</label>
        <input type="number" name="id" value="auto" id="id">
        <label for="kode_penyakit">Kode Penyakit</label>
        <input type="text" name="kode_penyakit" id="kode_penyakit">
        <label for="nama_penyakit">Nama Penyakit</label>
        <input type="text" name="nama_penyakit" id="nama_penyakit">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>