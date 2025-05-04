export function togglePassword() {
    document.querySelectorAll('[data-show]').forEach(btn => {
        btn.addEventListener('click', () => {
            const span = btn.previousElementSibling;
            if (!span) return;

            const password = span.getAttribute('data-password');
            const isHidden = !span.hasAttribute('data-visible');

            span.textContent = isHidden ? password : '•'.repeat(8);
            btn.textContent = isHidden ? 'Hide' : 'Show';

            if (isHidden) {
                span.setAttribute('data-visible', 'true');
                return;
            }

            span.removeAttribute('data-visible');
        });
    });
}

export function focusOnManage() {
    document.querySelectorAll('[data-manage]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalSelector = btn.getAttribute('data-bs-target');
            const modal = document.querySelector(modalSelector);

            const instance = bootstrap.Modal.getOrCreateInstance(modal);
            instance.show();

            modal.addEventListener('shown.bs.modal', () => {
                modal.querySelector('input')?.focus();
            }, { once: true });
        });
    });
}