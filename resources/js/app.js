import './bootstrap';
import 'flowbite';
import TomSelect from 'tom-select';

import Alpine from 'alpinejs';
import initializeLiveSearch  from './search';

window.Alpine = Alpine;
window.TomSelect = TomSelect;
window.initializeLiveSearch = initializeLiveSearch;

Alpine.start();


