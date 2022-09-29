<?php

namespace BFE;

$tabs = [
    'Published' => 'publish',
    'Pending' => 'pending',
    'Draft' => 'draft'
];

?>
<div class="fe_fs_user_admin_wrap">
    <ul class="fe_fs_tabs">
        <?php
        foreach ($tabs as $name => $slug) :
        ?>
            <li class="<?php echo $post_status === $slug ? 'active-tab' : '' ?>">
                <a href="<?php printf('?post_status=%s', $slug) ?>">
                    <button><?php _e($name, FE_TEXT_DOMAIN) ?></button>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="fe_fs_post_list">
        <div class="fe_fs_title">
            <strong><?php echo strtoupper(__($post_status, FE_TEXT_DOMAIN)) ?></strong>
            <?php if ($user_can) : ?>
                <a href="<?php echo $req_url .= $req_url_query ? '&any_user=true' : '?any_user=true' ?>"><?php _e('Show all users posts', FE_TEXT_DOMAIN) ?></a>
            <?php endif; ?>
        </div>
        <?php
        if ($post_lists->have_posts()) :
        ?>
            <table>

                <?php
                while ($post_lists->have_posts()) :
                    $post_lists->the_post();
                    $post_url = get_the_permalink();
                    $post_id = get_the_ID();
                ?>

                    <tr>
                        <td class="fe_fs_img">
                            <a href="<?= $post_url ?>">
                                <div class="img__box"><?= wp_get_attachment_image(get_post_thumbnail_id($post_id), 'medium') ?></div>
                            </a>
                        </td>
                        <td>
                            <a href="<?= $post_url ?>">
                                <?= wp_trim_words(get_the_title(), 6) ?>
                            </a>
                        </td>
                        <td class="fe_fs_icon_container">
                            <span class="fe_fs_edit__btn">
                                <a href="<?= Editor::get_post_edit_link($post_id) ?>">
                                    <img class="fe_fs_icon" src="<?= FE_PLUGIN_URL . '/assets/img/edit.png' ?>" />
                                </a>
                            </span>
                        </td>
                        <td class="fe_fs_icon_container">
                            <span class="fe_fs_delete__btn">
                                <a href="<?php printf('?delete_post=%s',$post_id);?>">
                                    <img class="fe_fs_icon" src="<?= FE_PLUGIN_URL . '/assets/img/delete.png' ?>" />
                            </span>
                        </td>
                    </tr>

                <?php endwhile; ?>
            </table>
            <?php

            $newer_page_link = get_previous_posts_link(sprintf('< %s', __('Newer', FE_TEXT_DOMAIN)));
            $previous_page_link = get_next_posts_link(sprintf('%s >', __('Previous', FE_TEXT_DOMAIN)), $post_lists->max_num_pages);
            printf('<div class="nav"><span>%s</span> <span>%s</span></div>', $newer_page_link, $previous_page_link);

            wp_reset_postdata();

            ?>
        <?php else : ?>
            <p><?php _e('0 posts found', FE_TEXT_DOMAIN) ?></p>
        <?php endif; ?>
    </div>

</div>