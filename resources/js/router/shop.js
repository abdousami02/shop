import { createRouter, createWebHistory } from "vue-router";

// navbar
import Home from "../views/shop/HomeView.vue";
import Store from "../views/shop/StoreView.vue";
import Promo from "../views/shop/PromoView.vue";
import Orders from "../views/shop/OrdersView.vue";
import Setting from "../views/shop/SettingView.vue";
// Products & checkOut
import OrderDetail from "../views/shop/OrderDetails.vue";
import CheckOut from "../views/shop/CheckoutView.vue";
import Contact from "../views/shop/ContactView.vue";
// login sugnUp
import Login from "../views/shop/LoginView.vue";
import signUp from "../views/shop/signUpView.vue";
// stting pages
import dashSett from "../views/shop/setting/dashboard.vue";
import profSett from "../views/shop/setting/profile.vue";


const routes = [
  {
    path: "/",
    name: "home",
    component: Home,
  },
  {
    path: "/store",
    name: "store",
    component: Store,
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    // component: () =>
    //   import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
  },
  {
    path: "/promotion",
    name: "promotion",
    component: Promo,
  },
  {
    path: "/orders",
    name: "orders",
    component: Orders,
  },
  {
    path: "/orders/orderDetails",
    name: "order-details",
    component: OrderDetail,
  },
  {
    path: "/orders/checkout",
    name: "checkout",
    component: CheckOut,
  },
  {
    path: "/setting",
    name: "setting",
    component: Setting,
    children: [
      {
        path: "",
        component: dashSett,
      },
      {
        path: "profile",
        name: 'profile',
        component: profSett,
      },
    ],
  },
  {
    path: "/contact",
    name: "contact",
    component: Contact,
  },
  {
    path: "/login",
    name: "Login",
    component: Login,
  },
  {
    path: "/signUp",
    name: "signUp",
    component: signUp,
  },
];

const router = createRouter({
mode: "history",
history: createWebHistory(process.env.BASE_URL),
routes,
});

export default router;
