<template>
  <div>
      <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'add_category' }" class="btn btn-primary"
            ><i class="fa fa-plus"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Category</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Category List</h3>
              </div>
              <div class="box-body">
                <table
                  class="table table-responsive text-center table-striped table-bordered"
                >
                  <thead>
                    <tr>
                      <th>Serial</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(category, index) in categories.data"
                      :key="index"
                    >
                      <td>{{ index + 1 }}</td>
                      <td>{{ category.name }}</td>
                      <td>
                        <img
                          :src="base_url + category.image"
                          class="small-image"
                        />
                      </td>
                      <td>
                        <span v-if="category.status == 1" class="badge"
                          >active</span
                        >
                        <span v-else class="badge">De-active</span>
                      </td>
                      <td>
                        <router-link
                          class="btn btn-sm btn-success"
                          :to="{
                            name: 'edit_category',
                            params: { id: category.id },
                          }"
                          ><i class="fa fa-edit"></i
                        ></router-link>
                        <button
                          v-if="category.status == 1"
                          @click="deActiveCategory(category.id)"
                          class="btn btn-sm btn-warning"
                        >
                          <i class="fa fa-ban"> </i>
                        </button>

                        <button
                          v-else
                          @click="activeCategory(category.id)"
                          class="btn btn-sm btn-primary"
                        >
                          <i class="fa fa-check"> </i>
                        </button>

                        <button @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-6">
                    <pagination
                      :limit="3"
                      :data="categories"
                      @pagination-change-page="getCategoryList"
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
                      Showing <strong>{{ categories.from }}</strong> to
                      <strong>{{ categories.to }}</strong> of total
                      <strong>{{ categories.total }}</strong> entries
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
    this.getCategoryList();
  },

  data() {
    return {
      categories: {},
      base_url: this.$store.state.storage,
    };
  },
  methods: {
    getCategoryList(page = 1) {
      this.$Progress.start();
      axios.get("/api/get/category/list").then((resp) => {
        console.log(resp);
        if (resp.data.status == "OK") {
          this.categories = resp.data.categories;
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

    activeCategory(category_id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You want active this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/active/category/" + category_id)
            .then((resp) => {
              if (resp.data.status == "OK") {
                this.getCategoryList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("some thing want to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              this.$toasted.show("some thing want to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("Ok ! no action here", {
            position: "top-center",
            type: "info",
            duration: 3000,
          });
        }
      });
    },

    deActiveCategory(category_id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You want de-active this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/de-active/category/" + category_id)
            .then((resp) => {
              if (resp.data.status == "OK") {
                this.getCategoryList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("some thing want to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              this.$toasted.show("some thing want to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("Ok ! no action here", {
            position: "top-center",
            type: "info",
            duration: 3000,
          });
        }
      });
    },

    deleteCategory(category_id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You want delete this category!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/delete/category/" +category_id)
            .then((resp) => {
              //console.log(resp)
              if (resp.data.status == "OK") {
                this.getCategoryList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("some thing want to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              console.log(error);
              this.$toasted.show("some thing want to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("Ok ! no action here", {
            position: "top-center",
            type: "info",
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