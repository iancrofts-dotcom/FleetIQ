(() => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.navigation');
  const product = document.querySelector('.product-navigation');
  const closeProduct = () => { if (product) product.open = false; };
  const closeMenu = () => {
    toggle?.setAttribute('aria-expanded', 'false');
    nav?.classList.remove('is-open');
    closeProduct();
  };

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') !== 'true';
      toggle.setAttribute('aria-expanded', String(open));
      nav.classList.toggle('is-open', open);
      if (!open) closeProduct();
    });
    nav.addEventListener('click', event => {
      const link = event.target.closest('a');
      if (!link) return;
      closeMenu();
      // Move keyboard focus out of a menu that is about to become hidden.
      if (link.hash && link.pathname === location.pathname) {
        const target = document.getElementById(link.hash.slice(1));
        if (target) {
          if (!target.hasAttribute('tabindex')) {
            target.setAttribute('tabindex', '-1');
            target.addEventListener('blur', () => target.removeAttribute('tabindex'), { once: true });
          }
          target.focus({ preventScroll: true });
        }
      }
    });
    window.matchMedia('(min-width: 769px)').addEventListener('change', () => {
      const focusWasInside = nav.contains(document.activeElement);
      closeMenu();
      if (focusWasInside && getComputedStyle(toggle).display !== 'none') toggle.focus();
    });
  }

  document.addEventListener('keydown', event => {
    if (event.key !== 'Escape') return;
    if (product?.open) {
      closeProduct();
      product.querySelector('summary').focus();
    } else if (nav?.classList.contains('is-open')) {
      closeMenu();
      toggle.focus();
    }
  });
  document.addEventListener('click', event => {
    if (!event.target.closest('.header-inner')) closeMenu();
    else if (!event.target.closest('.product-navigation')) closeProduct();
  });
  product?.addEventListener('focusout', event => {
    if (!product.contains(event.relatedTarget)) closeProduct();
  });

  document.documentElement.classList.add('js');
  // PRG returns to #enquiry; announce the server result after fragment navigation.
  window.addEventListener('pageshow', () => {
    document.querySelector('.enquiry-panel .form-feedback')?.focus({ preventScroll: true });
  });
})();
