<template>
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <Sidebar />
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Start of Topbar -->
          <Topbar />
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <div class="container-fluid">
            <router-view></router-view>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <Footers/>
        <!-- <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; Your Website 2021</span>
            </div>
          </div>
        </footer> -->
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->

    <!-- Logout Modal-->
  </template>
<script setup>
    import Topbar from "../layouts/Topbar.vue";
    import Sidebar from "../layouts/Sidebar.vue";
    import Footers from "../layouts/Footer.vue";
    import sbadmin2 from '../composables/utils/sb-admin-2.js'
    import {onMounted,onBeforeMount,version} from 'vue'

    onMounted( async () => {
        sbadmin2.init();
    })




</script>

<style lang="scss" scoped>
//   mounted() {
//     sbadmin2.init();
//   },

</style>
../composables/sb-admin-2_2.js../composables/sb-admin-2_2.js
