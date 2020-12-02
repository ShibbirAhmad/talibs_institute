<template>
  <div>
    <navbar></navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'admin_list' }" class="btn btn-primary">
            <i class="fa fa-arrow-right"></i>
          </router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"> <i class="fa fa-dashboard"></i>Dashboard </a>
          </li>
          <li class="active">Profile</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-lg-offset-3">
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img v-if="form.image"
                  class="profile-user-img img-responsive img-circle"
                  :src="base_url+form.image"
                />
                  <img v-else
                  class="profile-user-img img-responsive img-circle"
                  :src="base_url+'images/no_image.jpg'"
                />
                <h3 class="profile-username text-center" v-if="form.name">
                  {{ form.name }}
                </h3>
                <h3 class="profile-username text-center" v-else>.......</h3>

                <p class="text-muted text-center">Admin</p>
                 <form @submit.prevent="updateProfile">
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Name</b>
                    <div v-if="!editMode">
                      <a
                        class="pull-right text-bold text-black"
                        v-if="form.name"
                        style="margin-top: -18px"
                        >{{ form.name }}</a
                      >
                      <a class="pull-right" v-else>....</a>
                    </div>
                    <div v-else>
                      <input
                        type="text"
                        class="form-control"
                        v-model="form.name"
                        name="name"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <b>Phone</b>
                    <div v-if="!editMode">
                      <a
                        class="pull-right text-bold text-black"
                        v-if="form.phone"
                        style="margin-top: -18px"
                        >{{ form.phone }}</a
                      >
                      <a class="pull-right" v-else>....</a>
                    </div>
                    <div v-else>
                      <input
                        type="text"
                        class="form-control"
                        v-model="form.phone"
                        name="phone"
                        :class="{ 'is-invalid': form.errors.has('phone') }"
                      />
                      <has-error :form="form" field="phone"></has-error>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b>
                    <div v-if="!editMode">
                      <a
                        class="pull-right text-bold text-black"
                        v-if="form.email"
                        style="margin-top: -18px"
                        >{{ form.email }}</a
                      >
                      <a class="pull-right" v-else>....</a>
                    </div>
                    <div v-else>
                      <input
                        type="email"
                        class="form-control"
                        v-model="form.email"
                        name="email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <has-error :form="form" field="email"></has-error>

                      <br />
                      <b>Upload Image</b>
                      <div class="form-group">
                        <input
                          type="file"
                          name="image"
                          class="form-control"
                          @change="uploadImage"
                        />
                      </div>
                    </div>
                  </li>
                </ul>

                <div class="row">
                  <div :class="editMode ? 'col-lg-8' : 'col-lg-12'">
                    <a
                      href="#"
                      class="btn btn-primary btn-block"
                      @click.prevent="edit"
                    >
                      <b>{{ actionText }}</b>
                    </a>
                  </div>
                  <div class="col-lg-4" v-if="editMode">
                    <a
                      href="#"
                      class="btn btn-danger btn-block"
                      @click.prevent="(editMode = false), (actionText = 'Edit')"
                    >
                      <b>cancel</b>
                    </a>
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>


<script>
import Vue from "vue";
import { Form, HasError, AlertError } from "vform";

Vue.component(HasError.name, HasError);
export default {
  name: "Profile",
  created() {
    this.getAdmin();
    setTimeout(() => {
      this.loading = false;
    }, 500);
  },
  data() {
    return {
      form: new Form({
        name: "",
        phone:"",
        email: "",
        image: "",
   
      }),

      loading: true,
      error: "",
      base_url:this.$store.state.storage ,
      actionText: "Edit",
      editMode: false,
    };
  },

  methods: {
    updateProfile() {
      this.$Progress.start();
      this.form
        .post("/api/update/profile/admin", {
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })
        .then((resp) => {
          console.log(resp)
          if (resp.data.status == "OK") {
            this.$toasted.show(resp.data.message, {
              type: "success",
              position: "top-right",
              duration: 1000,
            });
            this.editMode = false;
            this.$router.push({ name: "admin_dashboard" });
            this.$Progress.finish();
          }
        })
        .catch((error) => {
          console.log(error);
          this.error = "some thing want to wrong";
        });
    },
    uploadImage(e) {
      const file = e.target.files[0];
      this.form.image=file ;
      ///let image file size check
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = (evt) => {
        let img = new Image();
        img.onload = () => {
            console.log('width:'+img.width);
        };
        img.src = evt.target.result;
      };
    },

    getAdmin() {
      axios.get("/api/single/admin").then((resp) => {
        this.form.name = resp.data.admin.name;
        this.form.email = resp.data.admin.email;
        this.form.phone = resp.data.admin.phone;
        this.form.image = resp.data.admin.image ;
      });
    },

    edit() {
      if (this.editMode == true) {
        this.updateProfile();
      } else {
        this.editMode = true;
        this.actionText = "Update";
      }
    },
  },
  computed: {},
};
</script>

<style scoped>
.mb-2 {
  margin-bottom: 5px !important;
}
</style>
