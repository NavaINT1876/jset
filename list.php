<div class="content-wrapper">
    <div class="content">
        <h1>News list</h1>
        <a href="<?= '/index.php?r=add-news'?>">
            <button type="text">Create news item</button>
        </a>
        <div class="news-list">
            <ul>
                <?php
                foreach ($newsArr as $newsItem) { ?>
                    <li id="<?= $newsItem['id']?>">
                        <img src="dist/img/news_item.png" alt="">
                        <div class="news-text">
                            <a href="/index.php?r=single-view&id=<?= $newsItem['id']?>" >
                                <h4><?= $newsItem['title']; ?></h4>
                            </a>
                            <p><?= Model::getPreviewText($newsItem['text'])?></p>
                        </div>
                        <div class="news-date"><?= date('d.m.Y', $newsItem['date']); ?></div>
                        <div class="rud-links">
                            <a href="/index.php?r=single-view&id=<?= $newsItem['id']?>" >View</a>
                            <a href="/index.php?r=edit-news&id=<?= $newsItem['id']?>">Edit</a>
                            <a href="#" onclick="deleteItem(<?= $newsItem['id']?>)">Remove</a>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php
        if(isset($paginParams)) {
            if ($paginParams['countPages'] > 1) { ?>
                <div class="pagination">
                    <?php if ($paginParams['active'] != 1) { ?>
                        <a href="<?= $paginParams['url'] ?>" title="First page">&lt;&lt;&lt;</a>
                        <a href="<?php if ($paginParams['active'] == 2) { ?><?= $paginParams['url'] ?><?php } else { ?><?= $paginParams['urlPage'] . ($paginParams['active'] - 1) ?><?php } ?>"
                           title="Previous page">&lt;</a>
                    <?php } ?>
                    <?php
                    for ($i = $paginParams['start']; $i <= $paginParams['end']; $i++) { ?>
                        <?php if ($i == $paginParams['active']) { ?>
                            <span><?= "[" . $i . "]" ?></span>
                        <?php } else { ?>
                            <a href="<?php if ($i == 1) { ?><?= $paginParams['url'] ?><?php } else { ?><?= $paginParams['urlPage'] . $i ?><?php } ?>"><?= $i ?></a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($paginParams['active'] != $paginParams['countPages']) { ?>
                        <a href="<?= $paginParams['urlPage'] . ($paginParams['active'] + 1) ?>" title="Next page">&gt;</a>
                        <a href="<?= $paginParams['urlPage'] . $paginParams['countPages'] ?>" title="Last page">&gt;&gt;&gt;</a>
                    <?php } ?>
                </div>
            <?php }
        }
        ?>
    </div>
</div>
<div class="page-buffer"></div>