<template>
  <div>
    <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'manage_role' }" class="btn btn-primary"
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
                <h3 class="box-title">Select permissions</h3>
              </div>
              <div class="box-body">
                <form @submit.prevent="AssignPermissions">
                    <div class="box_container "
                      v-for="(permission, index) in permissions"
                      :key="index"
                    >
                    <label style="display:flex" :for="'permission'+permission.id">
                      <input style="width:30px;height:20px"

                        v-model="form.permission_id"
                        type="checkbox" autocomplete="off"
                        :value="permission.name"
                        :id="'permission'+permission.id"
                      /> 
                      <span style="margin:4px">{{ permission.name }}</span>
                      </label>
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
Vue.component(AlertError.name, AlertError);

export default {
  created() {
    this.getPermissionList();
  },

  data() {
    return {
      permissions: "",
      form: new Form({
        permission_id: [],
      }),
    };
  },
  methods: {
    getPermissionList(page = 1) {
      this.$Progress.start();
      axios.get("/api/get/permissions/for/assign/role").then((resp) => {
        console.log(resp);
        if (resp.data.status == "OK") {
          this.permissions = resp.data.permissions;
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

    AssignPermissions() {},
  },
};
</script>


<style>
.box {
  margin-left: -100px;
}

.box_container {
  background: #1692d9;
  margin:20px;
  color:#fff;
  border:dashed 1px;
  float:left;

}


</style>