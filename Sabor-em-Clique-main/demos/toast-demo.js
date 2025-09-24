// Exemplo de toast visual para feedback
function showToast(msg, tempo = 3000) {
  let toast = document.createElement('div');
  toast.className = 'toast';
  toast.innerText = msg;
  document.body.appendChild(toast);
  setTimeout(() => toast.classList.add('show'), 100);
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 400);
  }, tempo);
}
// Exemplo de uso: showToast('Receita salva com sucesso!');
