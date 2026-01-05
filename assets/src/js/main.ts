import Swiper from "swiper";
import { Navigation, A11y } from "swiper/modules";

import '@css/main.scss';

if ( document.querySelector( '.swiper' ) ) {
  const swiperInstances: HTMLElement[] = Array.from( document.querySelectorAll( '.swiper' ) );

  for ( const instance of swiperInstances ) {
    new Swiper( instance, {
      modules: [Navigation, A11y],
      loop: instance.dataset.sliderLoop === 'true',
      navigation: instance.dataset.sliderNavigation === 'true' && {
        nextEl: instance.querySelector( 'button.swiper-button-next' ) as HTMLElement,
        prevEl: instance.querySelector( 'button.swiper-button-prev' ) as HTMLElement,
      }
    } )
  }
}