<div class="center" style="margin-top:6px;"> 

<span class="spin-icon" aria-hidden="true" title="Actualizando…"> 

<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"> 

<path d="M21 12a9 9 0 1 1-3.6-7.2"/> <polyline points="21 3 21 9 15 9"/> 

</svg> 

</span> 

</div> 


<style> 

/*.spin-icon { display:inline-block; color:#b7b75e; } */
.spin-icon { display:inline-block; color: var(--icono-color, #b7b75e); }
.spin-icon svg { animation: spin 1.15s linear infinite; } 
@keyframes spin { to { transform: rotate(360deg); } } 
@media (prefers-reduced-motion: reduce) { .spin-icon svg { animation: none; } } 

</style> 

<script> 

document.getElementById('btn-actualiza').addEventListener('click', function (e) { 

e.preventDefault();

 // no navegues todavía const a = this; a.setAttribute('aria-busy', 'true'); a.style.pointerEvents = 'none'; 
 // evita doble clic document.getElementById('upd-icon').hidden = false; 
 // muestra el icono 
 // deja un “tick” para que el icono pinte y luego navega setTimeout(function(){ window.location.href = a.href; }, 120); }); 
 
 </script>
 
 <script defer>
 
(function () {
  // asegúrate de que los nodos existen cuando corre el script
  const btn = document.getElementById('btn-actualiza');
  const box = document.getElementById('upd-icon');
  if (!btn || !box) return;

  btn.addEventListener('click', function (e) {
    // evita dobles clics
    if (this.dataset.loading === '1') return;
    this.dataset.loading = '1';

    e.preventDefault();             // no navegues aún
    box.hidden = false;             // ← aquí se muestra el icono
    setTimeout(() => {              // da un “tick” para que pinte
      window.location.href = this.href;
    }, 120);
  });
})();

</script>
