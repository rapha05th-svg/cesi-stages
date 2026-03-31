(function () {
    'use strict';

    function showError(input, message) {
        clearError(input);
        input.classList.add('input-error');
        const err = document.createElement('span');
        err.className = 'validation-error';
        err.textContent = message;
        input.parentNode.insertBefore(err, input.nextSibling);
    }

    function clearError(input) {
        input.classList.remove('input-error');
        const next = input.nextSibling;
        if (next && next.className === 'validation-error') next.remove();
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validatePhone(phone) {
        return phone === '' || /^[\d\s\+\-\(\)\.]{7,20}$/.test(phone);
    }

    function validateField(input) {
        clearError(input);
        const val = input.value.trim();
        const name = input.name || '';
        const type = input.type || 'text';
        const required = input.hasAttribute('required');
        const minlen = parseInt(input.getAttribute('minlength') || '0');
        const maxlen = parseInt(input.getAttribute('maxlength') || '99999');
        const min = parseFloat(input.getAttribute('min') || '-Infinity');
        const max = parseFloat(input.getAttribute('max') || 'Infinity');

        if (required && val === '') {
            showError(input, 'Ce champ est obligatoire.');
            return false;
        }
        if (val === '') return true;
        if (type === 'email' && !validateEmail(val)) {
            showError(input, 'Adresse email invalide.');
            return false;
        }
        if (name === 'phone' && !validatePhone(val)) {
            showError(input, 'Numéro de téléphone invalide.');
            return false;
        }
        if (minlen > 0 && val.length < minlen) {
            showError(input, 'Minimum ' + minlen + ' caractères requis.');
            return false;
        }
        if (val.length > maxlen) {
            showError(input, 'Maximum ' + maxlen + ' caractères autorisés.');
            return false;
        }
        if (type === 'number') {
            const num = parseFloat(val);
            if (isNaN(num)) { showError(input, 'Valeur numérique invalide.'); return false; }
            if (num < min) { showError(input, 'La valeur minimale est ' + min + '.'); return false; }
            if (num > max) { showError(input, 'La valeur maximale est ' + max + '.'); return false; }
        }
        if (type === 'password' && name === 'new_password' && val.length < 8) {
            showError(input, 'Le mot de passe doit contenir au moins 8 caractères.');
            return false;
        }
        return true;
    }

    function validatePasswordConfirm(form) {
        const newPwd = form.querySelector('[name="new_password"]');
        const confirmPwd = form.querySelector('[name="confirm_password"]');
        if (!newPwd || !confirmPwd) return true;
        if (newPwd.value !== confirmPwd.value) {
            showError(confirmPwd, 'Les mots de passe ne correspondent pas.');
            return false;
        }
        return true;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input, textarea, select').forEach(function (input) {
            if (input.type === 'hidden' || input.type === 'submit') return;
            input.addEventListener('blur', function () { validateField(input); });
            input.addEventListener('input', function () {
                if (input.classList.contains('input-error')) validateField(input);
            });
        });

        document.querySelectorAll('form').forEach(function (form) {
            if (form.classList.contains('no-validate')) return;
            form.addEventListener('submit', function (e) {
                let valid = true;
                form.querySelectorAll('input, textarea, select').forEach(function (input) {
                    if (input.type === 'hidden' || input.type === 'submit') return;
                    if (!validateField(input)) valid = false;
                });
                if (!validatePasswordConfirm(form)) valid = false;
                if (!valid) {
                    e.preventDefault();
                    const firstError = form.querySelector('.input-error');
                    if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });
    });
})();