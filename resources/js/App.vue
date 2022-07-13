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
                          Оборудование
                      </router-link>
                  </li>
              </ul>
          </div>
      </nav>
      <router-view />
      <notifications />
  </div>
</template>

<script>

export default {
    data() {
        return {
            email: 'test@test.com',
            password: 'password',
        }
    },
    created() {
        this.getJWT();
    },

    methods: {
        getJWT() {
            axios.post('/api/login', {email: this.email, password: this.password})
                .then((response) => {
                    localStorage.access_token = response.data.access_token
                })
        }
    }

};
</script>

<style scoped>
    .navbar-collapse .bi {
        margin-right: 18px;
        font-size: 1.3rem;
    }
</style>
