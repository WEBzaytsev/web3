<p>Добрый день, <?= $args['user_name'] ?>!<br /></p> 

<p>Еще раз спасибо за классный текст. Он опубликован по ссылке <a href="<?= esc_url( $args['post_url'] ) ?>"><?= esc_html( $args['post_url'] ) ?></a></p>
<p>Будет здорово, если вы поделитесь им со своими подписчиками в социальных сетях.</p>
<p>И, конечно же, пишите ещё!</p>

<p><br />Команда <?= $args['domain_name'] ?></p>