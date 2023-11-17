import { createRouter, createWebHistory } from "vue-router";

// file import
import login from "../views/admin/LoginView.vue";
import HomeDashboard from "../views/admin/DashboardView.vue";

// children
import dashBoard from "../views/admin/dashboard.vue";
import order from "../views/admin/order.vue";
import commande from "../views/admin/commande.vue";
import product from "../views/admin/product.vue";
import buy from "../views/admin/buy.vue";
import cat from "../views/admin/cat.vue";
import user from "../views/admin/user.vue";
import saller from "../views/admin/saller.vue";
import anal from "../views/admin/anal.vue";
import setting from "../views/admin/setting.vue";
import group from "../views/admin/group.vue";

const routes = [
  {
    path: "/",
    name: "Login",
    component: login,
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: HomeDashboard,
    children: [
      {
        path: "",
        component: dashBoard,
      },
      {
        path: "order",
        component: order,
      },
      {
        path: "commande",
        component: commande,
      },
      {
        path: "product",
        component: product,
      },
      {
        path: "buy",
        component: buy,
      },
      {
        path: "cat",
        component: cat,
      },
      {
        path: "user",
        component: user,
      },
      {
        path: "saller",
        component: saller,
      },
      {
        path: "anal",
        component: anal,
      },
      {
        path: "setting",
        component: setting,
      },
      {
        path: "group",
        component: group,
      },
    ],
  },
];

const router = createRouter({
  mode: "history",
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
