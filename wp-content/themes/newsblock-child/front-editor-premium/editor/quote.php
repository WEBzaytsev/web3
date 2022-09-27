<?php
    if ($data['alignment'] == 'center') {
        $centerClass = 'bfe-quote--center';
    } else {
        $centerClass = '';
    }
?>
<!-- wp:quote -->
<blockquote class="wp-block-quote bfe-quote <?= $centerClass ?>"><p><?= $data['caption'] ?></p><cite><?= $data['text'] ?></cite></blockquote>
<!-- /wp:quote -->