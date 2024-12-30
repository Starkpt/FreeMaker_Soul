// Scroll to Top Function
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// Initialize jQuery
$(document).ready(function () {
  // Toggle Password Visibility
  function setupPasswordToggle(buttonClass, inputName) {
    $(buttonClass)
      .on("mousedown", function () {
        $(this).attr("src", "imgs/icons/eye.png");
        $(`input[name="${inputName}"]`).attr("type", "text");
      })
      .on("mouseup mouseleave", function () {
        $(this).attr("src", "imgs/icons/closed-eye.png");
        $(`input[name="${inputName}"]`).attr("type", "password");
      });
  }
  setupPasswordToggle(".eye", "password");
  setupPasswordToggle(".re_eye", "re_password");

  // Form Validation Handler
  function setupFormValidation(formId, fields) {
    $(formId).on("submit", function () {
      let valid = true;
      fields.forEach(({ selector, errorIndex }) => {
        let input = $(selector);
        let errorMsg = document.getElementsByClassName(`${formId.slice(1)}_error_msg`)[errorIndex];
        let inputBox = document.getElementsByClassName("input-box")[errorIndex];

        if ($.trim(input.val()) === "") {
          errorMsg.style.display = "block";
          inputBox.style.borderColor = "red";
          input.val("").focus();
          valid = false;
        } else {
          input.on("input", function () {
            errorMsg.style.display = "none";
            inputBox.style.borderColor = "green";
          });
        }
      });
      return valid;
    });
  }

  // Setup Validation for Login & Signup
  setupFormValidation("#login-form", [
    { selector: "#name-login-form", errorIndex: 0 },
    { selector: "#pwd_login", errorIndex: 1 },
  ]);
  setupFormValidation("#form_signup", [
    { selector: "#name_signup", errorIndex: 0 },
    { selector: "#email_signup", errorIndex: 1 },
    { selector: "#pwd_signup", errorIndex: 2 },
    { selector: "#re_pwd_signup", errorIndex: 3 },
  ]);

  // Handle Signup Password Match Validation
  $("#form_signup").on("submit", function () {
    let pwd1 = $("#pwd_signup");
    let pwd2 = $("#re_pwd_signup");
    let inputBox = document.getElementsByClassName("input-box");

    if (pwd1.val() !== pwd2.val()) {
      $(".signup_error_msg")[3].style.display = "block";
      inputBox[4].style.borderColor = "red";
      inputBox[5].style.borderColor = "red";
      pwd1.val("");
      pwd2.val("");
      pwd1.focus();
      return false;
    }
  });

  // Display Message Container with Backdrop
  const url = new URL(window.location.href);
  if (url.searchParams.has("msg")) {
    url.searchParams.delete("msg");
    history.replaceState(null, "", url);
  }

  // Redirect to Add Product
  $("#add").on("click", function (e) {
    e.preventDefault();
    window.location.href = "public/products/add_product.php";
  });
});
