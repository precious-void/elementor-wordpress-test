jQuery(function ($) {
  var youtube_url =
    /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;

  $(".editor-post-publish-button").on("click", function (e) {
    var url = $(".input-wrapper input[type=url]").val();
    var match = url.match(youtube_url);
    if (!match || match[2].length !== 11) {
      e.stopImmediatePropagation();
      $(".input-wrapper input[type=url] .error")
        .show()
        .text("Please enter a valid YouTube URL");
    }
  });

  $(".input-wrapper input[type=url]").blur(function () {
    var url = $(this).val();
    var match = url.match(youtube_url);
    if (!match || match[2].length !== 11) {
      $(this)
        .parent()
        .find(".error")
        .show()
        .text("Please enter a valid YouTube URL");

      $(this).val("");
    }
  });

  $(".input-wrapper input[type=url]").change(function () {
    $(this).parent().find(".error").hide();
  });

  $(".input-wrapper input[type=number]").change(function () {
    $(this).val(parseInt($(this).val()));
  });
});
