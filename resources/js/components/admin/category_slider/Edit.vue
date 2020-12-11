<template>
  <div>
    <admin-main></admin-main>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{name:'category_slider_list'}" class="btn btn-primary">
            <i class="fa fa-arrow-right"></i>
          </router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#">
              <i class="fa fa-dashboard"></i>Dashboard
            </a>
          </li>
          <li class="active">Category slider Edit </li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">
                  Edit category or subCategory slider
                  <small>({{ image_size_text }})</small>
                </h3>
              </div>
              <div class="box-body">
                <div class="alert-danger alert" v-if="error">{{error}}</div>

                <h1 v-if="loading">
                  <i class="fa fa-spin fa-spinner"></i>
                </h1>

                <form
                  @submit.prevent="updateSlider"
                  v-else
                  @keydown="form.onKeydown($event)"
                  enctype="multipart/form-data"
                >
                  <div class="row">
                    <div class="col-lg-12">
                       <div class="form-group">
                        <label for="url">url</label>
                        <input type="text" class="form-control " v-model="form.url" :class="{'is-invalid': form.errors.has('url') }" name="url" id="">
                        <has-error  :form="form" field="url" > </has-error>
                      </div>
                      <div class="form-group">
                        <label>Postion</label>
                        <select
                          name="page_postion"
                          class="form-control"
                          v-model="form.page_position"
                          :class="{ 'is-invalid': form.errors.has('page_postion') }"
                        >
                          <option value="1">Category Slider</option>
                          <option value="2">subCategory Slider </option>
                           <option value="3">subSubCategory Slider </option>
                        </select>
                        <has-error :form="form" field="image"></has-error>
                      </div>

                      <div class="preview-image">

                        <img class="img-responsive" :src="form.preview_image" alt="slider" />
                       
                      </div>
                      <div class="form-group">
                        <label for="file" class="selectFile">select a file</label>
                        <input
                          style="display: none;"
                          class="form-control"
                          id="file"
                          :class="{ 'is-invalid': form.errors.has('image') }"
                          type="file"
                          @change="uploadImage"
                          name="image"
                        />
                        <has-error :form="form" field="image"></has-error>
                      </div>
                    </div>
                  </div>
                  <br />
                  <button
                    type="submit"
                    class="btn btn-primary btn-block"
                  >
                    <i class="fa fa-spin fa-spinner" v-if="form.busy"></i>Save
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
export default {
  name: "subCategory",
  created() {
    this.getEditSlider();
    setTimeout(() => {
      this.loading = false;
    }, 500);
  },
  data() {
    return {
      form: new Form({
        image: "",
        preview_image:"",
        page_position: "",
        url: "",
     
      }),
      error: "",
      loading: true,
      image_width: 1184,
      image_height: 250,
      imagae_size:550,
      image_size_text: "Image size must be 1184*350px",
     base_url:this.$store.state.image_base_link,

    };
  },

  methods: {
      
      getEditSlider(){

            axios.get('/api/category/get/edit/slider/'+this.$route.params.id)
            .then(resp => {
              //  console.log(resp)
                if (resp.data.success== "OK") {
                    this.form.page_position=resp.data.slider.page_position ;
                    this.form.url=resp.data.slider.url ;
                    this.form.preview_image= this.base_url+resp.data.slider.image ;
                    this.form.image= resp.data.slider.image ;
                }
            })
            .catch()
      },
    updateSlider() {
      this.form
        .post("/api/category/slider/update/"+this.$route.params.id, {
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })
        .then((resp) => {
          console.log(resp)
          if (resp.data.status == "SUCCESS") {
            this.$router.push({ name: "category_slider_list" });
            this.$toasted.show(resp.data.message, {
              type: "success",
              position: "top-center",
              duration: 4000,
            });
          } else {
            this.error = "some thing want to wrong";
          }
        })
        .catch((error) => {
          this.error = error.response.data.errors;
          this.$toasted.show("some thing want to wrong", {
            type: "error",
            position: "top-center",
            duration: 5000,
          });
        });
    },
    uploadImage(e) {
      const file = e.target.files[0];
     if (!file.type.match("image.*")) {
         Swal.fire({
          type:'warning',
          text:'this is not any kind of image',
        });
        return;
      }
       if(file.size/1024>this.imagae_size){
        Swal.fire({
          type:'warning',
          text:`File size can not be bigger then ${this.imagae_size}KB.Reference file size is'+file.size/1024 +'KB`,
        });
        return;
      }
 ///let image file size check
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = (evt) => {
        let img = new Image();
        img.onload = () => {
          console.log(img.width, img.height);
          if (
            img.width == this.image_width &&
            img.height == this.image_height
          ) {
            this.setImage(file, evt);
            return;
          } 
        };
        img.src = evt.target.result;
      };
    },
    setImage(file, evt) {
      console.log(file);
      this.form.image = file;
      this.form.preview_image = evt.target.result;
    },

  },
  computed: {},
};
</script>

<style scoped>
.mb-2 {
  margin-bottom: 5px !important;
}
label.selectFile {
  width: 150px;
  background: #fff;
  color: #222d32;
  padding: 10px 10px;
  text-align: center;
  font-size: 20px;
  border-radius: 5px;
  margin-top: 15px;
  cursor: pointer;
  border: 1px solid #222d32;
}
</style>
