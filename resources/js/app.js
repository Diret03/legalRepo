import './bootstrap';
import 'flowbite';
import TomSelect from 'tom-select';
import Alpine from 'alpinejs';
import {initializeLiveSearchCases} from './search';
import {initializeLiveSearchNoCases} from './searchNoCases';

window.Alpine = Alpine;
window.TomSelect = TomSelect;
window.initializeLiveSearchCases = initializeLiveSearchCases;
window.initializeLiveSearchNoCases = initializeLiveSearchNoCases;

Alpine.start();


