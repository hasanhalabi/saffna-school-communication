import { SaffnaApiError } from '../SaffnaApiClient.js';
import { saffnaTranslation } from '../SaffnaIdentityTranslations.js';

export class SaffnaSessionPanel extends HTMLElement {
    constructor() {
        super();
        this.api = null;
        this.locale = 'ar';
        this.user = null;
        this.submitting = false;
    }

    connectedCallback() {
        this.render();
    }

    configure(api, locale, user) {
        this.api = api;
        this.locale = locale;
        this.user = user;
        this.render();
    }

    render() {
        if (this.user === null) {
            this.replaceChildren();
            return;
        }

        const text = saffnaTranslation(this.locale);
        const group = text.groups[this.user.group] || this.user.group;

        this.innerHTML = `
            <section class="card border-0 shadow-sm saffna-card" aria-labelledby="saffna-session-heading">
                <div class="card-body p-4 p-md-5">
                    <p class="text-secondary mb-2">${text.currentSession}</p>
                    <h1 id="saffna-session-heading" class="h3 mb-1"><span data-welcome></span> <span data-name></span></h1>
                    <p class="text-secondary mb-4"><span data-email></span> · <span data-group></span></p>
                    <div class="alert alert-warning d-none" data-temporary-password role="status"></div>
                    <div class="alert alert-danger d-none" data-error role="alert"></div>
                    <button class="btn btn-outline-danger w-100" type="button" data-logout>
                        <i class="fa-solid fa-arrow-right-from-bracket me-2" aria-hidden="true"></i>
                        <span>${this.submitting ? text.signingOut : text.signOut}</span>
                    </button>
                </div>
            </section>
        `;

        this.querySelector('[data-welcome]').textContent = text.welcome;
        this.querySelector('[data-name]').textContent = this.user.name;
        this.querySelector('[data-email]').textContent = this.user.email;
        this.querySelector('[data-group]').textContent = group;

        if (this.user.must_change_password) {
            const warning = this.querySelector('[data-temporary-password]');
            warning.textContent = text.temporaryPassword;
            warning.classList.remove('d-none');
        }

        const button = this.querySelector('[data-logout]');
        button.disabled = this.submitting;
        button.addEventListener('click', () => this.logout());
    }

    async logout() {
        if (this.submitting || this.api === null) {
            return;
        }

        this.submitting = true;
        this.render();

        try {
            await this.api.logout();
            this.dispatchEvent(new CustomEvent('saffna-logout-success', {
                bubbles: true,
            }));
        } catch (error) {
            if (error instanceof SaffnaApiError && error.status === 401) {
                this.dispatchEvent(new CustomEvent('saffna-session-expired', {
                    bubbles: true,
                }));
                return;
            }

            this.submitting = false;
            this.render();
            const alert = this.querySelector('[data-error]');
            alert.textContent = error instanceof SaffnaApiError ? error.message : saffnaTranslation(this.locale).networkError;
            alert.classList.remove('d-none');
        }
    }
}
