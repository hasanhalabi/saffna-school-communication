import { SaffnaApiClient, SaffnaApiError } from '../SaffnaApiClient.js';
import { saffnaTranslation } from '../SaffnaIdentityTranslations.js';

export class SaffnaIdentityApp extends HTMLElement {
    constructor() {
        super();
        this.locale = localStorage.getItem('saffna-locale') === 'en' ? 'en' : 'ar';
        this.api = new SaffnaApiClient(this.locale);
        this.state = 'loading';
        this.user = null;
        this.sessionTimer = null;
    }

    connectedCallback() {
        this.addEventListener('saffna-login-success', () => this.loadSession());
        this.addEventListener('saffna-logout-success', () => this.showLogin());
        this.addEventListener('saffna-session-expired', () => this.showLogin());
        this.render();
        this.loadSession();
    }

    disconnectedCallback() {
        this.stopSessionTimer();
    }

    applyLocale() {
        document.documentElement.lang = this.locale;
        document.documentElement.dir = this.locale === 'ar' ? 'rtl' : 'ltr';
        this.api.setLocale(this.locale);
    }

    async loadSession() {
        this.state = 'loading';
        this.render();

        try {
            const data = await this.api.me();
            this.user = data.user;
            this.locale = this.user.preferred_language === 'en' ? 'en' : 'ar';
            this.api.setLocale(this.locale);
            localStorage.setItem('saffna-locale', this.locale);
            this.state = 'authenticated';
            this.render();
            this.startSessionTimer();
        } catch (error) {
            if (error instanceof SaffnaApiError && error.status === 401) {
                this.showLogin();
                return;
            }

            this.state = 'error';
            this.render();
        }
    }

    showLogin() {
        this.stopSessionTimer();
        this.user = null;
        this.state = 'guest';
        this.render();
    }

    startSessionTimer() {
        this.stopSessionTimer();
        this.sessionTimer = window.setInterval(() => this.refreshSession(), 60_000);
    }

    stopSessionTimer() {
        if (this.sessionTimer !== null) {
            window.clearInterval(this.sessionTimer);
            this.sessionTimer = null;
        }
    }

    async refreshSession() {
        try {
            const data = await this.api.me();
            this.user = data.user;
        } catch (error) {
            if (error instanceof SaffnaApiError && error.status === 401) {
                this.showLogin();
            }
        }
    }

    changeLocale() {
        this.locale = this.locale === 'ar' ? 'en' : 'ar';
        localStorage.setItem('saffna-locale', this.locale);
        this.api.setLocale(this.locale);
        this.render();
    }

    render() {
        this.applyLocale();
        const text = saffnaTranslation(this.locale);

        this.innerHTML = `
            <main class="container py-4 py-md-5 saffna-shell">
                <header class="d-flex align-items-center justify-content-between gap-3 mb-4">
                    <div>
                        <p class="h4 mb-0 text-primary fw-bold">${text.brand}</p>
                        <p class="text-secondary mb-0">${text.subtitle}</p>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-language>${text.switchLanguage}</button>
                </header>
                <div data-content></div>
            </main>
        `;

        this.querySelector('[data-language]').addEventListener('click', () => this.changeLocale());
        const content = this.querySelector('[data-content]');

        if (this.state === 'loading') {
            content.innerHTML = `
                <div class="card border-0 shadow-sm saffna-card">
                    <div class="card-body p-5 text-center" role="status">
                        <span class="spinner-border text-primary mb-3" aria-hidden="true"></span>
                        <p class="mb-0">${text.loading}</p>
                    </div>
                </div>
            `;
            return;
        }

        if (this.state === 'error') {
            content.innerHTML = `<div class="alert alert-danger" role="alert">${text.sessionError}</div>`;
            return;
        }

        if (this.state === 'authenticated') {
            const panel = document.createElement('saffna-session-panel');
            content.append(panel);
            panel.configure(this.api, this.locale, this.user);
            return;
        }

        const form = document.createElement('saffna-login-form');
        content.append(form);
        form.configure(this.api, this.locale);
    }
}
