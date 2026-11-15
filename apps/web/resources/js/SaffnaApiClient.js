export class SaffnaApiError extends Error {
    constructor(status, payload = {}) {
        super(payload.message || 'Request failed');
        this.name = 'SaffnaApiError';
        this.status = status;
        this.code = payload.code || 'request_failed';
        this.errors = payload.errors || {};
        this.requestId = payload.request_id || null;
    }
}

export class SaffnaApiClient {
    constructor(locale = 'ar') {
        this.locale = locale;
    }

    setLocale(locale) {
        this.locale = locale === 'en' ? 'en' : 'ar';
    }

    me() {
        return this.request('/api/v1/me');
    }

    login(email, password, remember) {
        return this.request('/login', {
            method: 'POST',
            body: { email, password, remember },
        });
    }

    changePassword(currentPassword, password, passwordConfirmation) {
        return this.request('/api/v1/account/password', {
            method: 'PATCH',
            body: {
                current_password: currentPassword,
                password,
                password_confirmation: passwordConfirmation,
            },
        });
    }

    logout() {
        return this.request('/logout', { method: 'POST' });
    }

    async request(url, options = {}) {
        const headers = {
            Accept: 'application/json',
            'Accept-Language': this.locale,
        };
        const request = {
            method: options.method || 'GET',
            credentials: 'same-origin',
            headers,
        };

        if (options.body !== undefined) {
            headers['Content-Type'] = 'application/json';
            request.body = JSON.stringify(options.body);
        }

        if (request.method !== 'GET') {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            if (token) {
                headers['X-CSRF-TOKEN'] = token;
            }
        }

        const response = await fetch(url, request);
        const refreshedToken = response.headers.get('X-CSRF-TOKEN');
        const tokenElement = document.querySelector('meta[name="csrf-token"]');

        if (refreshedToken && tokenElement) {
            tokenElement.content = refreshedToken;
        }

        const payload = await response.json().catch(() => ({}));

        if (!response.ok) {
            throw new SaffnaApiError(response.status, payload);
        }

        return payload.data || {};
    }
}
