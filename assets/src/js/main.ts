import {initTabs} from "./ui/tabs.js";
import {initModals} from "./ui/modal.js";
import {initSliders} from "./ui/slider.js";

import '@css/main.scss';

document.addEventListener('DOMContentLoaded', () => {
  initTabs();
  initModals();
  initSliders();
})