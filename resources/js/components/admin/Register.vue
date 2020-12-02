<template>
  <div>
    <div class="content-wrapper">
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-md-1"></div>
          <div class="col-lg-4 col-md-4 col-lg-offset-2">
            <div style="margin-top: 100px" class="box box-primary">
              <div class="box-header text-center with-border">
                <h3 class="box-title">Login in to start your session</h3>
              </div>
              <div class="box-body">
                <form @submit.prevent="adminRegister">
                  <div class="form-group">
                    <label> Name </label>
                    <input
                      v-model="form.name"
                      :class="{ 'is-invalid': form.errors.has('name') }"
                      class="form-control"
                      type="text"
                      name="name"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label> Email </label>
                    <input
                      v-model="form.email"
                      :class="{ 'is-invalid': form.errors.has('email') }"
                      class="form-control"
                      type="text"
                      email="email"
                    />
                    <has-error :form="form" field="email"></has-error>
                  </div>

                  <div class="form-group">
                    <label>Phone </label>
                    <input
                      v-model="form.phone"
                      :class="{ 'is-invalid': form.errors.has('phone') }"
                      class="form-control"
                      type="text"
                      name="phone"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>

                  <div class="form-group">
                    <label> Password </label>
                    <input
                      v-model="form.password"
                      :class="{ 'is-invalid': form.errors.has('password') }"
                      class="form-control"
                      type="password"
                      email="password"
                    />
                    <has-error :form="form" field="password"></has-error>
                  </div>
                  <br />
                  <div class="text-center form-group">
                    <button
                      :disabled="form.busy"
                      class="btn btn-lg btn-info"
                      type="submit"
                    >
                      <i class="fa fa-spiner"></i>
                      <i class="fa fa-cogs"></i> Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-4"></div>
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
    let body = document.getElementsByTagName("body")[0];
    body.classList.remove("skin-blue");
    body.style.backgroundColor = "#ecf0f5";
    console.log(body);
    console.log("created");
  },

  data() {
    return {
      form: new Form({
        email: "",
        name: "",
        phone: "",
        password: "",
      }),
    };
  },
  methods: {
    adminRegister() {
      this.$Progress.start();
      this.form
        .post("/api/add/category", {
          // Transform form data to FormData
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })
        .then((resp) => {
          console.log(resp);
          if (resp.data.status == "OK") {
            this.$Progress.finish();
            this.$toasted.show(resp.data.message, {
              type: "success",
              position: "top-center",
              duration: 3000,
            });
            this.$router.push({ email: "category" });
          } else {
            this.$Progress.fail();
          }
        });
    },
  },
};

window.addEventListener("DOMContentLoaded", (event) => {
  $("#navBar").hide();

  document.getElementsByTagName("body")[0].background = "#ddd";
});
</script>


<style>
</style>