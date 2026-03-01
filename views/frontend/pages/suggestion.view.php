<br/><br/>
<div class="container">
    <article class="most__suggestion">
                    <div class="most__suggestion__top">
                    <a href="#" class="most__suggestion__title"><?php echo e($s->title); ?></a>
                    <p class="most__suggestion__status"><?php echo e($s->status); ?></p>
                    </div>
                    <p class="most__suggestion__desription"><?php echo e($s->description); ?></p>
                    <div class="most__suggestion-bottom">
                        <?php if ($isLoggedIn): ?>
                            <form method="post" action="index.php?<?php echo http_build_query(['route' => 'suggestion', 'id' => $s->id]) ?>" name="new-vote">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <?php if(in_array($s->id, $votedFor)): ?>
                                    <button type="submit" name="vote" value="<?php echo e($s->id); ?>" class="new-vote__btn">❤️</button>
                                <?php else: ?>
                                    <button type="submit" name="vote" value="<?php echo e($s->id); ?>" class="new-vote__btn">🤍</button>
                                <?php endif;?>
                                <label for="vote" class="new-vote__label"><?php echo e($s->vote_count); ?></label>
                            </form>
                            <?php else:?>
                                <div class="most__suggestion__vote-count">
                                    <p class="new-vote__label">🤍</p>
                                    <p class="new-vote__label"><?php echo e($s->vote_count); ?></p>
                                </div>
                            <?php endif; ?>
                        <p class="most__suggestion__author"><?php echo e($s->author); ?></p>
                    </div>
                    <p class="most__suggestion__date">Last modified on <?php echo e($s->updated_at); ?></p>
    </article>
    <div class="suggestion__comments">
        <h2 class="suggestion__comments__title">Comments</h2>
        <?php if($isAdmin):?>
            <a href="index.php?<?php echo http_build_query(['route' => 'addComment', 'id' => $s->id]) ?>" class="admin__add-comment" >➕ Add a comment</a>
            <?php if(!empty($commentInput)) echo $commentInput;?>
        <?php endif;?>
        <?php if(empty($comments)):?>
            <p>No comments.</p>
        <?php else:?>
        <div class="suggestion__comments__div">
            <?php foreach($comments AS $c):?>
                <div class="suggestion__comments__comment">
                    <p class="suggestion__comment__autor-name"><?php echo e($c->author); ?></p>
                    <p class="suggestion__comment__text"><?php echo nl2br(e($c->comment)); ?></p>
                </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>
</div>
