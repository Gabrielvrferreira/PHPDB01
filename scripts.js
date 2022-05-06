/**
 * Quando clicar no botão 'id="passToggle"', se ele existe, chama a função 
 * 'togglePassword'.
 */
if (!!document.getElementById("passToggle")) passToggle.onclick = togglePassword;

/**
 * Função que mostra/oculta (toggle) o valor do campo senha do usuário.
 */
function togglePassword() {
    if (password.type == 'password') {

        // Se o campo é do tipo 'password', troca para o tipo 'text'.
        password.type = 'text';

        // Troca o ícone do botão.
        passToggle.innerHTML = '<i class="fa-solid fa-eye-slash fa-fw"></i>';

    } else {

        // Senão, o campo será do tipo 'password'.
        password.type = 'password';

        // Troca o ícone do botão.
        passToggle.innerHTML = '<i class="fa-solid fa-eye fa-fw"></i>';

    }

    // Sai da função sem fazer mais nada.
    return false;
}