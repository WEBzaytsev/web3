<?php
$post_url = get_the_permalink();
$post_id = get_the_ID();
$post_status = get_post_status();
$edit_url = '/front-user-submit/?post_id=' . $post_id;
?>
<div class="list-post">
    <div class="list-post__title">
        <a href="<?= ( current_user_can( 'edit_pages' ) ) ? $post_url : $edit_url ?>">
            <?= get_the_title() ?>
        </a>
    </div>
    <div class="list-post__status-container">
        <div class="list-post__status">
            <?php if( 'pending' === $post_status ): ?>
                На модерации
            <?php else: ?>
                Черновик
            <?php endif; ?>
        </div>
    </div>
    <div class="list-post__modified">
        <?= get_the_modified_date( 'd-m-Y H:i' ) ?>
    </div>
    <div class="list-post__actions">
        <a href="<?= $edit_url ?>" class="list-post__action list-post__action_edit"></a>
        <a class="list-post__action list-post__action_remove" data-id="<?= $post_id ?>" title="Удалить"></a>
        <?php if ( current_user_can( 'edit_pages' ) ) : ?>
            <a class="list-post__action list-post__action_publish" data-id="<?= $post_id ?>" title="Опубликовать"></a>
        <?php endif; ?>
    </div>
</div>
<?php