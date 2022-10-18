<?php

/**
 * If users have not selected the form
 */
if (!$attributes['id'] && current_user_can('manage_options')) {
    printf(
        '<h2>%s <a href="%s">%s</a></h2>',
        __('Post form is not selected please select existing one or'),
        admin_url('admin.php?page=fe-post-forms&action=add-new'),
        __('Create New One', FE_TEXT_DOMAIN)
    );
}
$fields_list = json_decode(get_post_meta($attributes['id'], 'formBuilderData', true), true) ?? BFE\Form::get_form_builder_demo_data();
$form_id = $attributes['id'] ?? 0;
$form_theme = $form_settings['form_theme'] ?? 'default';
$form_css = sprintf('<style>%s</style>', esc_html($form_settings['form_custom_css']??''));
echo $form_css;
?>
<form class="fus-form bfe-editor <?= $form_theme ?> new-post-form" id="fus-form-<?= $form_id ?>" post_id="<?= $post_id ?>">
    <div class="hidden-fields">
        <input type="text" name="post_id" class="fus_post_id" value="<?= $post_id ?>">
        <?php if ($form_id) : ?>
            <input type="text" name="form_id" value="<?= $form_id ?>">
            <?php
            foreach ($form_settings as $name => $value) {
                printf('<input type="text" name="%s" value="%s">', $name, $value);
            }
            ?>
        <?php endif; ?>
        <?php wp_nonce_field('bfe_nonce') ?>
    </div>
    <div class="new-post-form__featured-container">
        <?php
        foreach ( $fields_list as $field ):
            if( 'featured_image' === $field['type'] ):
                do_action('bfe_editor_on_front_field_adding', $post_id, $attributes, $field);
            endif;
        endforeach;
        ?>
    </div>
    <div class="new-post-form__title-container">
        <?php
        foreach ( $fields_list as $field ):
            if( 'post_title' === $field['type'] ):
                printf('<textarea class="fus_post_title" name="post_title" type="text" placeholder="%s" rows="2">%s</textarea>', __('Add Title', FE_TEXT_DOMAIN), get_the_title($post_id));
            endif;
        endforeach;
        ?>
    </div>
    <div class="new-post-form__editor-container">
        <?php
        foreach ( $fields_list as $field ):
            if( 'post_content_editor_js' === $field['type'] ):
                $editor_js_data = get_post_meta($post_id, $field['name'], true);

                printf('<div class="EditorJS-editor" id="%s"></div>', $field['name']);
                printf(
                    '<textarea id="%s" type="hidden" class="editor-textarea hidden" name="%s" required="%s">%s</textarea>',
                    $field['name'] . '-textarea',
                    $field['post_content'] ? sprintf('editor_js[%s]', $field['name']) : $field['name'],
                    $editor_js_data ?? '',
                    $field['required'] ? 'required' : ''
                );
            endif;
        endforeach;
        ?>
    </div>
    <div class="new-post-form__action-container">
        <div class="fus-form-block-header" id="bfe-editor-block-header">
            <div class="sub-header top">
                <button class="editor-button big form-submit" title="<?php echo $button_text ?>"><?php echo $button_text ?></button>
                <?php
                $save_draft_text = isset($form_settings['save_draft_button_text']) ? $form_settings['save_draft_button_text'] : __('Save Draft', FE_TEXT_DOMAIN);
                $show_save_draft = isset($form_settings['save_draft']) ? $form_settings['save_draft'] : 'display';
                if ($show_save_draft === 'display') :
                ?>
                    <button class="editor-button big form-save-draft" title="<?php echo $save_draft_text ?>"><?php echo $save_draft_text ?></button>
                <?php
                endif;
                $add_new_button = $form_settings['fe_add_new_button'] ?? false;
                if (($post_id !== 'new' && $add_new_button !== 'disable') || $add_new_button === 'always_display') : ?>
                    <button type="button" class="new-post-form__new-post-button">
                        <a target="_blank" class="editor-button" href="<?= $new_post_link ?>" title="<?= __('Add new', FE_TEXT_DOMAIN) ?>"><?= __('Add new', FE_TEXT_DOMAIN) ?></a>
                    </button>
                <?php endif; ?>
                <button type="button" class="fus-view-page view-page <?php echo $post_id === 'new' ? 'hidden' : ''; ?>">
                    <a target="_blank" class="editor-button view-page" href="<?php the_permalink($post_id) ?? ''; ?>" title="<?php echo __('View Post', FE_TEXT_DOMAIN) ?>">
                        <span class="fus-button-text"><?= __('Preview', FE_TEXT_DOMAIN) ?></span>
                    </a>
                </button>
            </div>
        </div>
        <div class="new-post-form__action-link-container">
            <a class="new-post-form__action-link" href="/guide/">Правила публикации</a>
            <a class="new-post-form__action-link" href="/editorguide/">Инструкция по работе с редактором</a>
                
        </div>
    </div>
