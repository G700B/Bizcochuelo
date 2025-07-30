document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("form-login");
  const emailInput = document.getElementById("email");
  const claveInput = document.getElementById("clave");

 
  emailInput.addEventListener("input", function () {
    const val = emailInput.value.trim();
    if (!val.endsWith("@gmail.com")) {
      mostrarError(emailInput, "Usá una cuenta de correo @gmail.com");
    } else {
      limpiarError(emailInput);
    }
  });

  claveInput.addEventListener("input", function () {
    const val = claveInput.value;
    if (val.length < 8) {
      mostrarError(claveInput, "La contraseña debe tener mínimo 8 caracteres");
    } else {
      limpiarError(claveInput);
    }
  });

  form.addEventListener("submit", function (e) {
    let valid = true;

    const emailVal = emailInput.value.trim();
    if (!emailVal.endsWith("@gmail.com")) {
      mostrarError(emailInput, "Usá una cuenta de correo @gmail.com");
      valid = false;
    } else {
      limpiarError(emailInput);
    }

    const claveVal = claveInput.value;
    if (claveVal.length < 8) {
      mostrarError(claveInput, "La contraseña debe tener mínimo 8 caracteres");
      valid = false;
    } else {
      limpiarError(claveInput);
    }

    if (!valid) {
      e.preventDefault();
    }
  });


  function mostrarError(input, mensaje) {
    input.classList.add("is-invalid");
    input.classList.remove("is-valid");

    let feedback = input.nextElementSibling;
    if (!feedback || !feedback.classList.contains("invalid-feedback")) {
      feedback = document.createElement("div");
      feedback.className = "invalid-feedback";
      input.parentNode.appendChild(feedback);
    }
    feedback.textContent = mensaje;
  }

 
  function limpiarError(input) {
    input.classList.remove("is-invalid");
    input.classList.add("is-valid");

    let feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains("invalid-feedback")) {
      feedback.remove();
    }
  }
});
