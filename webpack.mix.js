let mix = require("laravel-mix");
mix.setPublicPath("assets");

mix.setResourceRoot("../");
mix
  .js("src/admin/start.js", "assets/admin/js/start.js")
  .vue({ version: 3 })
  .js("src/admin/widget.js", "assets/admin/js/widget.js")
  .vue({ version: 3 })
  .js("src/public/shortcode.js", "assets/js/shortcode.js")
  .sass("src/scss/admin/app.scss", "assets/css/element.css")
  .sass("src/scss/public/widget.scss", "assets/css/widget.css")
  .copy("src/public/spectrum.min.js", "assets/js/spectrum.min.js")
  .copy("src/public/spectrum.min.css", "assets/css/spectrum.min.css")
  // .copy("src/public/howler.min.js", "assets/js/howler.min.js")
  .copy("src/public/sound.mp3", "assets/sound.mp3")
  .copy("src/public/sound.webm", "assets/sound.webm");
