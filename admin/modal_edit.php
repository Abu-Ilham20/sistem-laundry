<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/main/app.css">
    <link rel="stylesheet" href="../assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.svg" type="../image/x-icon">
    <link rel="shortcut icon" href="../assets/images/logo/favicon.png" type="../image/png">
    <link rel="stylesheet" href="../assets/css/shared/iconly.css">


</head>

<body>
    <a href="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#normal<?= $user['id']; ?>">
        <i></i>
        <i class="bi bi-repeat"></i>
        <span>Edit</span>
    </a>
    <div class="modal fade text-left" id="normal<?= $user['id']; ?>" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Edit Anggota</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control" placeholder="Masukkan Nama User" name="editnama" value="<?= $user['nama']; ?>">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control" placeholder="Masukkan Username" name="editusername" value="<?= $user['username']; ?>">
                            <div class="form-control-icon">
                                <i class="bi bi-bookmark"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <input type="password" class="form-control" placeholder="Masukkan Password" name="editpassword" value="<?= $user['password']; ?>">
                            <div class="form-control-icon">
                                <i class="bi bi-key"></i>
                            </div>
                        </div>
                        <div class="col-sm">
                            <h6>Masukkan Role</h6>
                            <fieldset class="form-group">
                                <select class="form-select" id="basicSelect" name="editrole">
                                    <option value="kasir">Kasir</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal" name="edit">
                                <input type="text" class="visually-hidden" value="<?= $user['id']; ?>" name="id">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $user['id']; ?>">
    <i class="bi bi-trash3-fill"></i>
        <span>Delete</span>
    </a>
    <div class="modal fade text-left" id="hapus<?= $user['id']; ?>" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Hapus Anggota</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <h5 class="text-center">Apakah anda yakin ingin menghapus Anggota?</h5>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tidak</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal" name="delete">
                                <input type="text" class="visually-hidden" value="<?= $user['id']; ?>" name="idhapus">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ya</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- ubah mode -->
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
</body>

</html>