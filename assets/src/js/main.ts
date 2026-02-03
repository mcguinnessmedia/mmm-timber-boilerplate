import {qs, qsa} from "./core/dom.js";
import Swiper from "swiper";
import {Navigation, A11y} from "swiper/modules";

import '@css/main.scss';

document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.swiper')) {
    const swiperInstances: HTMLElement[] = qsa<HTMLElement>('.swiper', document);

    for (const instance of swiperInstances) {
      new Swiper(instance, {
        modules: [Navigation, A11y],
        loop: instance.dataset.sliderLoop === 'true',
        navigation: instance.dataset.sliderNavigation === 'true' && {
          prevEl: qs<HTMLElement>('button.swiper-button-prev', instance),
          nextEl: qs<HTMLElement>('button.swiper-button-next', instance),
        }
      })
    }
  }
})