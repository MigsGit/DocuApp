<template>
    <ul
      class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
      id="accordionSidebar"
    >
      <!-- Sidebar - Brand -->
      <router-link
        class="sidebar-brand d-flex align-items-center justify-content-center"
        :to="{ name: 'dashboard' }"
      >
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-folder"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Docu App</div>
      </router-link>

      <!-- Divider -->
      <hr class="sidebar-divider my-0" />

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <router-link class="nav-link" :to="{ name: 'dashboard' }">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </router-link
        >
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider" />

      <!-- Heading -->
      <div class="sidebar-heading">Admin</div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a
          class="nav-link collapsed"
          href="#"
          data-toggle="collapse"
          data-target="#collapsePages"
          aria-expanded="true"
          aria-controls="collapsePages"
        >
          <i class="fas fa-fw fa-folder"></i>
          <span>Settings</span>
        </a>
        <div
          id="collapsePages"
          class="collapse"
          aria-labelledby="headingPages"
          data-parent="#accordionSidebar"
        >
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Settings Module:</h6>
            <router-link class="collapse-item" :to="{ name: 'user_master' }">
                <font-awesome-icon class="nav-icon" icon="gauge-high" />&nbsp;<span>User Master</span>
            </router-link>
            <router-link class="collapse-item" :to="{ name: 'emailer' }">
                <font-awesome-icon class="nav-icon" icon="fa-envelope-open-text" />&nbsp;<span>Emailer</span>
            </router-link>
          </div>
        </div>
      </li>

      <!-- Nav Item -->
      <li class="nav-item">
        <router-link class="nav-link" :to="{ name: 'module' }">
            <font-awesome-icon class="nav-icon" icon="gauge-high" />&nbsp;<span>Module</span>
        </router-link>
      </li>

      <!-- Nav Item - Tables -->
      <!-- <li class="nav-item">
        <router-link class="nav-link" to="/admin/tables">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></router-link
        >
      </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block" />

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->
</template>

<script setup>
    // import sbadmin2 from '../composables/sb-admin-2.js'
    import {onBeforeMount,version } from 'vue'

    onBeforeMount( async () => {
        // await sbadmin2.init();
        // console.log($("#sidebarToggle, #sidebarToggleTop"));
        // console.log(version);
    })

</script>
