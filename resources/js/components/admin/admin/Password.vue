<template>
  <div>
    <navbar></navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">password</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header text-center with-border">
                <h3 class="box-title">Change password</h3>
              </div>
              <div class="box-body">
            
                <form
                  @submit.prevent="updatePassword"
                  @keydown="form.onKeydown($event)"
                  enctype="multipart/form-data"
                >
                  <div class="alert-danger alert" v-if="error">
                    {{ error }}
                  </div>

                  <div class="form-group">
                    <label>Current Password</label>
                    <input
                      v-model="form.old_password"
                      type="password"
                      name="old_password"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('old_password') }"
                    
                      autocomplete="off"
                      placeholder="your current password"
                    />
                    <has-error :form="form" field="old_password"></has-error>
                  </div>

                  <div class="form-group">
                    <label>new Password</label>
                    <input
                      v-model="form.new_password"
                      type="password"
                      name="new_password"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('new_password') }"
               
                      autocomplete="off"
                      placeholder="your new password"
                    />
                    <has-error :form="form" field="new_password"></has-error>
                  </div>
                  <br />

                  <button
                    :disabled="form.busy"
                    type="submit"
                    class="btn btn-primary"
                  >
                    <i class="fa fa-spin fa-spinner" v-if="form.busy"></i>update
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
import { Form, HasError } from "vform";
Vue.component(HasError.name, HasError);

export default {
  created() {},
  data() {
    return {
      form: new Form({
        old_password: "",
        new_password: "",
      }),
      error: "",
    };
  },

  methods: {
    updatePassword() {
      this.$Progress.start();
      this.form
        .post("/api/current/admin/password/update", {
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })
        .then((resp) => {
          console.log(resp);
          if (resp.data) {
            Swal.fire({
              type: "info",
              text: resp.data.message,
            });
          this.$Progress.finish();
          this.$router.push({ name : 'admin_dashboard'});
          }
        })
        .catch((error) => {
          console.log(error);
          this.error = "some thing want to wrong";
        });
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
