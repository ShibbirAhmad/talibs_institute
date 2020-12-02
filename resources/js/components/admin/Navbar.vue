<template>
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <span class="logo-mini"><b>A</b>LT</span>
      <span class="logo-lg"><b>Madina </b>fashion</span>
    </a>
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img v-if="getAdmin.image"
                :src="base_url+ getAdmin.image"
                class="user-image"
                
              />
              <img
                :src="this.base_url+'images/no_image.jpg'"
                class="user-image"
                v-else
              />
              <span class="hidden-xs">{{ getAdmin.name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img
                  :src=" base_url+ getAdmin.image"
                  class="img-circle"
                  v-if="getAdmin.image"
                />
                <img
                  :src="base_url+'images/no_image.jpg'"
                  class="img-circle"
                  v-else
                />

                <p>
                  {{ getAdmin.name }} - admin
                  <small>Member since {{ getAdmin.created_at }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">

                <div class="row">
                     <div class="col-md-3">
                        <div >
                  <router-link
                    :to="{ name: 'admin_profile' }"
                   style="color:#000 !important;"
                    class="btn btn-default btn-flat"
                    >Profile</router-link
                  >
                </div>
                     </div>

                     <div class="col-md-6">
                           <div class="passowrdChange">
                       <router-link  style="color:#000 !important;"
                    class="btn btn-default btn-flat" :to="{ name : 'edit_admin_password' } " >change password</router-link>
                            </div>
                     </div>

                     <div class="col-md-3">
                       
                <div >
                  <button style="color:#000 !important;" class="btn btn-default btn-flat" @click="logout"
                    >Sign out</button
                  >
                </div>
                     </div>
                </div>
               
              </li>
            </ul>
          </li>
        
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  created() {
    
    this.$store.dispatch("admin");
  },
  data() {
    return {
      admin: {},
      base_url: this.$store.state.storage ,
    };
  },
  methods: {
    //method inital for logout user
    logout() {
      axios
        .get("/api/logout/admin")
        .then((resp) => {
          //if success resp, then admin redirect to login page
          if (resp.data.status == "SUCCESS") {
            this.$store.commit("admin", null);
            this.user = null;
            localStorage.removeItem("admin_token");
             this.$toasted.show("Logout successfully ! you are back soon .", {
              type: "error",
              position: "top-center",
              duration: 10000,
            });
            this.$router.push({ name: "admin_login" });
            location.reload();
           
          }
        })
        .catch(() => {
          this.$toasted.show("some thing want to wrong", {
            type: "error",
            position: "top-center",
            duration: 4000,
          });
        });
    },
  },
  computed: {
    getAdmin() {
      return this.$store.getters.admin;
    },
  },
};
</script>

