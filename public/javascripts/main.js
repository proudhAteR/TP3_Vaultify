import listen from './navbar.js'
import Application from './app.js';
import togglePassword from "./vault.js";

listen();
togglePassword();

new Application().initialize();