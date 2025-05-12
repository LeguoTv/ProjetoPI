document.addEventListener("DOMContentLoaded", () => {
    fetch("/projetopi/src/components/footer.html")
      .then((res) => res.text())
      .then((html) => {
        const footerContainer = document.createElement("div");
        footerContainer.innerHTML = html;
        document.body.appendChild(footerContainer); // adiciona ao final do body
  
        const link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = "/projetopi/src/styles/pasta Dos CSS/footer.css";
        document.head.appendChild(link);
      })
      .catch((err) => console.error("Erro ao carregar o footer:", err));
  });
  