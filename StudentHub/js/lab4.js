document.addEventListener('DOMContentLoaded',()=>{
  const banner=document.getElementById('notificationBanner');
  document.getElementById('closeBanner')?.addEventListener('click',()=>banner?.remove());
  document.querySelectorAll('[data-modal-target]').forEach(btn=>btn.addEventListener('click',()=>{
    const modal=document.querySelector(btn.dataset.modalTarget); if(modal) new bootstrap.Modal(modal).show();
  }));
  const slides=[...document.querySelectorAll('.hub-slide')]; let current=0;
  const showSlide=i=>slides.forEach((s,n)=>s.classList.toggle('active',n===i));
  document.getElementById('slideNext')?.addEventListener('click',()=>{current=(current+1)%slides.length;showSlide(current)});
  document.getElementById('slidePrev')?.addEventListener('click',()=>{current=(current-1+slides.length)%slides.length;showSlide(current)});
  if(slides.length>1)setInterval(()=>{current=(current+1)%slides.length;showSlide(current)},5000);
  document.querySelectorAll('.faq-question').forEach(btn=>btn.addEventListener('click',()=>{
    const item=btn.closest('.faq-item'); const open=item.classList.toggle('open'); btn.setAttribute('aria-expanded',open);
  }));
});
