<!-- Signup Form Modal -->
<div class="backdrop" id="signup_backdrop">
    <form class="form wrapper" id="form_signup" action="/actions/actions.php?act=register" method="POST">
        <div class="titulo">Registar</div>
        <div class="input-box">
            <input type="text" name="nickname" placeholder="Nome de utilizador" required>
            <img src="/assets/imgs/icons/login-avatar.png" alt="User icon">
        </div>
        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
            <img src="/assets/imgs/icons/at.png" alt="Email icon">
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="Password" minlength="8" required>
            <img class="eye" src="/assets/imgs/icons/closed-eye.png" alt="Show password">
        </div>
        <div class="input-box">
            <input type="password" name="re_password" placeholder="Repetir password" required>
            <img class="re_eye" src="/assets/imgs/icons/closed-eye.png" alt="Show password">
        </div>
        <button type="submit" class="btn">Registar</button>
    </form>
</div>