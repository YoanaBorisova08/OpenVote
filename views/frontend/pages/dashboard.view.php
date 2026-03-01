<div class="container">
    <div class="search">
        <form method="get" action="index.php">
            <input type="search" name="search" class="search-field" value="<?php echo $_GET['search'] ?? 'Search...';?>">
            <input type="submit" class="search__submit-btn" value="🔍">
        </form>
    </div>
    <?php if(!empty($searchSuggestions)): ?>
        <div class="searched_suggestions">
        <?php foreach($searchSuggestions as $s):?>
            <article class="search__suggestion">
                        <a href="index.php?<?php echo http_build_query(['route' => 'suggestion', 'id' => $s->id]) ?>" class="most__suggestion__title"><?php echo e($s->title); ?></a>
                        <div class="most__suggestion-bottom">
                            <?php if ($isLoggedIn): ?>
                                <form method="post" action="index.php" name="new-vote">
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
        <?php endforeach; ?>
        </div>
    <?php elseif($searchSuggestions=== false):?>
        <h2>No results matching your search.</h2>
    <?php endif; ?>
    <div class="suggestions">
        <div class="most-popular">
            <div class="most__suggestions">
                <h2 class="most__header">Most popular</h1>
                <?php foreach($popular_suggestions as $s): ?>
                    <article class="most__suggestion">
                        <a href="index.php?<?php echo http_build_query(['route' => 'suggestion', 'id' => $s->id]) ?>" class="most__suggestion__title"><?php echo e($s->title); ?></a>
                        <div class="most__suggestion-bottom">
                            <?php if ($isLoggedIn): ?>
                                <form method="post" action="index.php" name="new-vote">
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
                <?php endforeach; ?>
            </div>
        </div>
        <div class="most-recent">
            <div class="most__suggestions">
                <h2 class="most__header">Most recent</h1>
                <?php foreach($recent_suggestions as $s): ?>
                    <article class="most__suggestion">
                        <a href="index.php?<?php echo http_build_query(['route' => 'suggestion', 'id' => $s->id]) ?>" class="most__suggestion__title"><?php echo e($s->title); ?></a>
                        <div class="most__suggestion-bottom">
                            <?php if ($isLoggedIn): ?>
                                <form method="post" action="index.php" name="new-vote">
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
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>