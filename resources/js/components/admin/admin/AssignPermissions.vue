<template>
  <div>
    <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'admin_list' }" class="btn btn-primary"
            ><i class="fa fa-arrow-left"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Role</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header text-center with-border">
                <h3 class="box-title">
                  SELECT PERMISSIONS TO  ASSIGN  
                  <b style="color: green"> {{ admin_name }} </b>
                </h3>
              </div>
              <form @submit.prevent="AssignPermissions">
                <div class="box-body">
                  <div class="form-group">
                    <div
                      class="box_container"
                      v-for="(permission, index) in permissions"
                      :key="index"
                    >
                      <label
                        style="display: flex"
                        :for="'permission' + permission.id"
                      >
                        <input
                          style="width: 30px; height: 20px"
                          v-model="form.permission_id"
                          type="checkbox"
                          autocomplete="off"
                          :value="permission.id"
                          :id="'permission' + permission.id"
                        />
                        <span style="margin: 4px">{{ permission.name }}</span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group text-center">
                  <button style="margin-bottom:20px;"
                    class="btn btn-lg btn-success"
                    :disabled="form.busy"
                    type="submit"
                  >
                    <i class="fa fa-spiner"></i>submit
                  </button>
                </div>
              </form>
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
    this.getPermissionList();
  },

  data() {
    return {
      permissions: [],
      admin_name: "",
      form: new Form({
        permission_id: [],
      }),
    };
  },
  methods: {
    getPermissionList(page = 1) {
      this.$Progress.start();
      axios
        .get("/api/get/permissions/assign/for/model/" + this.$route.params.id)
        .then((resp) => {
          console.log(resp);
          if (resp.data.status == "OK") {
            this.permissions.push(...resp.data.permissions);
            this.admin_name = resp.data.admin_name;
            if (resp.data.model_has_permissions_id.length) {
                resp.data.model_has_permissions_id.forEach((element) => {
                this.form.permission_id.push(element);
              });
            }
            this.$Progress.finish();
          } else {
            this.$Progress.fail();
            this.toasted.show("something happend wrong", {
              type: "error",
              position: "top-center",
              duration: 3000,
            });
          }
        });
    },

    AssignPermissions() {
      this.$Progress.start();
      this.form
        .post("/api/update/assign/permission/to/model/" + this.$route.params.id, {
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })
        .then((resp) => {
           console.log(resp);
          if (resp.data.status == "OK") {
            this.$toasted.show(resp.data.message, {
              type: "success",
              duration: 4000,
              position: "top-center",
            });
            this.$router.push({ name: "admin_list" });
            this.$Progress.finish();
          }
        });
    },
  },
};
</script>


<style>
.box {
  margin-left: -100px;
}

.box_container {
  background: #1692d9;
  margin: 20px;
  color: #fff;
  border: dashed 1px;
  float: left;
}
</style>