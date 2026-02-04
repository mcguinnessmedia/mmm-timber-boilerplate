import {qsa} from '../core/dom.js';
import {createFocusTrap, type FocusTrap} from 'focus-trap';

type ModalMap = Map<string, HTMLElement>;

/**
 * Initializes
 *
 * @example
 * ```html
 * <button data-modal-open="contact">
 *   Open
 * </button>
 *
 * <div
 *   role="dialog"
 *   data-modal="contact"
 *   aria-modal="true"
 *   hidden
 * >
 *   <button data-modal-close>
 *     Close
 *   </button>
 *
 *   ... Content
 * </div>
 * ```
 */
export function initModals() {
  const modals: ModalMap = new Map();

  qsa<HTMLElement>('[data-modal]').forEach((modal) => {
    const id = modal.dataset.modal;
    if (id) modals.set(id, modal);
  })

  qsa<HTMLButtonElement>('[data-modal-open]').forEach((btn) => {
    const id = btn.dataset.modalOpen;
    const modal = id ? modals.get(id) : null;
    if (!modal) return;

    let trap: FocusTrap | null = null;

    const open = () => {
      modal.hidden = false;
      trap = createFocusTrap(modal);
      trap.activate();
    }

    const close = () => {
      modal.hidden = true;
      trap?.deactivate();
    }

    btn.addEventListener('click', open);

    qsa('[data-modal-close]', modal).forEach((closeBtn) => {
      closeBtn.addEventListener('click', close);
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') close();
    })
  })
}