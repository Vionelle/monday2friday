<div class="card-header">
    <h6 class="mt-3">Daftar User</h6>
</div>
<div class="card-body">
    <table class="table table-bordered">
        <thead>
            <th>Id</th>
            <th>Username</th>
            <th>Created By</th>
            <th>Created Date</th>
        </thead>
        <tbody>
            <?php foreach($data['users'] as $index => $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->created_by ?></td>
                    <td><?= $user->created_date ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div style="float:right">
        <?= $data['pager']->links('default','custom_pagination') ?>
    </div>
</div>