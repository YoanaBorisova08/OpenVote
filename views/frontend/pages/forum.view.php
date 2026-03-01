<div class="container">
        <div class="forum__top">
            <h1 class="f__header">Forum</h1>
            <div class="forum__extras">
                <form method="get" action="index.php" class="forum__extra">
                    <input type="hidden" name="route" value="forum">
                
                    <label class="forum__extra-header" for="sort">Sort by:</label>

                    <select class="forum__extra-select" name="sort" id="sort" onchange="this.form.submit()">
                        <option class="forum__extra-option" value="date" <?php echo $sortMethod === 'date' ? 'selected' : '';?>>most recent</option>
                        <option class="forum__extra-option" value="vote" <?php echo $sortMethod === 'vote' ? 'selected' : '';?>>most popular</option>
                    </select>
                </form>
                <form method="get" action="index.php" class="forum__extra">
                    <input type="hidden" name="route" value="forum">
                
                    <label class="forum__extra-header" for="filter">Filter by:</label>

                    <select class="forum__extra-select" name="filter" id="filter" onchange="this.form.submit()">
                        <option class="forum__extra-option" value="" <?php echo $filterMethod === '' ? 'selected' : ''; ?>>none</option>                    
                        <?php foreach($statusOP as $status): ?>
                            <option class="forum__extra-option" value=<?php echo e($status); ?> <?php echo $filterMethod === $status ? 'selected' : ''; ?>><?php echo e($status); ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
        <?php if(empty($suggestions)): ?>
            <h2>No suggestions.</h2>
        <?php else: ?>
            <?php foreach($suggestions as $s): ?>
                <article class="most__suggestion">
                    <div class="most__suggestion__top">
                    <a href="index.php?<?php echo http_build_query(['route' => 'suggestion', 'id' => $s->id]) ?>" class="most__suggestion__title"><?php echo e($s->title); ?></a>
                    <p class="most__suggestion__status"><?php echo e($s->status); ?></p>
                    </div>
                    <p class="most__suggestion__desription"><?php echo e($s->description); ?></p>
                    <div class="most__suggestion-bottom">
                        <?php if ($isLoggedIn): ?>
                            <form method="post" action="index.php?<?php echo http_build_query(['route' => 'forum']) ?>" name="new-vote">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>" />
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
            <?php if($pagesCount>1):?>
                <div class="pagination">
                    <?php if($page>1): ?>
                        <a href="index.php?<?php echo http_build_query(
                            ['route' => 'forum', 'page' => $page-1, 'sort' => $sortMethod, 'filter' => $filterMethod]
                            ); ?>" class="pagination__button__arrow">❮❮</a>
                    <?php endif; ?>
                    <?php for($i=1; $i<=$pagesCount; $i++):?>
                        <a href="index.php?<?php echo http_build_query(
                            ['route' => 'forum', 'page' => $i, 'sort' => $sortMethod, 'filter' => $filterMethod]
                            );?>" 
                            class="pagination__button
                            <?php if($page===$i) echo "pagination__button-active";?>"><?php echo $i ?></a>
                    <?php endfor;?>
                    <?php if($page<$pagesCount): ?>
                        <a href="index.php?<?php echo http_build_query(
                            ['route' => 'forum', 'page' => $page+1, 'sort' => $sortMethod, 'filter' => $filterMethod]
                            );?>" class="pagination__button__arrow">❯❯</a>
                    <?php endif; ?>
                </div>
            <?php endif;?>
        <?php endif; ?>
</div>