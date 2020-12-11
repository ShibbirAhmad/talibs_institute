<template>
  <div>
      <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'add_post' }" class="btn btn-primary"
            ><i class="fa fa-plus"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">post</li>
        </ol>
      </section>
      <section class="content">
        <div class="row table_row justify-content-center">
          <div class="col-md-11 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Post List</h3>
              </div>
              <div class="box-body">
                <table
                  class="table table-responsive table-striped table-bordered"
                >
                  <thead>
                    <tr>
                      <th>Serial</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Comments</th>
                      <th>Image</th>
                      <th>status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(post, index) in posts.data"
                      :key="index"
                    >
                      <td>{{ index + 1 }}</td>
                      <td>{{ post.title.substr(0,60) }}</td>
                      <td>{{ post.admin_name.name }}</td>
                      <td> 0 </td>
                      <td>
                        <img
                          :src="post.image ? base_url + post.image : base_url+'images/no_image.jpg'"
                          class="small-image"
                        />
                      </td>
                      <td>
                        <span v-if="post.status == 1" class="badge"
                          >active</span
                        >
                        <span v-else class="badge">De-active</span>
                      </td>
                      <td>
                        <router-link
                          class="btn btn-sm btn-success"
                          :to="{
                            name: 'edit_post',
                            params: { id: post.id },
                          }"
                          ><i class="fa fa-edit"></i
                        ></router-link>
                        <button
                          v-if="post.status == 1"
                          @click="deActivePost(post.id)"
                          class="btn btn-sm btn-warning"
                        >
                          <i class="fa fa-ban"> </i>
                        </button>

                        <button
                          v-else
                          @click="activePost(post.id)"
                          class="btn btn-sm btn-primary"
                        >
                          <i class="fa fa-check"> </i>
                        </button>

                        <button @click="deletePost(post.id)" class="btn btn-sm btn-danger">
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
                      :data="posts"
                      @pagination-change-page="getPostList"
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
                      Showing <strong>{{ posts.from }}</strong> to
                      <strong>{{ posts.to }}</strong> of total
                      <strong>{{ posts.total }}</strong> entries
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
    this.getPostList();
  },

  data() {
    return {
      posts: {},
      base_url: this.$store.state.storage,
    };
  },
  methods: {
    getPostList(page = 1) {
      this.$Progress.start();
      axios.get("/api/get/blog/post/list?page="+page)
      .then((resp) => {
        console.log(resp);
        if (resp.data.status == "OK") {
          this.posts = resp.data.posts;
          this.$Progress.finish();
        } else {
          this.$Progress.fail();
          this.$toasted.show("something happend wrong", {
            type: "error",
            position: "top-center",
            duration: 3000,
          });
        }
      });
    },

    activePost(post_id) {
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
            .get("/api/blog/post/active/" + post_id)
            .then((resp) => {
              if (resp.data.status == "OK") {
                this.getPostList();
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

    deActivePost(post_id) {
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
            .get("/api/blog/post/de-active/" + post_id)
            .then((resp) => {
              if (resp.data.status == "OK") {
                this.getPostList();
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

    deletePost(post_id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You want delete this post!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/blog/post/delete/" +post_id)
            .then((resp) => {
              //console.log(resp)
              if (resp.data.status == "OK") {
                this.getPostList();
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

 .table_row{
    margin-right: 5px;
    margin-left: -169px;
 }

</style>