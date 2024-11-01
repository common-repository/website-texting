import Settings from './Components/Settings.vue';
import Activation from './Components/Tabs/Activation.vue';
import Visibility from './Components/Tabs/Visibility.vue';
import Appearance from './Components/Tabs/Appearance.vue';
import Instructions from './Components/Tabs/Instructions.vue';

export default [{
        path: '/',
        name: 'settings',
        component: Settings,
        children: [
            {
                path: '',
                redirect: 'activation',
            },
            {
                path: '/activation',
                name: 'activation',
                component: Activation,
            },
            {
                path: '/visibility',
                name: 'visibility',
                component: Visibility,
            },
            {
                path: '/appearance',
                name: 'appearance',
                component: Appearance,
            },
            {
                path: '/instructions',
                name: 'instructions',
                component: Instructions,
            }
        ],
    },
];