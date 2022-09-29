<div class="fe_custom_field <?= $field['name'] ?>">
    <?php
    printf('<label for="%s">%s</label>', $field['name'], $field['label']);
    printf('<input type="%s" required="%s" name="text_fields[%s]" class="%s" value="%s">', $field['subtype'], $field['required'], $field['name'], $field['className'], get_post_meta($post_id, $field['name'], true) ?? '');
    ?>
</div>