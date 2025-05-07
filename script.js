document.addEventListener("DOMContentLoaded", function () {
  console.log("Site carregado com sucesso!");

  const form = document.querySelector("form");

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      alert("Mensagem enviada com sucesso! Entraremos em contato em breve.");
      form.reset();
    });
  }
});
