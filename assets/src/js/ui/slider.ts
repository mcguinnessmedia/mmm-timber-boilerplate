import {qs, qsa} from '../core/dom.js';
import Swiper from "swiper";
import {A11y, Navigation} from "swiper/modules";

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