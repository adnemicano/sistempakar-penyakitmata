<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $kode_gejala = isset($_POST['kode_gejala']) ? $_POST['kode_gejala'] : '';
        $nama_gejala = isset($_POST['nama_gejala']) ? $_POST['nama_gejala'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE gejala SET id = ?, kode_gejala = ?, nama_gejala = ? WHERE id = ?');
        $stmt->execute([$id, $kode_gejala, $nama_gejala, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM gejala WHERE id = ?');
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
    <h2>Update Contact #<?= $contact['id'] ?></h2>
    <form action="update.php?id=<?= $contact['id'] ?>" method="post">
        <label for="id">No</label>
        <input type="number" name="id" value="<?= $contact['id'] ?>" id="id">     
        <label for="kode_gejala">Kode gejala</label>
        <input type="text" name="kode_gejala" value="<?= $contact['kode_gejala'] ?>" id="kode_gejala">
        <label for="nama_gejala">Nama Gejala</label>
        <input type="text" name="nama_gejala" value="<?= $contact['nama_gejala'] ?>" id="nama_gejala">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>