export default function saveMFA() {
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.querySelector('[data-mfa]');
        if (!toggle) return;

        let init = toggle.checked
        window.addEventListener('beforeunload', () => {
            let state = toggle.checked
            if (state === init) return;

            const payload = JSON.stringify({
                enabled: state
            })

            navigator.sendBeacon('/profile/mfa', payload)
        })

    })
}