</form>
<?php
/*
<form class="fus-form bfe-editor <?= $form_theme ?> new-post-form" id="fus-form-<?= $form_id ?>" post_id="<?= $post_id ?>">
    <div class="hidden-fields">
        <input type="text" name="post_id" class="fus_post_id" value="<?= $post_id ?>">
        <?php if ($form_id) : ?>
            <input type="text" name="form_id" value="<?= $form_id ?>">
            <?php
            foreach ($form_settings as $name => $value) {
                printf('<input type="text" name="%s" value="%s">', $name, $value);
            }
            ?>
        <?php endif; ?>
        <?php wp_nonce_field('bfe_nonce') ?>
    </div>

    <div class="fus-form-block-header" id="bfe-editor-block-header">
        <div class="sub-header top">
            <button class="editor-button big form-submit" title="<?php echo $button_text ?>"><?php echo $button_text ?></button>
            <?php
            $save_draft_text = isset($form_settings['save_draft_button_text']) ? $form_settings['save_draft_button_text'] : __('Save Draft', FE_TEXT_DOMAIN);
            $show_save_draft = isset($form_settings['save_draft']) ? $form_settings['save_draft'] : 'display';
            if ($show_save_draft === 'display') :
            ?>
                <button class="editor-button big form-save-draft" title="<?php echo $save_draft_text ?>"><?php echo $save_draft_text ?></button>
            <?php
            endif;
            $add_new_button = $form_settings['fe_add_new_button'] ?? false;
            if (($post_id !== 'new' && $add_new_button !== 'disable') || $add_new_button === 'always_display') : ?>
                <a target="_blank" class="editor-button" href="<?= $new_post_link ?>" title="<?= __('Add new', FE_TEXT_DOMAIN) ?>"><?= __('Add new', FE_TEXT_DOMAIN) ?></a>
            <?php endif; ?>
            <button type="button" class="fus-view-page view-page <?php echo $post_id === 'new' ? 'hidden' : ''; ?>">
                <a target="_blank" class="editor-button view-page" href="<?php the_permalink($post_id) ?? ''; ?>" title="<?php echo __('View Post', FE_TEXT_DOMAIN) ?>">

                    <span class="fus-button-text"><?= __('Preview', FE_TEXT_DOMAIN) ?></span>

                    <img src="<?= FE_PLUGIN_URL . '/assets/img/see.svg' ?>" class="button-icon">
                </a>
            </button>

        </div>
    </div>
    <div class="wrapper">
        <div class="column">
            <?php
            if (!empty($fields_list)) {
                foreach ($fields_list as $key => $field) {
                    var_dump($field);
                    print '<br />';
                    switch ($field['type']) {
                        case 'post_title':
                            printf('<textarea class="fus_post_title" name="post_title" type="text" placeholder="%s" rows="2">%s</textarea>', __('Add Title', FE_TEXT_DOMAIN), get_the_title($post_id));
                            break;
                        case 'post_content_editor_js':

                            $editor_js_data = get_post_meta($post_id, $field['name'], true);

                            printf('<div class="EditorJS-editor" id="%s"></div>', $field['name']);
                            printf(
                                '<textarea id="%s" type="hidden" class="editor-textarea hidden" name="%s" required="%s">%s</textarea>',
                                $field['name'] . '-textarea',
                                $field['post_content'] ? sprintf('editor_js[%s]', $field['name']) : $field['name'],
                                $editor_js_data ?? '',
                                $field['required'] ? 'required' : ''
                            );
                            break;
                        case 'md_editor':
                            $content = get_post_meta($post_id, $field['name'], true) ?? '';
                            if ($field['post_content'] === true) {
                                $content = get_post_field('post_content', $post_id);
                            }
                            printf(
                                '<div class="md-editor" id="%s" locale="%s"></div>
                                <textarea id="%s" type="hidden" class="editor-textarea" name="%s">%s</textarea>',
                                $field['name'],
                                get_locale(),
                                $field['name'] . '-textarea',
                                $field['post_content'] ? sprintf('md_editor[%s]', $field['name']) : $field['name'],
                                $content
                            );
                            break;
                        default:
                            do_action('bfe_editor_on_front_field_adding', $post_id, $attributes, $field);
                            break;
                    }
                }
            }
            ?>
        </div>
    </div>

</form>
*/
