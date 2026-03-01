<br/><br/><br/>

<div class="container">
    <div class="user-suggestions">
        <h2 class="user-info__title">All suggestions</h2>
        <?php if(empty($suggestions)):?>
            <p class="user-info__none">No suggestions made. <a class="user-info__none" href="index.php?<?php echo http_build_query(['route' => 'create']);?>">Make your first.</a></p>
        <?php else:?>
        <table class="table">
            <thead class="table__thead">
                <th class="table__header">Title</th>
                <th class="table__header">Description</th>
                <th class="table__header">Author</th>
                <th class="table__header">Vote count</th>
                <th class="table__header">Status</th>
                <th class="table__header">Actions</th>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($suggestions as $s):?>
                    <tr class="table__tr">
                    <td class="table__entry"><?php echo e($s->title); ?></th>
                    <td class="table__entry"><?php echo (substr(e($s->description), 0, 30) . '...'); ?></th>
                    <td class="table__entry"><?php echo e($s->author); ?></th>
                    <td class="table__entry"><?php echo e($s->vote_count); ?></th>
                    <td class="table__entry"><?php echo e($s->status); ?></th>
                    <td class="table__entry">
                        <a class="table__action" href="index.php?<?php echo http_build_query(['route' => 'adminEdit', 'id' => $s->id]); ?>">✏️</a>
                        <a class="table__action" href="index.php?<?php echo http_build_query(['route' => 'adminDelete', 'id' => $s->id]); ?>">❌</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif;?>
    </div>
</div>