<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $kode_penyakit = isset($_POST['kode_penyakit']) ? $_POST['kode_penyakit'] : '';
        $nama_penyakit = isset($_POST['nama_penyakit']) ? $_POST['nama_penyakit'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE penyakit SET id = ?, kode_penyakit = ?, nama_penyakit = ? WHERE id = ?');
        $stmt->execute([$id, $kode_penyakit, $nama_penyakit, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM penyakit WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?= template_header('Read') ?>

<div class="content update">
    <h2>Update Penyakit #<?= $contact['id'] ?></h2>
    <form action="update_penyakit.php?id=<?= $contact['id'] ?>" method="post">
        <label for="id">No</label>
        <input type="number" name="id" value="<?= $contact['id'] ?>" id="id">     
        <label for="kode_penyakit">Kode Penyakit</label>
        <input type="text" name="kode_penyakit" value="<?= $contact['kode_penyakit'] ?>" id="kode_penyakit">
        <label for="nama_penyakit">Nama Penyakit</label>
        <input type="text" name="nama_penyakit" value="<?= $contact['nama_penyakit'] ?>" id="nama_penyakit">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>