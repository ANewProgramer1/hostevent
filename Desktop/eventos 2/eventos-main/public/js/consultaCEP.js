const cepInput = document.querySelector("#cep");
const ufInput = document.querySelector("#uf");
const cidadeInput = document.querySelector("#cidade");
const ruaInput = document.querySelector("#rua");
const bairroInput = document.querySelector("#bairro");

cepInput.addEventListener("keyup", async (e) => {
  const inputValue = e.target.value.replace(/\D+/g, '');

  if (inputValue.length === 8) {
    try {
      const numCep = cepInput.value;
      const url = `https://viacep.com.br/ws/${numCep}/json`;

      const response = await fetch(url);
      const dados = await response.json();

      console.log(dados.logradouro);
      ufInput.value = dados.uf;
      cidadeInput.value = dados.localidade;

      if (dados.logradouro !== '') {
        ruaInput.value = dados.logradouro;
      } else {
        ruaInput.removeAttribute('readonly');
      }

      bairroInput.value = dados.bairro || "centro";
    } catch (error) {
      console.error("Erro ao obter dados do CEP:", error);
    }
  }
});
