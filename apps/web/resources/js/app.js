import 'bootstrap';

import { SaffnaIdentityApp } from './components/SaffnaIdentityApp.js';
import { SaffnaLoginForm } from './components/SaffnaLoginForm.js';
import { SaffnaSessionPanel } from './components/SaffnaSessionPanel.js';

if (!customElements.get('saffna-login-form')) {
    customElements.define('saffna-login-form', SaffnaLoginForm);
}

if (!customElements.get('saffna-session-panel')) {
    customElements.define('saffna-session-panel', SaffnaSessionPanel);
}

if (!customElements.get('saffna-identity-app')) {
    customElements.define('saffna-identity-app', SaffnaIdentityApp);
}
