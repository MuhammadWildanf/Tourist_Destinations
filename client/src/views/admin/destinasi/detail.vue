<script>
import SidebarComponent from "../../../components/admin/SidebarComponent.vue";
import TopbarComponent from "../../../components/admin/TopbarComponent.vue";
import { ref, vModelRadio } from "vue";
import axios from "axios";

export default {
  components: {
    SidebarComponent,
    TopbarComponent,
  },
  name: "BusinessEdit",
  data() {
    return {
      destinationId: '',
      model: {
        formInput: {
          wisata: "",
          deskripsi: "",
          price: "",
          penginapan: "",
          jarak: "",
          openTime: "",
          closeTime: "",
          access: [],
          address: "",
          numberPhone: "",
          img: null,
          img_lokasi: null,
          region_id: "",
          business_id: "",
          category_id: "",
        },
      },
      regions: [],
      businesses: [],
      categories: [],
    };
  },
  mounted() {
    this.destinationId = this.$route.params.id
    this.fetchDestination(this.$route.params.id);
    this.getBusines();
    this.getCategory();
    this.getRegion();
  },
  methods: {
    getRegion() {
      axios
        .get("http://localhost:8000/api/regions")
        .then((res) => {
          this.regions = res.data.data
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getBusines() {
      axios
        .get("http://localhost:8000/api/business/")
        .then((res) => {
          this.businesses = res.data.data
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getCategory() {
      axios
        .get("http://localhost:8000/api/categories/")
        .then((res) => {
          this.categories = res.data.data
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    fetchDestination(id){
        axios.get(`http://localhost:8000/api/destination/${id}`)
        .then(res => {
        //  console.log(res.data.data);

         this.model.formInput = res.data.data
        })
        .catch(function(error){
            console.log(error);
        })

    },
  },
};
</script>

<template>
  <!-- Page Wrapper -->
  <div id="wrapper">
    <SidebarComponent />

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <TopbarComponent />

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Kelola Tempat Wisata</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">Detail Tempat Wisata</div>
            <div class="card-body">
              <div class="mb-3">
                <label for="">Nama Wisata</label>
                <input
                  type="text"
                  v-model="model.formInput.wisata"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Deskripsi Wisata</label>
                <input
                  type="text"
                  v-model="model.formInput.deskripsi"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Harga Tiket Masuk</label>
                <input
                  type="text"
                  v-model="model.formInput.price"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Jumlah Penginapan</label>
                <input
                  type="text"
                  v-model="model.formInput.penginapan"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Jumlah Jarak Wisata Terdekat</label>
                <input
                  type="text"
                  v-model="model.formInput.jarak"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Jam Buka</label>
                <input
                  type="time"
                  v-model="model.formInput.openTime"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Jam Tutup</label>
                <input
                  type="time"
                  v-model="model.formInput.closeTime"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Access Kendaraan</label>
                <input
                  type="text"
                  v-model="model.formInput.access"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Alamat</label>
                <input
                  type="text"
                  v-model="model.formInput.address"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Nomor Telepon</label>
                <input
                  type="text"
                  v-model="model.formInput.numberPhone"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Image</label>
                <input
                  type="text"
                  v-model="model.formInput.img"
                  class="form-control"
                  readonly
                />
              </div>
              <div class="mb-3">
                <label for="">Wilayah</label>
                <select
                  class="form-select"
                  name="region_id"
                  v-model="model.formInput.region_id"
                >
                  <option disable value="" selected>
                    Open this select menu
                  </option>
                  <option v-for="region in regions" :value="region.id">
                    {{ region.region }}
                  </option>
                </select>
              </div>
              <div class="mb-3">
                <label for="">Bisnis & Usaha</label>
                <select
                  class="form-select"
                  name="business_id"
                  v-model="model.formInput.business_id"
                >
                  <option disable value="" selected>
                    Open this select menu
                  </option>
                  <option v-for="business in businesses" :value="business.id">
                    {{ business.business }}
                  </option>
                </select>
              </div>
              <div class="mb-3">
                <label for="">Kategori</label>
                <select
                  class="form-select"
                  name="category_id"
                  v-model="model.formInput.category_id"
                >
                  <option disable value="" selected>
                    Open this select menu
                  </option>
                  <option v-for="category in categories" :value="category.id">
                    {{ category.category }}
                  </option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
</template>
