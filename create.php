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
    $kode_gejala = isset($_POST['kode_gejala']) ? $_POST['kode_gejala'] : '';
    $nama_gejala = isset($_POST['nama_gejala']) ? $_POST['nama_gejala'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO gejala VALUES (?, ?, ?)');
    $stmt->execute([$id, $kode_gejala, $nama_gejala]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?= template_header('Create') ?>

<div class="content update">
    <h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">No</label>
        <input type="number" name="id" value="auto" id="id">
        <label for="kode_gejala">Kode Gejala</label>
        <input type="text" name="kode_gejala" id="kode_gejala">
        <label for="nama_gejala">Nama Gejala</label>
        <input type="text" name="nama_gejala" id="nama_gejala">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>