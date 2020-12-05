<template>
  <div>
      <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'add_permission' }" class="btn btn-primary"
            ><i class="fa fa-plus"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">permission</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Permission List</h3>
              </div>
              <div class="box-body">
                <table
                  class="table table-responsive text-center table-striped table-bordered"
                >
                  <thead>
                    <tr>
                      <th>Serial</th>
                      <th>Name</th>
                      <th>Guard Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(permission, index) in permissions.data"
                      :key="index"
                    >
                      <td>{{ index + 1 }}</td>
                      <td>{{ permission.name }}</td>
                      <td>{{ permission.guard_name }}</td>
                      <td>
                        <router-link
                          class="btn btn-sm btn-success"
                          :to="{
                            name: 'edit_permission',
                            params: { id: permission.id },
                          }"
                          ><i class="fa fa-edit"></i
                        ></router-link>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-6">
                    <pagination
                      :limit="3"
                      :data="permissions"
                      @pagination-change-page="getPermissionList"
                    >
                      <span slot="prev-nav">&lt; Previous</span>
                      <span slot="next-nav">Next &gt;</span>
                    </pagination>
                  </div>
                  <div
                    class="col-lg-6 mt-1"
                    style="margin-top: 25px; text-align: right"
                  >
                    <p>
                      Showing <strong>{{ permissions.from }}</strong> to
                      <strong>{{ permissions.to }}</strong> of total
                      <strong>{{ permissions.total }}</strong> entries
                    </p>
                  </div>
                </div>
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
      permissions: {},
    };
  },
  methods: {
    getPermissionList(page = 1) {
      this.$Progress.start();
      axios.get("/api/get/permission/list?page=" + page).then((resp) => {
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


   
  },
};
</script>


<style>

 .box {
     margin-left:-100px;
 }

</style>