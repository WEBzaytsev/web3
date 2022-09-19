<?php
$comment = $args[ 'comment' ];
$post = get_post( $comment->comment_post_ID );
?>
<div class="comment">
    <div class="comment__head">
        <div class="comment__date">
            <?= comment_date( 'd F, Y', $comment->comment_ID ) ?>
        </div>
        <a class="comment__post-link" href="<?= esc_url( get_permalink( $post ) ) ?>"><?= esc_html( $post->post_title ) ?></a>
    </div>
    <a class="comment__content" href="<?= esc_url( get_permalink( $post ) . '#comment-' . $comment->comment_ID ) ?>">
        <?= $comment->comment_content ?>
    </a>
</div>
<?php
wp_reset_postdata();