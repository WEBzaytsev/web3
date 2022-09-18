(function navTabs() {
    const tabs = [];
    const content = document.querySelector('.content-tabs-frame');

    const tabsElems = [
        ...document.querySelectorAll('.content-tabs__tab-url')
    ];

    tabsElems.forEach((t, idx) => {
        const id = t.getAttribute('href').slice(1);
        const isPaginated = t.dataset.hasOwnProperty('paginated');
        const isActive = t.parentElement.classList.contains('content-tabs__tab_active');
        tabs.push(
            new Proxy({
                id: id,
                page: Number((new URL(document.location)).searchParams.get('pg')) || 1,
                isActive: isActive,
                isPaginated: isPaginated,
                block() {
                    return document.querySelector(`#${this.id}`);
                },
                content() {
                    return this.block().querySelector('.content-tabs__tab-content');
                },
                tab() {
                    return document.querySelector(`a[href="#${this.id}"]`);
                },
                loadMoreBtn() {
                    return this.block().querySelector('.load-more') || false;
                },
                postsCount() {
                    return options[this.id];
                },
                postsInPage() {
                    if (this.content() && this.content().children.length) {
                        return this.content().children.length;
                    }

                    return false;
                },
                isLastPage() {
                    if (!Number(this.postsInPage())) {
                        return true;
                    }

                    return Number(this.postsInPage()) === Number(this.postsCount());
                },
                async loadMore(e) {
                    e.preventDefault();
                    this.page++;
                },
                tabHandler(e) {
                    e.preventDefault();

                    this.isActive = true;
                },
                init() {
                    const tab = this.tab();

                    tab.addEventListener('click', this.tabHandler.bind(this));
                    
                    if(this.isPaginated) {
                        if (this.isLastPage()) {
                            if (this.loadMoreBtn()) {
                                this.loadMoreBtn().parentElement.removeChild(this.loadMoreBtn());
                            }
    
                            return;
                        }
    
                        if (this.loadMoreBtn()) {
                            const loadMoreBtn = this.loadMoreBtn();
                            loadMoreBtn.addEventListener('click', this.loadMore.bind(this));
                            loadMoreBtn.style.display = "flex";
                        }
                    }
                }
            }, {
                async set(obj, prop, value) {
                    obj[prop] = value;

                    if (prop === 'page' && obj.isActive && value > 1) {
                        const btn = obj.loadMoreBtn()
                        const oldButtonHTML = btn.innerHTML;
                        btn.innerHTML = 'Загрузка..';

                        const nextPage = obj.page;
                        const posts = await getPosts(nextPage, obj.id);

                        if (posts) {
                            obj.content().insertAdjacentHTML('beforeend', await posts);
                            likes();
                            updateUrl(obj.id, obj.page, obj.isPaginated);
                        }

                        if (obj.isLastPage()) {
                            obj.loadMoreBtn().parentElement.removeChild(obj.loadMoreBtn());
                        }

                        btn.innerHTML = oldButtonHTML;
                    }

                    if (prop === 'isActive') {

                        if (value) {
                            tabs.forEach(t => {
                                if (t.id !== obj.id) {
                                    t.isActive = false;
                                }
                            });

                            obj.tab().parentElement.classList.add('content-tabs__tab_active');
                            obj.block().style.display = 'block';
                            updateUrl(obj.id, obj.page, obj.isPaginated);
                        } else {
                            obj.tab().parentElement.classList.remove('content-tabs__tab_active');
                            obj.block().style.display = 'none';
                        }
                    }

                    return true;
                },
            }),
        );

        tabs[idx].init();
    });

    content.style.display = 'block';

    function updateUrl(tab, page = 1, isPaginated) {
        this.page = Number(page);
        this.url = new URL(document.location);

        if (isPaginated) {
            if (this.page < 2) {
                if (this.url.searchParams.get('pg')) {
                    this.url.searchParams.delete('pg');
                }
            } else {
                this.url.searchParams.set('pg', this.page);
            }
        }

        this.url.searchParams.set('tab', tab);
        window.history.pushState(
            null,
            document.title,
            this.url
        );
    }

    async function getPosts(page = 2, tab = '') {
        const url = options.ajax_url;
        const sendOptions = {
            method: 'POST',
            body: new FormData(),
        };

        sendOptions.body.set('action', 'get_community_posts');
        sendOptions.body.set('nonce', options.get_community_posts);
        sendOptions.body.set('pg', page);
        sendOptions.body.set('tab', tab);
        if('author_id' in options) {
            sendOptions.body.set('author_id', options.author_id);
        }

        try {
            const request = await fetch(url, sendOptions);
            return await request.text();
        } catch (e) {
            return false;
        }
    }

    function likes() {
        const likes = [
            ...document.querySelectorAll('.pld-like-trigger.pld-like-dislike-trigger')
        ];

        likes.forEach(l => l.addEventListener('click', like));

        function like(e) {
            setTimeout(() => {
                this.classList.add('pld-prevent');
            }, 1300);
        }
    }

    likes();

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

    const switch_inputs = [
        ...document.querySelectorAll('.switcher input[type="checkbox"')
    ];
    
    switch_inputs.forEach(el => el.addEventListener('change', change_checkbox_value));

    function change_checkbox_value(e) {
        e.target.value = +e.target.checked;
    }

    /*
        const tabsWrap = document.getElementById('tabs-tab');
        const tabs = [
            ...tabsWrap.children
        ];
        const tabsContent = [
            ...document.querySelectorAll('.community-page__tab-content')
        ];

        if (!tabsWrap || !tabsWrap.firstChild) {
            return;
        }

        tabsWrap.addEventListener('click', tabHandler);

        function tabHandler(e) {
            const target = e.target;

            if (target.tagName.toLowerCase() !== 'a') {
                return;
            }

            e.preventDefault();

            const page = target.dataset.page;
            const contentId = getIdFromHref(target.getAttribute('href'));
            const currentTabIndex = findTabIndex(contentId);

            switchTabs(currentTabIndex);
            setQueryParam(contentId, page);
        }

        function getIdFromHref(href) {
            return href.slice(1);
        }

        function findTabIndex(tabId) {
            return tabsContent.findIndex(t => t.getAttribute('id') === tabId);
        }

        function switchTabs(currentIndex) {
            const currentContent = tabsContent[currentIndex];
            const currentTab = tabs[currentIndex];

            if (currentContent.style.display === 'block') {
                return;
            }

            tabsContent.forEach(t => t.style.display = 'none');
            tabs.forEach(t => t.classList.remove('active'));

            currentContent.style.display = 'block';
            currentTab.classList.add('active');
        }

        function setQueryParam(tabName, page) {
            const url = new URL(document.location);
            url.searchParams.set('tab', tabName);
            url.searchParams.set('pg', page);
            window.history.pushState(
                null,
                document.title,
                url
            );
        }*/
})();

