import listen from './navbar.js'
import Application from './app.js';
import {togglePassword} from "./vault.js";
import saveMFA from "./profile.js";

activateListeners();
new Application().initialize();

function activateListeners() {
    listen();
    togglePassword();
    focusOnModal();
    saveMFA();
}


function focusOnModal() {
    document.querySelectorAll('[data-trigger]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalSelector = btn.getAttribute('data-bs-target');
            const modal = document.querySelector(modalSelector);

            if (!modal) return;

            const instance = bootstrap.Modal.getOrCreateInstance(modal);
            instance.show();

            modal.addEventListener('shown.bs.modal', () => {
                modal.querySelector('input')?.focus();
            }, {once: true});
        });
    });
}