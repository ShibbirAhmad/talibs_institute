<template>
  <div>
    <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'post_list' }" class="btn btn-primary"
            ><i class="fa fa-arrow-left"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Post</li>
        </ol>
      </section>
      <section class="content">
        <div class="row">
          <form @submit.prevent="addPost" enctype="multipart/form-data">
            <div style="margin-left:100px" class="col-md-10 col-sm-10 ">
              <div class="box_body">
                <br />
                 <h4 style="text-align:center;font-size:22px;" class="heading display_title">Add Post</h4>           
                <div class="inner_box">
                   <div class="form-group">
                    <label> Post Title </label>
                    <input
                      v-model="form.title"
                      :class="{ 'is-invalid': form.errors.has('title') }"
                      class="form-control"
                      type="text"
                      placeholder="example:- english is an international "
                      name="title"
                    />
                    <has-error :form="form" field="title"></has-error>
                  </div>
                  <br />
                  <div class="form-group">
                    <label> Post Category </label>
                    <select
                      name="category_id"
                      v-model="form.category_id"
                      :class="{ 'is-invalid': form.errors.has('category_id') }"
                      class="form-control"
                    >
                      <option value="select category" disabled>
                        select category
                      </option>
                      <option
                        v-for="(category, index) in categories.data"
                        :key="index"
                        :value="category.id"
                      >
                        {{ category.name }}
                      </option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                  </div>
                  <br />
                  <div class="form-group text-center">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="file_upload">
                          <label for="uploadImage">
                            upload feature image
                            <i class="fa uploadIcon fa-cloud-upload"></i>
                          </label>
                          <input
                            type="file"
                            @change="imageUpload"
                            id="uploadImage"
                            style="display: none"
                             :class="{ 'is-invalid': form.errors.has('category_id') }"
                          />
                           <has-error :form="form" field="image"></has-error>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <img
                          v-show="preview_image"
                          :src="preview_image"
                          class="preview_image"
                        />
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-group">
                    <ckeditor
                      :editor="editor"
                      :class="{ 'is-invalid': form.errors.has('description') }"
                      v-model="form.description"
                    >
                    </ckeditor>
                    <has-error :form="form" field="description"> </has-error>
                  </div>
                  <br />
                  <br />
                </div>
              </div>
            </div>

            <div class="form-group text-center">
              <button
                :disabled="form.busy"
                class="btn btnPublish btn-info"
                type="submit"
              >
                <i class="fa fa-spiner"></i>
                <i class="fa fa-bullhorn"></i> Publish Post
              </button>
            </div>
          </form>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

import { Form, HasError, AlertError } from "vform";
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

export default {
  created() {
    this.getCategories();
  },

  data() {
    return {
      form: new Form({
        title: "",
        category_id: "select category",
        image: "",
        description: "<p>write blog details here.... </p>",
      }),
      editor: ClassicEditor,
      date: new Date(),
      categories: "",
      preview_image: "",
      base_url: this.$store.state.storage,
    };
  },
  methods: {
    getCategories() {
      axios.get("/api/get/category/list").then((resp) => {
        this.categories = resp.data.categories;
      });
    },

    addPost() {
      this.$Progress.start();
      this.form
        .post("/api/add/blog/post", {
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
            this.$router.push({ name: "post_list" });
          } else {
            this.$Progress.fail();
          }
        });
    },

    imageUpload(event) {
      const file = event.target.files[0];
      //read upload image
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = (evt) => {
        let img = new Image();
        img.onload = () => {
          console.log(
            "image width: " + img.width + "-" + "height:" + img.height
          );
        };
        img.src = evt.target.result;
        this.preview_image = evt.target.result;
        this.form.image = file;
      };
    },
  },
};
</script>


<style>

.box_body {
  box-shadow: 1px 1px 2px #3c8dbc;
  background: #fff;
  margin-left: -4px;
}
.inner_box {
  margin: 10px;
}

.file_upload {
  width: 300px;
  height: 160px;
  border: 3px dashed;
}

.uploadIcon {
  font-size: 150px;
  cursor: pointer;
}

.preview_image {
  width: 50%;
  height: 160px;
  margin-left: 5px;
}

.ck-editor__editable {
  min-height: 200px;
}

.btnPublish {
  padding: 10px;
  margin: 20px;
  font-size: 20px;
  border: 1px dashed;
}
</style>