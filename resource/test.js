$("#menu-btn").on('click', () => {
  $("aside").show();
});

$("#close-btn").on('click', () => {
  $("aside").hide();
});

const themeToggler = $(".theme-toggler");
const body = $("body");
const themeClass = "dark-theme-variables";

// 讀取用戶的主題設置
const isDarkTheme = localStorage.getItem("isDarkTheme");

if (isDarkTheme === "true") {
  body.addClass(themeClass);
  themeToggler.children("span").eq(0).addClass("active");
  themeToggler.children("span").eq(1).removeClass("active");
} else {
  body.removeClass(themeClass);
  themeToggler.children("span").eq(0).removeClass("active");
  themeToggler.children("span").eq(1).addClass("active");
}

// 點擊事件
themeToggler.on("click", () => {
  body.toggleClass(themeClass);
  const isDark = body.hasClass(themeClass);
  localStorage.setItem("isDarkTheme", isDark ? "true" : "false");
  themeToggler.children("span").eq(0).toggleClass("active");
  themeToggler.children("span").eq(1).toggleClass("active");
  // const label = $("label");
  // if (isDark) {
  //   label.css("color", "white"); 
  // } else {
  //   label.css("color", "white");
  // }
});

if (isDarkTheme !== null) {
  const isActive = isDarkTheme === "true";
  themeToggler.children("span").eq(0).toggleClass("active", !isActive);
  themeToggler.children("span").eq(1).toggleClass("active", isActive);
}
