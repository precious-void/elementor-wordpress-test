jQuery(function ($) {
  function findVideos() {
    $(".video").each(function (i, el) {
      setupVideo($(el));
    });
  }

  function setupVideo(video) {
    let link = video.find(".video__link");
    let button = video.find(".video__button");
    let id = link.data("id");

    video.on("click", function () {
      let iframe = createIframe(id);

      link.remove();
      button.remove();
      video.append(iframe);
    });

    link.removeAttr("href");
    video.addClass("video--enabled");
  }

  function createIframe(id) {
    let iframe = $("<iframe></iframe>")
      .attr("allowfullscreen", "")
      .attr("allow", "autoplay")
      .attr("src", generateURL(id))
      .addClass("video__media");

    return iframe;
  }

  function generateURL(id) {
    let query = "?rel=0&showinfo=0&autoplay=1";

    return "https://www.youtube.com/embed/" + id + query;
  }

  findVideos();
});
