import { SaffnaApiError } from '../SaffnaApiClient.js';
import { saffnaTranslation } from '../SaffnaIdentityTranslations.js';

export class SaffnaLoginForm extends HTMLElement {
    constructor() {
        super();
        this.api = null;
        this.locale = 'ar';
        this.submitting = false;
        this.email = '';
    }

    connectedCallback() {
        this.render();
    }

    configure(api, locale) {
        this.api = api;
        this.locale = locale;
        this.render();
    }

    render() {
        const text = saffnaTranslation(this.locale);

        this.innerHTML = `
            <section class="card border-0 shadow-sm saffna-card" aria-labelledby="saffna-login-heading">
                <div class="card-body p-4 p-md-5">
                    <h1 id="saffna-login-heading" class="h3 mb-4">${text.signIn}</h1>
                    <div class="alert alert-danger d-none" data-error role="alert" tabindex="-1"></div>
                    <form data-form novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="saffna-email">${text.email}</label>
                            <input class="form-control" id="saffna-email" name="email" type="email" autocomplete="username" required>
                            <div class="invalid-feedback" data-email-error></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="saffna-password">${text.password}</label>
                            <input class="form-control" id="saffna-password" name="password" type="password" autocomplete="current-password" required>
                            <div class="invalid-feedback" data-password-error></div>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" id="saffna-remember" name="remember" type="checkbox">
                            <label class="form-check-label" for="saffna-remember">${text.remember}</label>
                        </div>
                        <button class="btn btn-primary w-100" type="submit" data-submit>
                            <i class="fa-solid fa-right-to-bracket me-2" aria-hidden="true"></i>
                            <span>${this.submitting ? text.signingIn : text.signIn}</span>
                        </button>
                    </form>
                </div>
            </section>
        `;

        const form = this.querySelector('[data-form]');
        const submit = this.querySelector('[data-submit]');
        form.elements.email.value = this.email;
        submit.disabled = this.submitting;
        form?.addEventListener('submit', (event) => this.submit(event));
    }

    async submit(event) {
        event.preventDefault();

        if (this.submitting || this.api === null) {
            return;
        }

        const form = event.currentTarget;
        const email = form.elements.email.value.trim();
        const password = form.elements.password.value;
        const remember = form.elements.remember.checked;

        this.clearErrors();
        this.email = email;
        this.submitting = true;
        this.render();

        try {
            await this.api.login(email, password, remember);
            this.dispatchEvent(new CustomEvent('saffna-login-success', {
                bubbles: true,
            }));
        } catch (error) {
            this.submitting = false;
            this.render();
            this.showError(error);
        }
    }

    clearErrors() {
        this.querySelectorAll('.is-invalid').forEach((element) => element.classList.remove('is-invalid'));
        this.querySelector('[data-error]')?.classList.add('d-none');
    }

    showError(error) {
        const text = saffnaTranslation(this.locale);
        const alert = this.querySelector('[data-error]');

        if (error instanceof SaffnaApiError) {
            alert.textContent = error.message;

            for (const field of ['email', 'password']) {
                const message = error.errors?.[field]?.[0];

                if (message) {
                    const input = this.querySelector(`[name="${field}"]`);
                    const feedback = this.querySelector(`[data-${field}-error]`);
                    input?.classList.add('is-invalid');
                    feedback.textContent = message;
                }
            }
        } else {
            alert.textContent = text.networkError;
        }

        alert.classList.remove('d-none');
        alert.focus();
    }
}
