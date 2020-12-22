<template>
  <div>
    <navbar></navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'carrier_list' }" class="btn btn-primary"
            ><i class="fa fa-arrow-right"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>carrier</a>
          </li>
          <li class="active">Add</li>
        </ol>
      </section>
      <section class="content">
        <div  class="row justify-content-center">
          <div class="col-lg-10 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Add carrier</h3>
              </div>
              <div class="box-body">
                <h1 v-if="loading"><i class="fa fa-spinner fa-spin"></i></h1>
                <form
                  v-else
                  @submit.prevent="addCarrier"
                  @keydown="form.onKeydown($event)"
                  enctype="multipart/form-data"
                >
                  <ul class="list-group" v-if="errors">
                    <li
                      class="list-group-item"
                      v-for="(error, index) in errors"
                      :key="index"
                    >
                      {{ error.name }}
                    </li>
                  </ul>
                  <div class="form-group">
                    <label>Job Title</label>

                    <input
                      v-model="form.title"
                      type="text"
                      name="title"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('title') }"
                      autofocus
                      placeholder="write job title"
                    />

                    <has-error :form="form" field="title"></has-error>
                  </div>

                  <div class="form-group">
                    <label>Vacency</label>
                    <input
                      v-model="form.vacency"
                      type="text"
                      name="vacency"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('vacency') }"
                      autofocus
                      autocomplete="off"
                      placeholder="Number of vacency"
                    />
                    <has-error :form="form" field="vacency"></has-error>
                  </div>

                  <div class="form-group">
                    <label for="phone">Job Deadline </label>
                    <date-picker autocomplete="off" :config="options" v-model="form.deadline"> </date-picker>
              
                  </div>

                  <div class="form-group">
                    <label for="phone_office">Description </label>
                        <ckeditor  :class="{ 'is-invalid' : form.errors.has('description') }" :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
                        <has-error :form="form" field="description"> </has-error>
                  </div>
                  <div class="form-group text-center">

                    <img v-show="preview_image" :src="preview_image" style="max-width:80%;" >
            
                  </div>
                  <div class="form-group">
                    <label> Feature Image</label>
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
                  <div class="form-group text-center">
                   <button
                    :disabled="form.busy"
                    type="submit"
                    class="btn btn-lg btn-primary"
                  >
                    <i class="fa fa-spin fa-spinner" v-if="form.busy"></i>post
                  </button>
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
import datePicker from 'vue-bootstrap-datetimepicker';
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

Vue.component(HasError.name, HasError);

export default {
  
  created() {
    setTimeout(() => {
      this.loading = false;
    }, 500);
  },
  data() {
    return {
      form: new Form({
        title:"",
        vacency:"",
        deadline:"",
        description: "",
        image: "",
      }),
      base_url:this.$store.state.storage,
      options:{
          format:"DD-MM-YYYY",
          useCurrent:false ,
      },
      editor: ClassicEditor,
      editorConfig: {
            // The configuration of the editor.
        },
      loading: true,
      errors: [],
      preview_image: "",
    };
  },

  methods: {
    addCarrier() {
      this.form
        .post("/api/carrier/add/post", {
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })
        .then((resp) => {
          console.log(resp);
          if (resp.data.success == "OK") {
            this.$router.push({ name: "carrier_list" });
            this.$toasted.show(resp.data.message, {
              type: "success",
              position: "top-center",
              duration: 4000,
            });
          }
        })
        .catch((e) => {
          this.errors = [];
          this.errors.push(e.response.data.errors);
        });
    },


    uploadImage(e) {
      const file = e.target.files[0];

      ///let image file size check
      let reader = new FileReader();

      reader.readAsDataURL(file);
      reader.onload = (evt) => {
        let img = new Image();

        img.onload = () => {
          console.log(img.width + "-" + img.height);
        };

        img.src = evt.target.result;
        this.preview_image = evt.target.result;
        this.form.image = file;
      };
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
