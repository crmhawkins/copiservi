import './bootstrap';

function qs(sel) {
  return document.querySelector(sel);
}

async function postHtml(url, payload) {
  const token = qs('meta[name="csrf-token"]')?.getAttribute('content');
  const res = await fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token ?? '',
      'Accept': 'text/html',
    },
    body: JSON.stringify(payload),
  });
  return await res.text();
}

document.addEventListener('DOMContentLoaded', () => {
  const panel = qs('[data-panel="copiservi"]');
  if (!panel) return;

  const usuarioInput = qs('#usuario');
  const copiasInput = qs('#copias');
  const output = qs('#comprobar_copias');

  async function comprobar() {
    if (!usuarioInput?.value) return;
    output.innerHTML = '<div class="text-sm text-white/80">Comprobando…</div>';
    output.innerHTML = await postHtml('/panel/comprobar', { usuario: usuarioInput.value });
  }

  async function hacerCopias() {
    if (!usuarioInput?.value || !copiasInput?.value) return;
    output.innerHTML = '<div class="text-sm text-white/80">Actualizando…</div>';
    output.innerHTML = await postHtml('/panel/copias', { usuario: usuarioInput.value, copias: Number(copiasInput.value) });
    usuarioInput.focus();
  }

  async function cargarBono(copias) {
    if (!usuarioInput?.value) return;
    output.innerHTML = '<div class="text-sm text-white/80">Cargando bono…</div>';
    output.innerHTML = await postHtml('/panel/bono', { usuario: usuarioInput.value, copias: Number(copias) });
    usuarioInput.focus();
  }

  usuarioInput?.addEventListener('change', comprobar);
  copiasInput?.addEventListener('change', hacerCopias);

  document.querySelectorAll('[data-bono]').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      cargarBono(btn.getAttribute('data-bono'));
    });
  });
});
