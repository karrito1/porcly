function togglePassword(btn) {
    const wrap = btn.closest('.field-input-wrap');
    const input = wrap.querySelector('.field-input');
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    btn.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
}
