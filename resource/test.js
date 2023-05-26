$("#menu-btn").on('click',()=>{
    $("aside").show();
});

$("#close-btn").on('click',()=>{
    $("aside").hide() ;
});


// var Dark;
// $(".theme-toggler").on('click',()=>{
//     $("body").toggleClass('dark-theme-variables');
//     if($("body").hasClass('dark-theme-variables')){
//         Dark = 'dark-theme-variables';
//     }
//     else{
//         Dark = '';
//     }
//     $(".theme-toggler").children("span").eq(0).toggleClass('active');
//     $(".theme-toggler").children("span").eq(1).toggleClass('active');
// });


// $(document).ready(function() {
//     if(Dark==='dark-theme-variables'){
//         $("body").addClass(Dark);
//     }
//     else{
//         $("body").removeClass(Dark);
//     }
// });

// const themeToggler = $(".theme-toggler");
// const body = $("body");
// const themeClass = "dark-theme-variables";

// // 讀取用戶的主題設置
// const isDarkTheme = localStorage.getItem("isDarkTheme");

// if (isDarkTheme === "true") {
//   body.addClass(themeClass);
//   themeToggler.children("span").eq(0).addClass("active");
//   themeToggler.children("span").eq(1).addClass("active");
// }

// // 點擊事件
// themeToggler.on("click", () => {
//   body.toggleClass(themeClass);
//   const isDark = body.hasClass(themeClass);
//   localStorage.setItem("isDarkTheme", isDark ? "true" : "false");
//   themeToggler.children("span").eq(0).toggleClass("active");
//   themeToggler.children("span").eq(1).toggleClass("active");
// });
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
});

if (isDarkTheme !== null) {
  const isActive = isDarkTheme === "true";
  themeToggler.children("span").eq(0).toggleClass("active", !isActive);
  themeToggler.children("span").eq(1).toggleClass("active", isActive);
}
