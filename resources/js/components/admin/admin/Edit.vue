<template>
  <div>
    <navbar></navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'admin_list' }" class="btn btn-primary"
            ><i class="fa fa-arrow-right"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Edit Profile</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div style="margin-left:350px" class="col-lg-6 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Edit Admin</h3>
              </div>
              <div class="box-body">
                <h1 v-if="loading"><i class="fa fa-spinner fa-spin"></i></h1>
                <form
                  v-else
                  @submit.prevent="update"
                  @keydown="form.onKeydown($event)"
                  enctype="multipart/form-data"
                >
                  <div class="alert-danger alert" v-if="error">
                    {{ error }}
                  </div>
                  <div class="form-group">
                    <label>Name</label>
                    <input
                      v-model="form.name"
                      type="text"
                      name="name"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('name') }"
                      autofocus
                      autocomplete="off"
                      placeholder="name"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input
                      v-model="form.email"
                      type="email"
                      name="email"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('email') }"
                      autofocus
                      autocomplete="off"
                      placeholder="email"
                    />
                    <has-error :form="form" field="email"></has-error>
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <input
                      v-model="form.phone"
                      type="text"
                      name="phone"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('phone') }"
                    />
                    <has-error :form="form" field="phone"></has-error>
                  </div>
                  <div class="form-group text-center">
                    <img
                     
                      :src="form.image ? base_url + form.image:base_url+'images/no_image.jpg'"
                      id="preview_image"
                      style="width: 60%; height: 200px"
                    />
                  
                  </div>
                  <div class="form-group">
                    <label>Admin Image</label>
                    <input
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('image') }"
                      type="file"
                      @change="uploadImage"
                      name="image"
                    />
                    <has-error :form="form" field="image"></has-error>
                  </div>
                  <br />
                  <button
                    :disabled="form.busy"
                    type="submit"
                    class="btn btn-primary"
                  >
                    <i class="fa fa-spin fa-spinner" v-if="form.busy"></i>Submit
                  </button>
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
Vue.component(AlertError.name, AlertError);

export default {
  created() {
    console.log(this.$route.params.adminId);
    this.adminId = this.$route.params.adminId;
    this.getAdmin();
    setTimeout(() => {
      this.loading = false;
    }, 500);
  },
  data() {
    return {
      form: new Form({
        name: "",
        email: "",
        phone: "",
        image: "",
      }),
      loading: true,
      preview_image: "",
      error: "",
      base_url: this.$store.state.storage,
    };
  },

  methods: {
    getAdmin() {
      axios
        .get("/api/get/edit/admin/" + this.$route.params.id)
        .then((resp) => {
          console.log(resp);
          if (resp.data.status == "SUCCESS") {
            this.form.name = resp.data.admin.name;
            this.form.email = resp.data.admin.email;
            this.form.phone = resp.data.admin.phone;
            this.form.image = resp.data.admin.image;
          } else {
            this.$toasted.show("some thing want to wrong", {
              type: "error",
              position: "top-center",
              duration: 5000,
            });
          }
        })
        .catch((error) => {
          console.log(error);
          this.$toasted.show("some thing want to wrong", {
            type: "error",
            position: "top-center",
            duration: 5000,
          });
        });
    },
    update() {
      this.$Progress.start();
      this.form
        .post("/api/update/admin/" + this.$route.params.id, {
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
          onUploadProgress: (e) => {
            // Do whatever you want with the progress event
            console.log(e);
          },
        })
        .then((resp) => {
          console.log(resp);
          if (resp.data.status == "SUCCESS") {
            this.$router.push({ name: "admin_list" });
            this.$toasted.show(resp.data.message, {
              type: "success",
              position: "top-center",
              duration: 4000,
            });
              this.$Progress.finish();
          } else {
            this.error = "some thing want to wrong";
          }
        })
        .catch((error) => {
          console.log(error);
          this.error = "some thing want to wrong";
        });
    },
    uploadImage(e) {
      const file = e.target.files[0];
      this.form.image=file;
      let reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload= (evt) =>{
              let img = new Image();
              img.onload= () =>{
                  console.log('width:'+img.width);
              }
              
              document.getElementById('preview_image').src=evt.target.result;
               // this.preview_image = evt.target.result ;

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
