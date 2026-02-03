import {qs, qsa} from '../core/dom.js';
import Swiper from "swiper";
import {A11y, Navigation} from "swiper/modules";

/**
 * Initializes all Swiper instances on the page.
 * Configure via data properties.
 *
 * @example
 * ```html
 * <div class='swiper'
 *   data-slider-navigation="true"
 *   data-slider-loop="true"
 * >
 *   <div class='swiper-wrapper'>
 *     <div class='swiper-slide'>
 *       Slide content
 *     </div>
 *   </div>
 *
 *   <button class="swiper-button-prev"></button>
 *   <button class="swiper-button-next"></button>
 * </div>
 * ```
 */
export function initSliders() {
  qsa<HTMLElement>('.swiper').forEach((instance) => {
    new Swiper(instance, {
      modules: [Navigation, A11y],
      loop: instance.dataset.sliderLoop === 'true',
      navigation: instance.dataset.sliderNavigation === 'true' && {
        prevEl: qs<HTMLButtonElement>('button.swiper-button-prev', instance),
        nextEl: qs<HTMLButtonElement>('button.swiper-button-next', instance),
      }
    })
  });
}