import { registerPlugin } from '@wordpress/plugins';
import { PluginPostStatusInfo } from '@wordpress/edit-post';
import { Button } from '@wordpress/components';
const { getCurrentPostId } = wp.data.select('core/editor');

const PluginPostStatusInfoDenyButton = () => (
    <PluginPostStatusInfo>
        <Button variant="secondary" isDestructive="true" onClick={denyPost}>
            Отклонить пост
        </Button>
    </PluginPostStatusInfo>
);

registerPlugin( 'post-status-info-deny-button', { render: PluginPostStatusInfoDenyButton } );

async function denyPost() {
    const post_id = getCurrentPostId();
    const url = options.ajax_url;
    const sendOptions = {
        method: 'POST',
        body: new FormData(),
    };
    sendOptions.body.set( 'action', 'deny_post' );
    sendOptions.body.set( 'post_id', post_id );
    sendOptions.body.set( 'nonce', options.deny_post_nonce );
    try {
        const response = await fetch( url, sendOptions );
        const data = await response.json();
        if( data.success ) {
            window.location.href = '/wp-admin/edit.php?post_status=pending&post_type=post';
            return;
        } else {
            showNotice();
            return;
        }
    } catch (e) {
        showNotice();
        return;
    }
}

function showNotice() {
    wp.data.dispatch( 'core/notices' ).createErrorNotice(
        'Произошла непредвиденная ошибка, перезагрузите страницу и попробуйте еще раз.', 
        {id: 'deny_post_error'}
    );
}