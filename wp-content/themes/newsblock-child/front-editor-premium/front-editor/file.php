<?php
printf('<label for="%s">%s</label>', $field['name'], $field['label']);
printf(
    '<input type="file" required="%s" id="%s" name="file_fields[%s]" class="%s" value="%s" %s>',
    $field['required'] ? 'required' : '',
    $field['name'],
    $field['name'],
    $field['className'],
    '',
    $field['multiple'] ? 'multiple' : ''
);
