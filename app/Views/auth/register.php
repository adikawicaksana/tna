<form method="post" action="./register">
    <input type="text" name="username" placeholder="Username" required value="<?= old('username') ?>">
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirm" placeholder="Konfirmasi Password" required>
    <button type="submit">Register</button>
    <?= session()->getFlashdata('errors') ? '<p style="color:red">'.implode('<br>', session('errors')).'</p>' : '' ?>
</form>
