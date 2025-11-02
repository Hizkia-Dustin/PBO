<?php
    include 'connection.php';
?>
<?php if (!empty($_GET['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Data mahasiswa berhasil ditambahkan.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if (!empty($_GET['updated'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Data mahasiswa berhasil diupdate.
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
    Data mahasiswa berhasil di hapus
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php
    $sql = 'SELECT m.*, p.nama_prodi 
            FROM mahasiswa m
            LEFT JOIN prodi p ON m.id_prodi = p.id_prodi';

    $query = $conn->query($sql);
    $rows = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header d-flex justify-content-between align-items-center">
    Data Mahasiswa
    <button class="btn btn-primary" id="add">Add</button>
  </h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Jenis Kelamin</th>
          <th>Program Studi</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
      
      <?php foreach ($rows as $row) : ?>
        <tr>
          <td><?= $row->nim ?></td>
          <td><?= $row->nama ?></td>
          <td><?= $row->jenis_kelamin ?></td>
          <td><?= $row->nama_prodi ?></td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item edit" href="javascript:void(0);" data-id="<?= base64_encode($row->nim) ?>">
                  <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                </a>
                <a class="dropdown-item delete" href="javascript:void(0);" data-id="<?= base64_encode($row->nim) ?>">
                  <i class="icon-base bx bx-trash me-1"></i> Delete
                </a>
              </div>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>

      <?php if (!$query->rowCount()) : ?>
        <tr><td colspan="5">Tidak ada data</td></tr>
      <?php endif; ?>

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
        <h5 class="modal-title">Form Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formData" method="post">
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">NIM</label>
              <input type="text" id="nim" name="nim" class="form-control" placeholder="NIM" required />
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Nama</label>
              <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Mahasiswa" required />
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Jenis Kelamin</label>
              <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Program Studi</label>
              <select id="id_prodi" name="id_prodi" class="form-control" required>
                <option value="">-- Pilih Program Studi --</option>
                <?php
                  $prodi = $conn->query("SELECT * FROM prodi ORDER BY nama_prodi")->fetchAll(PDO::FETCH_OBJ);
                  foreach ($prodi as $p) {
                    echo "<option value='{$p->id_prodi}'>{$p->nama_prodi}</option>";
                  }
                ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="formData">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    // tombol tambah data
    $('#add').click(function () {
      $('#formModal').modal('show');
      $('#formData').prop('action', 'mahasiswa_in.php');

      $('#nim').val('');
      $('#nama').val('');
      $('#jenis_kelamin').val('');
      $('#id_prodi').val('');
    });

    // hapus data
    $('.table').on('click', '.delete', function () {
      var id = $(this).data('id');
      if (confirm('Yakin ingin menghapus data ini?')) {
        window.location.href = 'mahasiswa_delete.php?id=' + id;
      }
    });

    // edit data
    $('.table').on('click', '.edit', function () {
      var id = $(this).data('id');

      $('#formModal').modal('show');
      $('#formData').prop('action', 'mahasiswa_update.php?id=' + id);

      $.ajax({
        url: "mahasiswa_edit.php?id=" + id,
        dataType: 'json',
        method: 'post',
        beforeSend: function () {
          $('#nim, #nama, #jenis_kelamin, #id_prodi').prop('disabled', true);
        },
        success: function (data) {
          $('#nim').val(data.nim);
          $('#nama').val(data.nama);
          $('#jenis_kelamin').val(data.jenis_kelamin);
          $('#id_prodi').val(data.id_prodi);

          $('#nim, #nama, #jenis_kelamin, #id_prodi').prop('disabled', false);
        },
        error: function (err) {
          console.log(err);
        }
      });
    });
  });
</script>
