import listen from './navbar.js'
import Application from './app.js';
import {togglePassword, focusOnModal} from "./vault.js";

activateListeners();
new Application().initialize();

function activateListeners() {
    listen();
    togglePassword();
    //focusOnManage()
}