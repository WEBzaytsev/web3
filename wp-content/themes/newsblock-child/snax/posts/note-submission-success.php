<?php
/**
 * Template for displaying a success note after submitting new post
 *
 * @package snax 1.11
 * @subpackage Theme
 */

// Prevent direct script access.
if (!defined('ABSPATH')) {
    die('No direct script access allowed');
}
?>
<div class="snax-extend hide"
     data-close="true">
    <div class="snax-note snax-note-success snax-extend__wrap">
        <!--        <div class="snax-note-icon"></div>-->

        <div class="snax-extend__icon">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="40" r="40" fill="#808EF5"/>
                <path d="M48.84 34.61C48.3292 34.099 47.7228 33.6936 47.0554 33.4171C46.3879 33.1405 45.6725 32.9982 44.95 32.9982C44.2275 32.9982 43.5121 33.1405 42.8446 33.4171C42.1772 33.6936 41.5708 34.099 41.06 34.61L40 35.67L38.94 34.61C37.9083 33.5783 36.509 32.9987 35.05 32.9987C33.591 32.9987 32.1917 33.5783 31.16 34.61C30.1283 35.6417 29.5487 37.041 29.5487 38.5C29.5487 39.959 30.1283 41.3583 31.16 42.39L32.22 43.45L40 51.23L47.78 43.45L48.84 42.39C49.351 41.8792 49.7563 41.2728 50.0329 40.6053C50.3095 39.9379 50.4518 39.2225 50.4518 38.5C50.4518 37.7775 50.3095 37.0621 50.0329 36.3946C49.7563 35.7272 49.351 35.1208 48.84 34.61V34.61Z"
                      stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>


        <?php if (1 === snax_get_user_post_count()) : ?>
            <h2 class="snax-note-title"><?php esc_html_e('You\'ve submitted your first post!', 'snax'); ?></h2>
        <?php else : ?>
            <h2 class="snax-note-title"><?php esc_html_e('Thank you for submitting!', 'snax'); ?></h2>
        <?php endif; ?>

        <p class="snax-extend__text">
            <?php if (snax_is_post_pending_for_review()) : ?>
                <?php esc_html_e('Your post is awaiting moderation.', 'snax'); ?>

                <?php
                $user_posts_page_url = snax_get_user_pending_posts_page();

                if (!empty($user_posts_page_url)) {
                    printf(wp_kses_post(__('You can check the status of your post on <a href="%s">your profile page</a>.', 'snax')), esc_url($user_posts_page_url));
                }
                ?>
            <?php else : ?>
                <?php
                $user_posts_page_url = snax_get_user_approved_posts_page();

                if (!empty($user_posts_page_url)) {
                    printf(wp_kses_post(__('You can view all your posts on <a href="%s">your profile page</a>.', 'snax')), esc_url($user_posts_page_url));
                }
                ?>
            <?php endif; ?>
        </p>
        <p style="font-size: 16px;">Текст проходит модерацию, скоро вам придет уведомление на Email с решением.</p>

        <button class="snax-extend__button"
                data-close="true">
            <?php esc_html_e('ОК!'); ?>
        </button>
    </div>
</div>

<style>
    .snax-extend {
        position: fixed;
        z-index: 10000;
        top: 0;
        height: 100%;
        left: 0;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.7);
        transition: all ease-in-out .3s;
        opacity: 1;
    }

    .snax-extend.hide {
        opacity: 0;
    }

    .snax-extend__wrap {
        background-color: #fff;
        width: 430px;
        padding: 60px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        transition: all linear .3s;
    }

    .snax-extend.hide .snax-extend__wrap {
        transform: translateY(-200vh);
    }

    .snax-extend__icon {
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .snax-extend .snax-note-title {
        margin-bottom: 18px;
        font-weight: bold;
        font-size: 20px;
        line-height: 25px;
    }

    .snax-extend__text {
        font-size: 16px;
        line-height: 24px;
        max-width: 65%;
        margin: 0 auto 34px;
    }

    .snax-extend__button {
        background-color: #000;
        display: block;
        margin: 0 auto;
        min-width: 160px;
        width: fit-content;
        text-align: center;
        font-size: 16px;
        line-height: 24px;
        cursor: pointer;
        user-select: none;
        padding: 12px;
    }

    @media(max-width: 450px) {
        .snax-extend__wrap {
            width: 90%;
            padding: 30px 10px;
        }

        .snax-extend__icon {
            margin-bottom: 20px;
        }
    }
</style>

<script>
    (function () {
        const snaxModal = document.querySelector('.snax-extend');
        const url = new URL(window.location.href);

        if (!snaxModal) {
            return;
        }

        snaxModal.addEventListener('click', close);

        snaxModal.classList.remove('hide');
        document.body.style.overflowY = 'hidden';

        function close(e) {
            e.preventDefault();
            const target = e.target;

            if (!target.dataset.close) {
                return;
            }

            this.classList.add('hide');
            document.body.style.overflowY = 'auto';

            setTimeout(() => {
                this.removeEventListener('click', close);
                this.parentElement.removeChild(this);

                //TODO: uncomment 2 lines below for removing "snax_post_submission" search param
                // url.searchParams.delete('snax_post_submission');
                // window.history.pushState(null, document.title, url);
            }, 2000);
        }
    })();
</script>