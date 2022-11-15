    <a href="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#normal<?= $paket['id']; ?>">
        <i></i>
        <i class="bi bi-repeat"></i>
        <span>Edit Paket</span>
    </a>
    <div class="modal fade text-left" id="normal<?= $paket['id']; ?>" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Edit Paket Laundry</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="col-sm">
                            <h6>Masukkan Jenis</h6>
                            <fieldset class="form-group">
                                <select class="form-select" id="basicSelect" name="editjenis">
                                    <option value="kiloan">Kiloan</option>
                                    <option value="selimut">Selimut</option>
                                    <option value="bed_cover">Bed Cover</option>
                                    <option value="kaos">Kaos</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control" placeholder="Masukan Nama Paket" name="editpaket" value="<?= $paket['nama_paket']; ?>">
                            <div class="form-control-icon">
                                <i class="bi bi-minecart-loaded"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <input type="number" class="form-control" placeholder="Masukkan Harga" name="editharga" value="<?= $paket['harga']; ?>">
                            <div class="form-control-icon">
                                <i class="bi bi-bookmark"></i>
                            </div>
                        </div>
                        <input type="text" class="visually-hidden" value="<?= $paket['id']; ?>" name="id">
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal" name="edit">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $paket['id']; ?>">
        <i></i>
        <i class="bi bi-trash3-fill"></i>
        <span>Delete</span>
    </a>
    <div class="modal fade text-left" id="hapus<?= $paket['id']; ?>" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="myModalLabel1">Hapus Paket</h5>
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
                                <input type="text" class="visually-hidden" value="<?= $paket['id']; ?>" name="idhapus">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ya</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>