<template>
  <div class="app col-md-10 m-lg-auto">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                      <router-link
                          class="nav-link text-center"
                          to="/"
                      >
                          Equipments
                      </router-link>
                  </li>
                  <li class="nav-item">
                      <router-link
                          class="nav-link text-center"
                          to="/"
                      >
                          Equipments Types
                      </router-link>
                  </li>
              </ul>
          </div>
      </nav>
      <router-view />
  </div>
</template>

<script>

export default {

};
</script>

<style scoped>
    .navbar-collapse .bi {
        margin-right: 18px;
        font-size: 1.3rem;
    }
</style>
