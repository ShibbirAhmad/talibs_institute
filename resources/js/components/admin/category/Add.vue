<template>
  <div>
      <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'category' }" class="btn btn-primary"
            ><i class="fa fa-arrow-right"></i
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
          <div class="col-lg-6 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Add Category</h3>
              </div>
              <div class="box-body">
                <form
                  @submit.prevent="addCategory"
                  enctype="multipart/form-data"
                >
                  <div class="form-group">
                    <label> Name </label>
                    <input
                      v-model="form.name"
                      :class="{ 'is-invalid': form.errors.has('name') }"
                      class="form-control"
                      type="text"
                      name="name"
                    />
                    <has-error :form="form" field="name"></has-error>
                  </div>
                  <br />
                  <div class="form-group">
                    <img v-if="this.preview_image.length"
                      :src="preview_image"
                      style="width: 100%; height: 200px"
                    />
                    <img v-else
                      :src="this.base_url+'images/no_image.jpg'"
                      style="width: 100%; height: 200px"
                    />  
                    <label>Image</label>
                    <input
                      type="file"
                      class="form-control"
                      @change="imageUpload"
                    />
                  </div>
                  <button
                    :disabled="form.busy"
                    class="btn btn-info"
                    type="submit"
                  >
                    <i class="fa fa-spiner"></i> submit
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
Vue.component(AlertError.name, AlertError);

export default {
  created() {},

  data() {
    return {
      form: new Form({
        name: "",
        image: "",
      }),
      preview_image: "",
      base_url:this.$store.state.storage ,
    };
  },
  methods: {
    addCategory() {
       this.$Progress.start()
      this.form
        .post("/api/add/category", {
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
              this.$Progress.finish()
              this.$toasted.show(resp.data.message,{
                type:'success',
                position:'top-center',
                duration:3000,
              });
              this.$router.push({ name : 'category'});
          }else{
             this.$Progress.fail()
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
</style>