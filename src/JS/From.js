// inicializa o EmailJS
emailjs.init("YIjEOLhSsCBRiLKj3"); // sua public key

const form = document.getElementById("formEmail");
form.addEventListener("submit", function (e) {
  e.preventDefault();

  emailjs
    .sendForm("service_gvw5cpn", "template_yls7rno", this)
    .then(
      function (response) {
        alert("Email enviado com sucesso!");
        form.reset();
      },
      function (error) {
        alert("Falha ao enviar: " + error.text);
        console.error("EmailJS error:", error);
      }
    );
});
