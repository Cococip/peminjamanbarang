<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */
$pager->setSurroundCount(1);
?>
<?php if ($pager->getPageCount() > 1) : ?>
<div class="pagination-wrap">
    <div class="pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <a href="<?= $pager->getPrevious() ?>">&laquo;</a>
        <?php else : ?>
            <span class="disabled"><span>&laquo;</span></span>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link) : ?>
            <?php if ($link['active']) : ?>
                <span class="active"><span><?= $link['title'] ?></span></span>
            <?php else : ?>
                <a href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()) : ?>
            <a href="<?= $pager->getNext() ?>">&raquo;</a>
        <?php else : ?>
            <span class="disabled"><span>&raquo;</span></span>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>
