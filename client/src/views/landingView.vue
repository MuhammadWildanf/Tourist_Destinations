<script>
import { mapActions, mapState } from "pinia";
import { useUserStore } from "../stores/wisata";
import CardComponent from "../components/landing/CardComponent.vue";
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
  data() {
    return {
      selectedCategory: "",
    };
  },
  computed: {
    ...mapState(useUserStore, ["destinations", "categories"]),
    filteredDestinations() {
      if (this.selectedCategory === "") {
        return this.destinations.filter(destination => destination.status === 'Validasi');
      } else {
        return this.destinations.filter(
          destination => destination.category_id === this.selectedCategory && destination.status === 'Validasi'
        );
      }
    },
  },
  methods: {
    ...mapActions(useUserStore, ["fetchDestination", "fetchCategories"]),
    filterDestinations() {
      this.fetchDestination({
        filter: { category: this.selectedCategory },
      });
    },
  },
  created() {
    this.fetchDestination();
    this.fetchCategories();
  },
  components: { CardComponent },
};
</script>

<template>
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
      <router-link class="navbar-brand" to="/">Destinasi Wisata</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="login"
              >Login</router-link
            >
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link active"
              aria-current="page"
              to="register"
              >Register</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" aria-current="page" to="#"
              >Logout</router-link
            >
          </li>
        </ul>
      </div> -->
    </div>
  </nav>
  <!-- Header-->
  <header class="bg-hefo py-5">
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
        <h1 class="display-4 fw-bolder">Destinasi Wisata</h1>
        <p class="lead fw-normal text-white-50 mb-0"></p>
      </div>
    </div>
  </header>
  <!-- Section-->
  <section class="py-5">
    <div class="container">
      <div class="col-md-2">
        <div class="row">
          <h4>Kategori</h4>
          <select
            class="form-control"
            v-model="selectedCategory"
            @change="filterDestinations"
          > 
            <option value="" selected>All Category</option>
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.category }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="container px-4 px-lg-5 mt-5" v-if="filteredDestinations.length > 0">
    <div
      class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"
    >
      <CardComponent
        v-for="destination in filteredDestinations"
        :key="destination.id"
        :destination="destination"
      />
    </div>
  </div>
  <div class="container px-4 px-lg-5 mt-5" v-else>
    <div
      class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"
    >
    <h4>Tidak ada destinasi yang tersedia.</h4>
    </div>
  </div>
  </section>
  <!-- Footer-->
  <footer class="py-5 bg-hefo">
    <div class="container">
      <p class="m-0 text-center text-white">
        Copyright &copy; Your Website 2023
      </p>
    </div>
  </footer>
</template>
<style>
.bg-hefo {
  background-color: #86b817;
}
</style>
