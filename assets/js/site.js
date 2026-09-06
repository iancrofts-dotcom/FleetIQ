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
      if (!link.dataset.dialog && link.hash && link.pathname === location.pathname) {
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
    if (event.key !== 'Escape' || document.querySelector('dialog[open]')) return;
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

  // Visible fallback sections become native dialogs only when supported.
  if (typeof HTMLDialogElement !== 'undefined' && typeof HTMLDialogElement.prototype.showModal === 'function') {
    document.querySelectorAll('.notice-panel').forEach(panel => {
      const dialog = document.createElement('dialog');
      for (const attribute of panel.attributes) dialog.setAttribute(attribute.name, attribute.value);
      dialog.append(...panel.childNodes);
      panel.replaceWith(dialog);
      let opener;
      document.querySelectorAll(`[data-dialog="${dialog.id}"]`).forEach(link => {
        link.setAttribute('aria-haspopup', 'dialog');
        link.addEventListener('click', event => {
          event.preventDefault();
          opener = link;
          dialog.showModal();
        });
      });
      dialog.querySelector('.dialog-close').addEventListener('click', () => dialog.close());
      dialog.addEventListener('close', () => {
        const visibleOpener = opener && opener.getClientRects().length > 0;
        (visibleOpener ? opener : toggle)?.focus({ preventScroll: true });
      });
      dialog.addEventListener('click', event => {
        const rect = dialog.getBoundingClientRect();
        if (event.target === dialog && (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom)) dialog.close();
      });
    });
  }
  document.documentElement.classList.add('js');
})();
