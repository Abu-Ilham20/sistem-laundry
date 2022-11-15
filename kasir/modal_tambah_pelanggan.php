<a href="" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#normal">
    <i></i>
    <i class="bi bi-folder-plus"></i>
    <span style="padding-left: 4px;">Tambah Member</span>
</a>
<hr>
<div class="modal fade text-left" id="normal" tabindex="-1" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel1">Tambah Member Laundry</h5>
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
                        <input type="text" class="form-control" placeholder="Masukkan Nama Anda" name="nama">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left">
                        <input type="text" class="form-control" placeholder="Masukkan Alamat Anda" name="alamat">
                        <div class="form-control-icon">
                            <i class="bi bi-bookmark"></i>
                        </div>
                    </div>
                    <div class="col-sm">
                        <h6>Masukkan jenis kelamin</h6>
                        <fieldset class="form-group">
                            <select class="form-select" id="basicSelect" name="jenkel">
                                <option value="Laki-laki">laki-laki</option>
                                <option value="Perempuan">perempuan</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group position-relative has-icon-left">
                        <input  type="number" class="form-control" placeholder="Masukkan No Tlp" name="telepon">
                        <div class="form-control-icon">
                            <i class="bi bi-bookmark"></i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal" name="tambah">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>