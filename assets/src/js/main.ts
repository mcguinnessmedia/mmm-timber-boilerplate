import {initNav} from './ui/nav.js';
import {initTabs} from "./ui/tabs.js";
import {initModals} from "./ui/modal.js";
import {initSliders} from "./ui/slider.js";
import {initAccordions} from "./ui/accordion.js";

import '@css/main.scss';

document.addEventListener('DOMContentLoaded', () => {
  initNav();
  initTabs();
  initModals();
  initSliders();
  initAccordions();
})