<?php
/**
 * The template for displaying the footer layout 2
 *
 * @package Newsblock
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_footer_background', '#111111' ),
	get_theme_mod( 'color_footer_background_dark', '#1c1c1c' )
);
?>

<footer class="cs-footer cs-footer-two" <?php echo wp_kses( $scheme, 'post' ); ?>>
	<?php csco_component( 'footer_subscription_form' ); ?>

	<div class="cs-container">
		<div class="cs-footer__item">
			<div class="cs-footer__col cs-col-left">
				<div class="cs-footer__inner">
					<?php csco_component( 'footer_logo' ); ?>(с) 2022
          <p>Доступно и интересно рассказываем о технологиях, бизнесе и репутации в новой Web3-экономике.</p>
					<?php //csco_component( 'footer_social_links' ); ?>
				</div>
			</div>
			<div class="cs-footer__col cs-col-center">
      <div class="footer-nav-menu">
				<ul id="menu-foter2" class="cs-footer__nav cs-nav-grid">
          <li id="menu-item-3056" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3056"><a href="/about/">О проекте</a></li>
<li id="menu-item-3060" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3060"><a href="/community/">Сообщество</a></li>
<li id="menu-item-3064" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3064"><a href="/editorial/">Политика</a></li>
<li id="menu-item-3057" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3057"><a href="/contacts/">Контакты</a></li>
<li id="menu-item-3061" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3061"><a href="/users/">Авторы</a></li>
<li id="menu-item-3065" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3065"><a href="/content/">Карта контента</a></li>
<li id="menu-item-3058" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3058"><a href="/adv/">Реклама</a></li>
<li id="menu-item-3062" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3062"><a href="/guide/">Правила</a></li>

<li id="menu-item-3066" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3066"><a href="/tag/events/">Мероприятия</a></li>
<li id="menu-item-3059" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3059"><a href="/editorial/">Регламенты</a></li>
<li id="menu-item-3063" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3063"><a href="/add/">Написать пост</a></li>
<li id="menu-item-3063" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3063"><a href=""></a></li>
</ul>			
</div>
			</div>
			 <div class="cs-footer__col "><!--cs-col-right -->
				<?php //csco_component( 'footer_description' ); ?>
        <?php csco_component( 'footer_social_links' ); ?>
			</div>
		</div>
	</div>
  
<!--AdFox START-->
<!--yandex_web3adv-->
<!--Площадка: Web3 / Desktop / FS / Floor ad-->
<!--Категория: <не задана>-->
<!--Тип баннера: FS / Floor ad-->
<div id="adfox_166291288027377000"></div>
<script>
    window.yaContextCb.push(()=>{
        Ya.adfoxCode.createAdaptive({
            ownerId: 706490,
            containerId: 'adfox_166291288027377000',
            params: {
                p1: 'cvsmd',
                p2: 'hvif'
            }
        }, ['desktop', 'tablet'], {
            tabletWidth: 830,
            phoneWidth: 480,
            isAutoReloads: false
        })
    })
</script>



<!--AdFox START-->
<!--yandex_web3adv-->
<!--Площадка: Web3 / Mobile / FS / Floor ad-->
<!--Категория: <не задана>-->
<!--Тип баннера: FS / Floor ad-->
<div id="adfox_166291290833645720"></div>
<script>
    window.yaContextCb.push(()=>{
        Ya.adfoxCode.createAdaptive({
            ownerId: 706490,
            containerId: 'adfox_166291290833645720',
	    type: 'floorAd',
            params: {
                p1: 'cvsmi',
                p2: 'hvif'
            }
        }, ['phone'], {
            tabletWidth: 830,
            phoneWidth: 480,
            isAutoReloads: false
        })
    })
</script>
</footer>
