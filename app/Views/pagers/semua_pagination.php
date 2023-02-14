<?php $pager->setSurroundCount(2) ?>

<ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>

        <li class="halaman-bagus">
            <a href="<?= $pager->getFirst(); ?>" aria-label="<?= lang('Pager.first') ?>">
                <span aria-hidden="true"><?= lang('Pager.first') ?></span>
            </a>
        </li>

        <li class="halaman-bagus">
            <a href="<?= $pager->getPrevious(); ?>" aria-label="<?= lang('Pager.previous') ?>">
                <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
            </a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <li class="halaman-bagus">
            <a href="<?= $link['uri']; ?>" style="<?= $link['active'] ? 'background-color: #db5d59;' : ''; ?>">
                <?= $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>

        <li class="halaman-bagus">
            <a href="<?= $pager->getNext(); ?>" aria-label="<?= lang('Pager.next') ?>">
                <span aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
        </li>

        <li class="halaman-bagus">
            <a href="<?= $pager->getLast(); ?>" aria-label="<?= lang('Pager.last') ?>">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        </li>
    <?php endif ?>
</ul>