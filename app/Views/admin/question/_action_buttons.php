<a href="<?= route_to('question.show', $id) ?>" class="btn btn-outline-info btn-sm p-2">
    <i class="fas fa-eye"></i>
</a>
<a href="<?= route_to('question.edit', $id) ?>" class="btn btn-outline-warning btn-sm p-2">
    <i class="fas fa-pen"></i>
</a>
<form action="<?= route_to('question.deactivate', $id) ?>" method="post" class="d-inline"
    onsubmit="return confirm('Apakah Anda yakin akan menonaktifkan data ini?');">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-outline-danger btn-sm p-2">
        <i class="fas fa-ban"></i>
    </button>
</form>