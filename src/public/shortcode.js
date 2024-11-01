/** When launcher is load */
var $container = jQuery(".leadsms-widget-container"),
  $prompt_delay = parseFloat($container.data("prompt-delay")), //in seconds
  $prompt_enabled = parseInt($container.data("prompt-enabled")); //1 or 0

if ($prompt_enabled) {
  var $prompt_delay_in_ms = 1000;
  if (!isNaN($prompt_delay)) {
    $prompt_delay_in_ms = $prompt_delay * 1000;
  }

  setTimeout(() => {
    if (!$container.hasClass("widget-opened")) {
      var $prompt = $container.find(".leadsms-widget-prompt");
      $prompt.removeClass("hidden");
    }
  }, $prompt_delay_in_ms);
}

/** When launcher is clicked */
jQuery(".leadsms-widget-launcher-icon").click(() => {
  var $container = jQuery(".leadsms-widget-container");
  $container.toggleClass("widget-opened");

  if ($container.hasClass("widget-opened")) {
    $container.find(".leadsms-widget-prompt").addClass("hidden");
    $container.find(".leadsms-widget-launcher-icon-message").addClass("hidden");
    $container
      .find(".leadsms-widget-launcher-icon-close")
      .removeClass("hidden");
  } else {
    $container
      .find(".leadsms-widget-launcher-icon-message")
      .removeClass("hidden");
    $container.find(".leadsms-widget-launcher-icon-close").addClass("hidden");
  }
});

/** When prompt is clicked */
jQuery(".leadsms-widget-prompt .close-button").click(() => {
  var $container = jQuery(".leadsms-widget-container");
  var $prompt = $container.find(".leadsms-widget-prompt");
  $prompt.addClass("hidden");
});
