<div class="navbar">
    <script src="../js/logout.js"></script>
    <div class="navbar-items">
        <div class="action">
            <h1 class="nama-user">
                <div class="logout" onclick="logout()">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </div>
                <div class="label">
                    <?php echo $namalengkap; ?>
                    <?php if ($access_level == 'admin') : ?>
                        <i class="fa-solid fa-crown"></i>
                    <?php elseif ($access_level == 'petugas') : ?>
                        <i class="fa-solid fa-user-tie"></i>
                    <?php elseif ($access_level == 'peminjam') : ?>
                        <i class="fa-solid fa-user"></i>
                    <?php endif; ?>
                </div>
            </h1>
        </div>
    </div>
</div>