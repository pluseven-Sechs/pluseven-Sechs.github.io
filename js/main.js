jQuery(document).ready(function ($) {
  var modalTrigger = $(".cd-modal-trigger"),
    introSection = $(".intro"),
    transitionLayer = $(".cd-transition-layer"),
    transitionBackground = transitionLayer.children(),
    modalWindow = $(".cd-modal");

  var frameProportion = 1.78,
    frames = 25,
    resize = false;

  // 预加载Intro界面的背景图像
  var bgImage1 = new Image();
  bgImage1.src = "../img/intro.webp";
  bgImage1.onload = function () {
    introSection.addClass("visible");
  };

  // 预加载Login界面的背景图像
  var bgImage2 = new Image();
  bgImage2.src = "../img/login.jpg";
  bgImage2.onload = function () {
    $(".background").addClass("visible");
  };

  // 预加载user_index界面的背景图像
  var bgImage3 = new Image();
  bgImage3.src = "../img/user_index.jpg";
  bgImage3.onload = function () {
    $(".user_background").addClass("visible");
  };

  // 定义一个 FontFace
  const font = new FontFace("myfont", "url(../font/yunfeng.ttf)");

  // 添加到 document.fonts (FontFaceSet)
  document.fonts.add(font);

  // 加载字体
  font.load();

  document.fonts.ready.then(function () {
    $(".button-text").addClass("visible");
  });

  setLayerDimensions();
  $(window).on("resize", function () {
    if (!resize) {
      resize = true;
      !window.requestAnimationFrame
        ? setTimeout(setLayerDimensions, 300)
        : window.requestAnimationFrame(setLayerDimensions);
    }
  });

  modalTrigger.on("click", function (event) {
    event.preventDefault();
    transitionLayer.addClass("visible opening");
    var delay = $(".no-cssanimations").length > 0 ? 0 : 600;
    setTimeout(function () {
      modalWindow.addClass("visible");
    }, delay);
  });

  modalWindow.on("click", ".modal-close", function (event) {
    event.preventDefault();
    transitionLayer.addClass("closing");
    modalWindow.removeClass("visible");
    transitionBackground.one(
      "webkitAnimationEnd oanimationend msAnimationEnd animationend",
      function () {
        transitionLayer.removeClass("closing opening visible");
        transitionBackground.off(
          "webkitAnimationEnd oanimationend msAnimationEnd animationend"
        );
      }
    );
  });

  function setLayerDimensions() {
    var windowWidth = $(window).width(),
      windowHeight = $(window).height(),
      layerHeight,
      layerWidth;

    if (windowWidth / windowHeight > frameProportion) {
      layerWidth = windowWidth;
      layerHeight = layerWidth / frameProportion;
    } else {
      layerHeight = windowHeight * 1.2;
      layerWidth = layerHeight * frameProportion;
    }

    transitionBackground.css({
      width: layerWidth * frames + "px",
      height: layerHeight + "px",
    });

    resize = false;
  }
});
