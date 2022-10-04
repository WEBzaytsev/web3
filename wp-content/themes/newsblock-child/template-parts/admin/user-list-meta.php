<?php
$user = $args['user'];
$value = get_the_author_meta( '_webtree_hide_from_list', $user->ID );
$checked = ( isset( $value ) && '1' === $value ) ? 'checked="checked"' : '';
?>
<h2>Отображение в списке пользователей</h2>
<table class="form-table">
    <tr>
        <th>Отображение</th>
        <td><label for="webtree_hide_from_list"><input type="checkbox" name="webtree_hide_from_list" id="webtree_hide_from_list" <?= esc_attr( $checked ) ?> />Скрыть в списке пользователей</label></td>
    </tr>
</table>