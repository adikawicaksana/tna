<h1>Dashboard</h1>
<p>Halo, <?= session()->get('username') ?></p>
<a href="./logout">Logout</a>
<script>
function refreshToken() {
    fetch('./refresh-token', {
        method: 'POST',
        credentials: 'include' // Kirim cookie HttpOnly
    })
    .then(res => res.json())
    .then(data => {
        if (data.access_token) {
            console.log('Token diperbarui.');
        } else {
            console.log('Gagal refresh, logout otomatis.');
            // window.location.href = '/logout';
        }
    })
    .catch(err => {
        console.error('Refresh error', err);
    });
}

// Refresh token setiap 9 menit (540.000 ms)
setInterval(refreshToken, 9000);
</script>