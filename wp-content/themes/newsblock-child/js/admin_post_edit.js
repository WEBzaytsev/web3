document.body.addEventListener( 'click', function(e) {
    if( e.target.classList.contains( 'editor-post-publish-button' ) ) {
        checkRankMathFields( e );
    }
}, true );

function checkRankMathFields( e ) {
    const repo = select( 'rank-math' );
    const title = repo.getTitle();
    const description = repo.getDescription();
    if ( '%title% %sep% %sitename%' === title ) {
        wp.data.dispatch( 'core/notices' ).createErrorNotice(
            'Не заполнен seo заголовок!', 
            {id: 'empty_seo_title_error'}
        );
        //e.stopPropagation();
    }
    if ( '' === description ) {
        wp.data.dispatch( 'core/notices' ).createErrorNotice(
            'Не заполнено seo описание!', 
            {id: 'empty_seo_description_error'}
        );
        //e.stopPropagation();
    }
}
