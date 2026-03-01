<div class="container">
    <div class="user-info">
        <h2 class="user-info__title">My profile</h2>
        <p class="user-info__el">Username: <?php echo e($user->username);?></p>
        <p class="user-info__el">First name: <?php echo e($user->firstName);?></p>
        <p class="user-info__el">Last name: <?php echo e($user->lastName);?></p>
        <p class="user-info__el">Email: <?php echo e($user->email);?></p>
        <a href="index.php?<?php echo http_build_query(['route' => 'logout']) ?>" class="user-profile__logout" >Log Out ➜]</a>
    </div>
    <div class="user-suggestions">
        <h2 class="user-info__title">My suggestions</h2>
        <?php if(empty($suggestions)):?>
            <p class="user-info__none">No suggestions made. <a class="user-info__none" href="index.php?<?php echo http_build_query(['route' => 'create']);?>">Make your first.</a></p>
        <?php else:?>
        <table class="table">
            <thead class="table__thead">
                <th class="table__header">Title</th>
                <th class="table__header">Description</th>
                <th class="table__header">Vote count</th>
                <th class="table__header">Actions</th>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($suggestions as $s):?>
                    <tr class="table__tr">
                    <td class="table__entry"><?php echo e($s->title); ?></th>
                    <td class="table__entry"><?php echo (substr(e($s->description), 0, 30) . '...'); ?></th>
                    <td class="table__entry"><?php echo e($s->vote_count); ?></th>
                    <td class="table__entry">
                        <a class="table__action" href="index.php?<?php echo http_build_query(['route' => 'edit', 'id' => $s->id]); ?>">✏️</a>
                        <a class="table__action" href="index.php?<?php echo http_build_query(['route' => 'delete', 'id' => $s->id]); ?>">❌</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif;?>
    </div>
</div>