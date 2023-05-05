<?php
session_start();
$q = explode('/', $_SERVER['PHP_SELF']);
array_pop($q);
$q = implode("/", $q);
$_SESSION['WEB_ROOT'] = $q;
require_once('FileRoute.php');
require_once(ROOT_PATH . 'config.php');
require_once(Core_PATH . 'controller.Class.php');
if (isset($_COOKIE["id"]) && isset($_COOKIE["sss"]) && isset($_SESSION['ucode'])) {
    $Controller = new Controller($user, $passwd);
    if ($Controller->checkUserStatus($_COOKIE["id"], $_COOKIE["sss"])) {
        // header('location: ' . Web_Root_Path . 'page/dashboard.php');
        header('location: ' .Page_PATH. 'dashboard.php');
        exit();
    } else {
        header('location:' . Web_Root_Path . "index.php");
        exit();
    }
} else {
?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>線上點餐系統</title>
        <script defer="defer" src="index.js"></script>
        <link href="index.css" rel="stylesheet">
    </head>

    <body>
        <div id="app">
            <div class="p-3 d-flex justify-content-between align-items-center bg-primary fixed-top"><a class="navbar-brand"
                    href="#">logo</a>
                <ul class="d-flex justify-content-around align-items-center">
                    <li class="px-2"><a class="nav-link text-light" href="<?php echo $login_url ?>"><svg
                                xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none">
                                <g id="User / User_01">
                                    <path id="Vector"
                                        d="M19 21C19 17.134 15.866 14 12 14C8.13401 14 5 17.134 5 21M12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7C16 9.20914 14.2091 11 12 11Z"
                                        stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg></a></li>
                    <li class="px-2"><a class="nav-link position-relative" href="javascript:;" id="cart-btn"><svg
                                fill="white" xmlns="http://www.w3.org/2000/svg" width="26" height="26"
                                class="bi bi-cart-plus" viewBox="0 0 16 16">
                                <path
                                    d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                <path
                                    d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg> <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{
                                cartItems.length }} <span class="visually-hidden">unread messages</span></span></a></li>
                </ul>
            </div>
            <div class="container mt-7">
                <div class="row g-4">
                    <div class="col-lg-3 col-6" v-for="(product, index) in products" :key="index">
                        <div class="shadow-lg p-3"><img :src="product.image" class="w-100" alt="" />
                            <div class="p-2 d-flex align-items-center">
                                <h4 class="fs-6">{{product.title}}</h4>
                                <p class="text-secondary">${{product.price}}</p>
                            </div>
                            <div class="d-flex justify-content-between text-center"><button type="button"
                                    class="btn btn-primary btn-sm" @click="minus(product)">-</button> <input
                                    class="form-control w-50 text-center" min="1" max="9" v-model="product.amountShow" />
                                <button type="button" class="btn btn-primary btn-sm" @click="plus(product)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="cart" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title d-flex align-items-center">購物車</h5><button type="button"
                                class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="p-3" v-if="cartItems.length === 0">
                                <p class="text-center">您的購物車是空的。</p>
                            </div>
                            <div class="list-group list-group-flush fz-18" v-else>
                                <div class="list-group-item d-flex justify-content-between align-items-center"
                                    v-for="(item, index) in cartItems" :key="index">
                                    <div class="d-flex justify-content-around align-items-center w-75">
                                        <p class="mb-0">{{ item.title }}</p><small class="text-secondary">{{ item.price
                                            }}元</small>
                                        <div class="d-flex"><button type="button" class="btn btn-primary btn-sm"
                                                @click="minus(item)">-</button> <input class="form-control w-50 text-center"
                                                min="1" max="9" v-model.number="item.amount" /> <button type="button"
                                                class="btn btn-primary btn-sm" @click="plus(item)">+</button></div>
                                    </div><a href="javascript:;"><svg @click="removeFromCart(index)"
                                            xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#d0021c"
                                            class="bi bi-trash-fill ms-2" viewBox="0 0 26 26">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z">
                                            </path>
                                        </svg></a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <p class="fw-bold">共<span class="text-primary mx-1">{{ cartItems.length }}</span>筆項目</p>
                            <p class="fw-bold">總共:<span class="text-primary mx-1">${{ getTotalPrice() }}</span>元</p><button
                                type="button" class="btn btn-primary text-white shadow-none">去買單</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="https://unpkg.com/vue@3"></script>

    </html>
<?php } ?>