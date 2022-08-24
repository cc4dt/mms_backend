require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { Link, Head } from "@inertiajs/inertia-vue3";

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faLocationDot, faClipboardList, faMoneyCheckDollar } from '@fortawesome/free-solid-svg-icons'

/* add icons to the library */
library.add(faLocationDot, faClipboardList,faMoneyCheckDollar)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mixin({ components: { InertiaLink: Link } })
            .mixin({ components: { InertiaHead: Head } })
            .mixin({ components: { fai: FontAwesomeIcon } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
