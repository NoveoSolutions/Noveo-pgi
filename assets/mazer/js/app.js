// Feather icons are used on some pages
// Replace() replaces [data-feather] elements with icons
import featherIcons from "feather-icons"
featherIcons.replace()

// Mazer internal JS. Include this in your project to get
// the sidebar running.
require("./components/dark")

require("./mazer")

require("./pages/jquery")

import 'datatables.net';


 // require jQuery normally
 const $ = require('jquery');

  // create global $ and jQuery variables
  global.$ = global.jQuery = $;