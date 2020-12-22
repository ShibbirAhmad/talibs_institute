<template>
  <div>
    <navbar></navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'carrier_list' }" class="btn btn-primary"
            ><i class="fa fa-arrow-left"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>carrier</a>
          </li>
          <li class="active">Edit</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Edit job info</h3>
              </div>
              <div class="box-body">
                <h1 v-if="loading"><i class="fa fa-spinner fa-spin"></i></h1>
                <form
                  v-else
                  @submit.prevent="updateCarrier"
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
                    <img
                      style="max-width: 80%;height:300px;" 
                      :src="form.image ? base_url+form.image : base_url+'images/no_image.jpg'"
                      id="preview"
                      class="image-responsive"
                    />
  
                  </div>
                  <div class="form-group">
                    <label>Feature Image</label>
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
                  <button
                    :disabled="form.busy"
                    type="submit"
                    class="btn btn-primary btn-block"
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
import { Form, HasError, AlertError } from "vform";
import datePicker from 'vue-bootstrap-datetimepicker';
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

Vue.component(HasError.name, HasError);

export default {
  
  created() {
    setTimeout(() => {
      this.loading = false;
    }, 500);
    this.getCarrier();
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
       base_url:this.$store.state.storage ,
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
     
     
   
    };
  },

  methods: {
    updateCarrier() {
      this.form
        .post("/api/carrier/update/"+this.$route.params.id, {
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

    getCarrier(){
        axios.get('/api/get/carrier/edit/'+this.$route.params.id)
        .then(resp=>{
            console.log(resp);
            if (resp.data.success == "OK") {
                this.form.title=resp.data.carrier.title ;
                this.form.vacency=resp.data.carrier.vacency ;
                this.form.deadline=resp.data.carrier.deadline ;
                this.form.description=resp.data.carrier.description ;
                this.form.image=resp.data.carrier.image ;
            }
        })
    },

    uploadImage(e) {
      const file = e.target.files[0];
        this.form.image = file;
      ///let image file size check
      let reader = new FileReader();

      reader.readAsDataURL(file);
      reader.onload = (evt) => {
        let img = new Image();

        img.onload = () => {
          console.log(img.width + "-" + img.height);
        };
        document.getElementById('preview').src=evt.target.result;
      
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
