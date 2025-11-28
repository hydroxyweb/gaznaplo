import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from '@leafphp/vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n';
import './register-service-worker';

const appName = import.meta.env.VITE_APP_NAME || 'Leaf PHP';
const savedLang = localStorage.getItem('lang')

const i18n = createI18n({
  legacy: false,
  locale: savedLang ?? 'hu',
  fallbackLocale: 'en',
  messages: {
    hu: {
        'add-log-entry': {
            'title': 'Új óraállás rögzítése',
            'amount': 'Óraállás',
            'date': 'Dátum',
            'is-reported': 'Diktálva',
            'send': 'Hozzáadás',
            'success': 'Az új óraállás sikeresen rögzítve',
            'success-offline': 'Az új óraállás eltárolásra került későbbi szinkronizáció céljából',
            'all-synced': 'Minden eltárolt leolvasás szinkronizálásra került',
        },
        'theme-toggle': {
            'dark-mode': 'Váltás sötét módra',
            'light-mode': 'Váltás világos módra'
        },
        'month-selector': {
            'choose-other': 'Másik hónap statisztikája'
        },
        'month-statistic': {
            'discounted-amount': 'Kedvezményes mennyiség',
            'consumption': 'Eddigi fogyasztás',
            'remaining-discounted-amount': 'Még felhasználható kedv.m.',
            'overconsumption': 'Túlfogyasztott mennyiség',
            'last-reported': 'Legutóbbi bediktált óraállás',
            'last-readed': 'Legutóbbi leolvasott óraállás',
            'clock-setting': 'Javasolt időzítő beállítás'
        },
        'all-entries': {
            'title': 'Leolvasások',
            'date': 'Dátum',
            'amount': 'Menny.',
            'consumption': 'Fogy.',
            'average-consumption': 'Napi.átl.f.',
            'show-all': 'Összes rekord megjelenítése',
            'close': 'Összecsuk',
        },
        'general': {
            'error': 'Hiba történt',
            'unknown-error': 'Ismeretlen hiba',
            'cancel': 'Mégse',
            'app-name': 'GázNapló',
            'loading': 'Betöltés...',
        },
        'delete-cache': {
            'action': 'Cache törlése',
        },
        'characteristic-curve': {
            'title': 'Jelleggörbe',
            'month': 'Hónap',
            'amount': 'Kedv.menny.',
            'clock-settings': 'Id.beá.',
        }
    },

    en: {
        'add-log-entry': {
            'title': 'Add New Gas Reading',
            'amount': 'Meter Reading',
            'date': 'Date',
            'is-reported': 'Submitted to Provider',
            'send': 'Save',
            'success': 'Your gas reading has been saved successfully',
            'success-offline': 'The new reading has been stored for later synchronization', 
            'all-synced': 'All stored readings have been synchronized',
        },
        'theme-toggle': {
            'dark-mode': 'Switch to Dark Mode',
            'light-mode': 'Switch to Light Mode',
        },
        'month-selector': {
            'choose-other': 'View Statistics for Another Month',
        },
        'month-statistic': {
            'discounted-amount': 'Discounted Allowance',
            'consumption': 'Current Consumption',
            'remaining-discounted-amount': 'Remaining Discounted Amount',
            'overconsumption': 'Excess Consumption',
            'last-reported': 'Last Reported Reading',
            'last-readed': 'Last Recorded Reading',
            'clock-setting': 'Suggested Timer Setting',
        },
        'all-entries': {
            'title': 'Readings',
            'date': 'Date',
            'amount': 'Value',
            'consumption': 'Usage',
            'average-consumption': 'Daily Avg.U.',
            'show-all': 'Show All Records',
            'close': 'Collapse',
        },
        'general': {
            'error': 'Error',
            'unknown-error': 'Unknown Error',
            'cancel': 'Cancel',
            'app-name': 'GasNote',
            'loading': 'Loading...',
        },
        'delete-cache': {
            'action': 'Delete cache',
        },
        'characteristic-curve': {
            'title': 'Characteristic curve',
            'month': 'Month',
            'amount': 'Disc.am.',
            'clock-settings': 'Cl.St.',
        }
    }
  }
})

createInertiaApp({
    title: (title) => `${title ?? title + ' - '}${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob('./pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(i18n)
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#3eaf7c',
    },
});
