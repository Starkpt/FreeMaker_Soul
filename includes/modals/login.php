<!-- Login Form Modal -->
<div class="backdrop" id="login_backdrop">
  <form class="form wrapper" id="form_login" action="/actions/actions.php?act=login" method="POST">
    <div class="login_container">
      <div class="log_btn_container">
        <img id="close_login" class="close_msg" src="/assets/imgs/icons/close.png" alt="Close">
      </div>
      <div class="titulo">Login</div>
      <div class="input-box">
        <input type="text" id="name_login" name="nickname" placeholder="Email ou nome de utilizador" required>
        <img src="/assets/imgs/icons/login-avatar.png" alt="User icon">
      </div>
      <div class="input-box">
        <input type="password" id="pwd_login" name="password" placeholder="Password" required>
        <img class="eye" src="/assets/imgs/icons/closed-eye.png" alt="Show password">
      </div>
      <div class="remember-forgot">
        <label>
          <input type="checkbox" name="remember"> Lembrar-me
        </label>
        <a href="#">Esqueci a Password</a>
      </div>
      <button type="submit" class="btn">Login</button>
      <div class="register-link">
        Ainda não efetuou registo? <a id="registar" href="#">Registar</a>
      </div>
    </div>
  </form>
</div>