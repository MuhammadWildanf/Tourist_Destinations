import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import DetailwisataView from "../views/DetailwisataView.vue";
import RekomendasiView from "../views/RekomendasiView.vue";


import LoginView from "../views/admin/login.vue";
import DashboardView from "../views/DashboardView.vue";
import UserView from "../views/admin/user/user.vue";


import RoleView from "../views/admin/role/role.vue";
import createRole from "../views/admin/role/create.vue";
import editRole from "../views/admin/role/edit.vue";

import kelolaKategori from "../views/admin/category/KelolaKategori.vue";
import createKategori from "../views/admin/category/create.vue";
import editKategori from "../views/admin/category/edit.vue";

import kelolaTEmpatWisata from "../views/admin/destinasi/KelolaTempat.vue";
import createkelolaTEmpatWisata from "../views/admin/destinasi/create.vue";
import updatekelolaTEmpatWisata from "../views/admin/destinasi/edit.vue";
import detailkelolaTEmpatWisata from "../views/admin/destinasi/detail.vue";

import tempatWisata from "../views/admin/bisnis/KelolaTempatUsaha.vue";
import createTempatWisata from "../views/admin/bisnis/create.vue";
import editTempatWisata from "../views/admin/bisnis/edit.vue";

import manajemenWilayah from "../views/admin/wilayah/KelolaWilayah.vue";
import createmanajemenWilayah from "../views/admin/wilayah/create.vue";
import editmanajemenWilayah from "../views/admin/wilayah/edit.vue";

import rekomendasiWIsata from "../views/admin/RekomendasiWisata.vue";



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/rekomendasi",
      name: "rekomendasi",
      component: RekomendasiView,
    },
    {
      path: "/detail/:id",
      name: "detail",
      component: DetailwisataView,
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
    },
    {
      path: "/register",
      name: "register",
      component: LoginView,
    },
    {
      path: "/admin",
      name: "admin",
      component: DashboardView,
    },
    {
      path: "/user",
      component: UserView,
    },
    {
      path: "/role",
      component: RoleView,
    },
    {
      path: "/role/create",
      component: createRole,
    },
    {
      path: "/role/:id",
      component: editRole,
    },
    {
      path: "/kelola-kategori",
      component: kelolaKategori,
    },
    {
      path: "/kelola-kategori/create",
      component: createKategori,
    },
    {
      path: "/kelola-kategori/:id",
      component: editKategori,
    },
    {
      path: "/kelola-tempat-wisata",
      component: kelolaTEmpatWisata,
    },
    {
      path: "/kelola-tempat-wisata/create",
      component: createkelolaTEmpatWisata,
    },
    {
      path: "/kelola-tempat-wisata/:id",
      component: updatekelolaTEmpatWisata,
    },
    {
      path: "/kelola-tempat-wisata/:id/detail",
      component: detailkelolaTEmpatWisata,
    },
    {
      path: "/tempat-wisata-&-usaha",
      component: tempatWisata,
    },
    {
      path: "/tempat-wisata-&-usaha/create",
      component: createTempatWisata,
    },
    {
      path: "/tempat-wisata-&-usaha/:id",
      component: editTempatWisata,
    },
    {
      path: "/manajemen-wilayah",
      component: manajemenWilayah,
    },
    {
      path: "/manajemen-wilayah/create",
      component: createmanajemenWilayah,
    },
    {
      path: "/manajemen-wilayah/:id",
      component:editmanajemenWilayah,
    },
    {
      path: "/rekomendasi-wisata",
      component: rekomendasiWIsata,
    },
    
  ],
});

export default router;
