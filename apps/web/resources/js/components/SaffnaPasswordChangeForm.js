import { SaffnaApiError } from '../SaffnaApiClient.js';
import { saffnaTranslation } from '../SaffnaIdentityTranslations.js';

export class SaffnaPasswordChangeForm extends HTMLElement {
    constructor() {
        super();
        this.api = null;
        this.locale = 'ar';
        this.requiredChange = false;
        this.submitting = false;
    }

    connectedCallback() {
        this.render();
    }

    configure(api, locale, requiredChange = false) {
        this.api = api;
        this.locale = locale;
        this.requiredChange = requiredChange;
        this.render();
    }

    render() {
        const text = saffnaTranslation(this.locale);

        this.innerHTML = `
            <section class="border rounded-3 p-3 p-md-4 mb-4" aria-labelledby="saffna-password-heading">
                <h2 id="saffna-password-heading" class="h5 mb-3">${text.changePassword}</h2>
                <div class="alert alert-warning ${this.requiredChange ? '' : 'd-none'}" role="status">
                    ${text.temporaryPassword}
                </div>
                <p class="text-secondary small">${text.passwordRequirements}</p>
                <div class="alert alert-danger d-none" data-error role="alert"></div>
                <form novalidate>
                    <div class="mb-3">
                        <label class="form-label" for="saffna-current-password">${text.currentPassword}</label>
                        <input class="form-control" id="saffna-current-password" name="current_password" type="password" autocomplete="current-password" required>
                        <div class="invalid-feedback" data-current-password-error></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="saffna-new-password">${text.newPassword}</label>
                        <input class="form-control" id="saffna-new-password" name="password" type="password" autocomplete="new-password" minlength="12" required>
                        <div class="invalid-feedback" data-password-error></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="saffna-password-confirmation">${text.confirmNewPassword}</label>
                        <input class="form-control" id="saffna-password-confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="12" required>
                        <div class="invalid-feedback" data-password-confirmation-error></div>
                    </div>
                    <button class="btn btn-primary w-100" type="submit" data-submit>
                        <i class="fa-solid fa-key me-2" aria-hidden="true"></i>
                        <span>${text.savePassword}</span>
                    </button>
                </form>
            </section>
        `;

        this.querySelector('form').addEventListener('submit', (event) => this.submit(event));
    }

    async submit(event) {
        event.preventDefault();

        if (this.submitting || this.api === null) {
            return;
        }

        const form = event.currentTarget;
        const currentPassword = form.elements.current_password.value;
        const password = form.elements.password.value;
        const passwordConfirmation = form.elements.password_confirmation.value;

        this.clearErrors();
        this.setSubmitting(true);

        try {
            await this.api.changePassword(currentPassword, password, passwordConfirmation);
            form.reset();
            this.dispatchEvent(new CustomEvent('saffna-password-change-success', {
                bubbles: true,
            }));
        } catch (error) {
            if (error instanceof SaffnaApiError && error.status === 401) {
                this.dispatchEvent(new CustomEvent('saffna-session-expired', {
                    bubbles: true,
                }));
                return;
            }

            this.setSubmitting(false);
            this.showError(error);
        }
    }

    setSubmitting(submitting) {
        this.submitting = submitting;
        const button = this.querySelector('[data-submit]');

        if (button === null) {
            return;
        }

        button.disabled = submitting;
        button.querySelector('span').textContent = submitting
            ? saffnaTranslation(this.locale).savingPassword
            : saffnaTranslation(this.locale).savePassword;
    }

    clearErrors() {
        this.querySelector('[data-error]').classList.add('d-none');

        for (const field of ['current_password', 'password', 'password_confirmation']) {
            const input = this.querySelector(`[name="${field}"]`);
            const feedback = this.querySelector(`[data-${field.replaceAll('_', '-')}-error]`);
            input.classList.remove('is-invalid');
            feedback.textContent = '';
        }
    }

    showError(error) {
        const text = saffnaTranslation(this.locale);
        const alert = this.querySelector('[data-error]');
        alert.textContent = error instanceof SaffnaApiError ? error.message : text.networkError;
        alert.classList.remove('d-none');

        if (! (error instanceof SaffnaApiError)) {
            return;
        }

        for (const field of ['current_password', 'password', 'password_confirmation']) {
            const messages = error.errors[field];

            if (! Array.isArray(messages) || messages.length === 0) {
                continue;
            }

            const input = this.querySelector(`[name="${field}"]`);
            const feedback = this.querySelector(`[data-${field.replaceAll('_', '-')}-error]`);
            input.classList.add('is-invalid');
            feedback.textContent = messages[0];
        }
    }
}
