<?php
    include 'connection.php';
?>
<?php if (!empty($_GET['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Data prodi berhasil ditambahkan.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if (!empty($_GET['updated'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Data prodi berhasil diupdate.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if (!empty($_GET['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'Terjadi kesalahan saat menyimpan data.'; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if(!empty($_GET['deleted'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Data prodi berhasil di hapus
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php
    $sql = 'SELECT * FROM prodi';

    $query = $conn->query($sql);

    $rows = $query->fetchAll(PDO::FETCH_OBJ);
?>

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                  Program Studi
                  <button class="btn btn-primary" id="add">Add</button>
                </h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Kode Angka</th>
                        <th>Kode Huruf</th>
                        <th>Inisial</th>
                        <th>Nama Prodi</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    
                    <?php foreach ($rows as $row) : ?>

                      <tr>
                        <td><?php echo $row->kode_angka; ?></td>
                        <td><?php echo $row->kode_huruf; ?></td>
                        <td><?php echo $row->inisial; ?></td>
                        <td><?php echo $row->nama_prodi; ?></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="icon-base bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item edit" href="javascript:void(0);"
                                data-id="<?php echo base64_encode($row->id_prodi); ?>"
                                ><i class="icon-base bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item delete" href="javascript:void(0);"
                                data-id="<?php echo base64_encode($row->id_prodi); ?>"
                                ><i class="icon-base bx bx-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                    
                    <?php
                        endforeach;

                        if (! $query->rowCount()) {
                    ?>

                    <tr><td colspan="5">Tidak ada data</td></tr>
                    
                    <?php
                        }
                    ?>

                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->

              <!-- Modal -->
              <div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel1">Form Program Studi</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form id="formData" method="post">
                        <div class="row">
                          <div class="col mb-6">
                            <label class="form-label">Kode Angka</label>
                            <input
                              type="number"
                              id="kode_angka"
                              name="kode_angka"
                              class="form-control"
                              placeholder="Kode Angka"
                              required />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-6">
                            <label class="form-label">Kode Huruf</label>
                            <input
                              type="text"
                              id="kode_huruf"
                              name="kode_huruf"
                              class="form-control"
                              placeholder="Kode Huruf"
                              required />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-6">
                            <label class="form-label">Inisial</label>
                            <input
                              type="text"
                              id="inisial"
                              name="inisial"
                              class="form-control"
                              placeholder="Inisial"
                              required />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-6">
                            <label class="form-label">Nama Prodi</label>
                            <input
                              type="text"
                              id="nama_prodi"
                              name="nama_prodi"
                              class="form-control"
                              placeholder="Nama Prodi"
                              required />
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                      <button type="submit" class="btn btn-primary" form="formData">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>

              <script>
                $(document).ready(function () {
                  $('#add').click(function () {
                    $('#formModal').modal('show');

                    $('#formData').prop('action', 'prodi_insert.php');

                    $('#kode_angka').val('');
                    $('#kode_huruf').val('');
                    $('#inisial').val('');
                    $('#nama_prodi').val('');
                  });

                  $('.table').on('click', '.delete', function () {
                    var id = $(this).data('id');

                    if (confirm('Are you sure?')) {
                      window.location.href = 'prodi_delete.php?id=' + id;
                    }
                  });

                  $('.table').on('click', '.edit', function () {
                    var id = $(this).data('id');

                    $('#formModal').modal('show');

                    $('#formData').prop('action', 'prodi_update.php?id=' + id);

                    $.ajax({
                      url: "prodi_edit.php?id=" + id,
                      dataType: 'json',
                      method: 'post',
                      beforeSend: function () {
                        $('#kode_angka').prop('disabled', true);
                        $('#kode_huruf').prop('disabled', true);
                        $('#inisial').prop('disabled', true);
                        $('#nama_prodi').prop('disabled', true);
                      },
                      success: function (data) {
                        // console.log(data);

                        $('#kode_angka').val(data.kode_angka);
                        $('#kode_huruf').val(data.kode_huruf);
                        $('#inisial').val(data.inisial);
                        $('#nama_prodi').val(data.nama_prodi);

                        $('#kode_angka').prop('disabled', false);
                        $('#kode_huruf').prop('disabled', false);
                        $('#inisial').prop('disabled', false);
                        $('#nama_prodi').prop('disabled', false);
                      },
                      error: function (err) {
                        console.log(err);
                      }
                    });
                  });
                });
              </script>