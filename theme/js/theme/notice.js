import utils from "./Utils";

/*-----------------------------------------------
|   Cookie Notice
-----------------------------------------------*/
utils.$document.ready(() => {
  const Selector = { NOTICE: ".notice" };
  const DataKeys = { OPTIONS: "options" };
  const CookieNames = { COOKIE_NOTICE: "cookieNotice" };
  const Events = { HIDDEN_BS_TOAST: "hidden.bs.toast" };

  const $notices = $(Selector.NOTICE);
  const defaultOptions = {
    autoShow: false,
    autoShowDelay: 0,
    showOnce: false,
    cookieExpireTime: 3600000,
  };

  $notices.each((index, value) => {
    const $this = $(value);
    const options = $.extend(defaultOptions, $this.data(DataKeys.OPTIONS));
    let cookieNotice;
    if (options.showOnce) {
      cookieNotice = utils.getCookie(CookieNames.COOKIE_NOTICE);
    }
    if (options.autoShow && cookieNotice === null) {
      setTimeout(() => $this.toast("show"), options.autoShowDelay);
    }
  });

  $(Selector.NOTICE).on(Events.HIDDEN_BS_TOAST, (e) => {
    const $this = $(e.currentTarget);
    const options = $.extend(defaultOptions, $this.data(DataKeys.OPTIONS));
    options.showOnce &&
      utils.setCookie(
        CookieNames.COOKIE_NOTICE,
        false,
        options.cookieExpireTime
      );
  });

  utils.$document.on("click", "[data-toggle='notice']", (e) => {
    e.preventDefault();
    const $this = $(e.currentTarget);
    const $target = $($this.attr("href"));
    if ($target.hasClass("show")) {
      $target.toast("hide");
    } else {
      $target.toast("show");
    }
  });
});
