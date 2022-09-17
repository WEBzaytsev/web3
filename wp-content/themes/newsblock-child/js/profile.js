(() => {
    const toggle_show_password_triggers = [
        ...document.querySelectorAll('.user-form__field_password span')
    ];

    toggle_show_password_triggers.forEach(el => el.addEventListener('click', toggle_show_password));

    function toggle_show_password(e) {
        let password_input = e.target.previousSibling;
        if(password_input) {
            if(password_input.type == 'password') {
                password_input.type = 'text';
            } else {
                password_input.type = 'password';
            }
        }
    }

    const popup_triggers = [
        ...document.querySelectorAll('.popup-trigger')
    ];
    
    popup_triggers.forEach(el => el.addEventListener('click', activate_popup_events));

    function activate_popup_events(e) {
        if(!document.querySelector('.overlay')) {
            document.body.insertAdjacentHTML('beforeend', '<div class="overlay"><div class="spinner"><div></div><div></div><div></div><div></div></div></div>');
            document.body.style.overflow = 'hidden';
            document.querySelector('.overlay').addEventListener('click', close_popup);
        }
    }

    close_popup = function(e) {
        let popup = document.querySelector('.popup');
        if(popup) {
            if(popup.id == 'uwp-popup-modal-wrap') {
                popup.display = 'none';
                placeholder = document.createElement('div');
                placeholder.id = 'uwp-popup-modal-wrap';
                placeholder.style.display = 'none';
                popup.replaceWith(placeholder);
            } else {
                popup.remove();
            }
            document.querySelector('.overlay').remove();
            document.body.style.overflowY = 'auto';
        }
    }
})();