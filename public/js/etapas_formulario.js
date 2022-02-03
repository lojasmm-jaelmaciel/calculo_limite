/**
 * Esta parte do código é responsável por criar as etapas do formulário
 * Etapa 1 = dados pessoais
 * Etapa 2 = dados de endereço
 * Etapa 3 = dados da empresa
 * Etapa 4 = foto
 */
// executa a função load ao carrega a página
document.addEventListener("DOMContentLoaded", load);
// pega os botões de próximo e anterior
const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-next");
// pega a foto-label progress onde vai aparecer a linha de progresso do form
const progress = document.getElementById("progress");
// pega as divs que contemém partes do form
const formPassos = document.querySelectorAll(".form-step");
// pega as divs onde vai aparecer as blinhas numeradas
const progressSteps = document.querySelectorAll(".progress-step");
// pega o botão salvar, que é o botão que fará o submit do formulário
const btn_salvar = document.getElementById('btn-salvar');

/* a função load tira o evento de submit do formulário. Pois os botões de próximo e anterior 
acabam fazendo o submit do formulário */
function load() {
  const formulario = document.getElementById('formulario');
  formulario.addEventListener("submit", (event) => event.preventDefault());
}

/** habilita o submit novamente quando precionado enter (código 13) ou ao clicar o mouse sobre o botão salvar */
btn_salvar.addEventListener('keydown', event => {
  if (event.key == 13) {
    formulario.submit()
  }
});
btn_salvar.addEventListener('click', () => formulario.submit());

// numero de passos para chegar no final "progress-step"
let formPassosNum = 0;

/**
 * nextBtns e prevBtns incrementam e decrementam os passos chamando as atualizações
 * da barra de progresso e de formulário
 */
nextBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formPassosNum++;
    updateFormSteps();
    updateBarraProgresso();
  });
});

prevBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    formPassosNum--;
    updateFormSteps();
    updateBarraProgresso();
  });
});


// verifica se a div formStep tem a classe que lhe define como ativa, se sim, então ela é removida
// e a div formStep seguinte é adicionada a classe form-step-active para ser exibida
function updateFormSteps() {
  formPassos.forEach((formStep) => {
    formStep.classList.contains("form-step-active") &&
      formStep.classList.remove("form-step-active");
  });

  formPassos[formPassosNum].classList.add("form-step-active");
}

// adiciona ou remove a classe progress-setep-active nas divs que define a bolinha
// cinza ou vermelha conforme a valor de idx
function updateBarraProgresso() {
  progressSteps.forEach((progressStep, idx) => {
    if (idx < formPassosNum + 1) {
      progressStep.classList.add("progress-step-active");
    } else {
      progressStep.classList.remove("progress-step-active");
    }
  });

  const progressActive = document.querySelectorAll(".progress-step-active");
  // calcula a largura da barra de progresso e aplica os estilos de cor e altura da barra
  // var(--cor-vermelha) esse valor é definido dentro do CSS
  progress.style.width = ((progressActive.length - 1) / (progressSteps.length - 1)) * 100 + "%";
  progress.style.backgroundColor = "var(--cor-vermelha)";
  progress.style.height = "8px";
}
