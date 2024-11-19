<!-- Bootstrap Login Modal -->
<div
  id="loginModal"
  class="modal fade"
  tabindex="-1"
  aria-labelledby="loginModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
        <form id="form_login" action="/actions/actions.php?act=login" method="POST">
          <!-- Email/Username Input -->
          <div class="mb-3">
            <label for="name_login" class="form-label">Email ou Nome de Utilizador</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="bi bi-person"></i>
              </span>
              <input
                type="text"
                id="name_login"
                name="nickname"
                class="form-control"
                placeholder="Email ou nome de utilizador"
                required />
            </div>
          </div>
          <!-- Password Input -->
          <div class="mb-3">
            <label for="pwd_login" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text">
                <i class="bi bi-lock"></i>
              </span>
              <input
                type="password"
                id="pwd_login"
                name="password"
                class="form-control"
                placeholder="Password"
                required />
              <button type="button" class="btn btn-outline-secondary toggle-password">
                <i class="bi bi-eye"></i>
              </button>
            </div>
          </div>
          <!-- Remember Me and Forgot Password -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember" />
              <label class="form-check-label" for="remember">Lembrar-me</label>
            </div>
            <a href="#">Esqueci a Password</a>
          </div>
          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <p class="mb-0">
          Ainda não efetuou registo? <a href="#" id="registar">Registar</a>
        </p>
      </div>
    </div>
  </div>
</div>


<script>
  // TODO: fix the icons being toggled
  $(document).on("click", ".toggle-password", function() {
    const input = $("#pwd_login");
    const type = input.attr("type") === "password" ? "text" : "password";
    input.attr("type", type);
    $(this).find("i").toggleClass("bi-eye bi-eye-slash");
  });
</script>