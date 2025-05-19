export default function saveMFA() {
    document.addEventListener('DOMContentLoaded', () => {

        const toggle = document.querySelector('[data-mfa]');
        const btn = document.querySelector('[data-save]');

        if (!toggle || !btn) return;
        const init = toggle.checked;

        updateButton();

        toggle.addEventListener('change', () => {
            updateButton();
            toggle.value = toggle.checked ? "true" : "false";
        });

        function hasChanges() {
            return toggle.checked !== init
        }

        function updateButton() {
            btn.disabled = !hasChanges();
        }
    })
}