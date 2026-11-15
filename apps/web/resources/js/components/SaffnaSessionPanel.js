import { SaffnaApiError } from '../SaffnaApiClient.js';
import { saffnaTranslation } from '../SaffnaIdentityTranslations.js';

export class SaffnaSessionPanel extends HTMLElement {
    constructor() {
        super();
        this.api = null;
        this.locale = 'ar';
        this.user = null;
        this.notice = null;
        this.passwordFormOpen = false;
        this.submitting = false;
    }

    connectedCallback() {
        this.render();
    }

    configure(api, locale, user, notice = null) {
        this.api = api;
        this.locale = locale;
        this.user = user;
        this.notice = notice;
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
                    <div class="alert alert-success d-none" data-success role="status"></div>
                    <div class="alert alert-danger d-none" data-error role="alert"></div>
                    <div data-password-actions></div>
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

        if (this.notice === 'passwordChanged') {
            const success = this.querySelector('[data-success]');
            success.textContent = text.passwordChanged;
            success.classList.remove('d-none');
        }

        this.renderPasswordActions();

        const button = this.querySelector('[data-logout]');
        button.disabled = this.submitting;
        button.addEventListener('click', () => this.logout());
    }

    renderPasswordActions() {
        const container = this.querySelector('[data-password-actions]');

        if (this.user.must_change_password || this.passwordFormOpen) {
            const form = document.createElement('saffna-password-change-form');
            container.append(form);
            form.configure(this.api, this.locale, this.user.must_change_password);
            return;
        }

        const button = document.createElement('button');
        button.className = 'btn btn-outline-primary w-100 mb-3';
        button.type = 'button';
        button.textContent = saffnaTranslation(this.locale).changePassword;
        button.addEventListener('click', () => {
            this.passwordFormOpen = true;
            this.render();
        });
        container.append(button);
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
