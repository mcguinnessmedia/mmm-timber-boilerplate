import {qs} from "../core/dom.js";
import {lockScroll, unlockScroll} from "../utils/scroll-lock.js";

/**
 * Initialize the page's responsive navigation.
 *
 * @example
 * ```html
 * <button
 *   data-nav-toggle
 *   aria-expanded="false"
 *   aria-controls="site-nav"
 * >
 *  Toggle Menu
 * </button>
 *
 * <nav id="site-nav" data-nav-panel hidden>
 *  ... nav items go here
 * </nav>
 * ```
 *
 * @param root
 */
export function initNav(root: HTMLElement = document.body) {
  const toggle = qs<HTMLButtonElement>('[data-nav-toggle]', root);
  const panel = qs<HTMLElement>('[data-nav-panel]', root);

  if (!toggle || !panel) return;

  const open = () => {
    panel.hidden = false;
    toggle.setAttribute('aria-expanded', 'true');
    lockScroll();
  }

  const close = () => {
    panel.hidden = true;
    toggle.setAttribute('aria-expanded', 'false');
    unlockScroll();
  }

  toggle.addEventListener('click', () => {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    expanded ? close() : open();
  })

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  })
}