/*
(function () {
    const tabsContentBlocks = [
        ...document.querySelectorAll('.community-page__tab-content')
    ];

    tabsContentBlocks.forEach(l => l.addEventListener('click', loadMore));

    async function loadMore(e) {
        const target = e.target;
        if (target.classList.contains('community-page__load-more')) {
            e.preventDefault();
            const id = this.getAttribute('id');
            const contentWrap = this.querySelector('.community-page__posts');

            const oldButtonHTML = target.innerHTML;
            target.innerHTML = 'Loading';

            const nextPage = getPage() + 1;
            const posts = await getPosts(nextPage, id);

            if (posts) {
                contentWrap.insertAdjacentHTML('beforeend', await posts);
                setPageQueryParam(nextPage);
                const activeTabLink = document.querySelector('.community-page__content_tab.active a');
                activeTabLink.dataset.page = nextPage;
            }

            target.innerHTML = oldButtonHTML;
        }
    }

    function setPageQueryParam(page) {
        const url = new URL(document.location);
        url.searchParams.set('pg', page);
        window.history.pushState(
            null,
            document.title,
            url
        );
    }

    function getPage() {
        const params = (new URL(document.location)).searchParams;
        return Number(params.get('pg')) || 1;
    }

    async function getPosts(page = 2, tab = '') {
        const url = options.ajax_url;
        const sendOptions = {
            method: 'POST',
            body: new FormData(),
        };

        sendOptions.body.set('action', 'get_community_posts');
        sendOptions.body.set('nonce', options.get_community_posts);
        sendOptions.body.set('pg', page);
        sendOptions.body.set('tab', tab);

        try {
            const request = await fetch(url, sendOptions);
            return await request.text();
        } catch (e) {
            return false;
        }
    }
})();*/
