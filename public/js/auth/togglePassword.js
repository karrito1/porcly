function togglePassword(button) {
    const wrap = button.closest('.field-input-wrap');
    if (!wrap) return;
    const input = wrap.querySelector('input');
    if (!input) return;
    
    if (input.type === 'password') {
        input.type = 'text';
        button.classList.add('is-visible');
        button.setAttribute('aria-label', 'Ocultar contraseña');
    } else {
        input.type = 'password';
        button.classList.remove('is-visible');
        button.setAttribute('aria-label', 'Mostrar contraseña');
    }
}
