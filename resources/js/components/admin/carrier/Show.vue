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
          <li class="active">Show</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center" >
          <div class="col-lg-10 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Show job info</h3>
              </div>
              <div class="box-body">
                <h1 v-if="loading"><i class="fa fa-spinner fa-spin"></i></h1>
                <form v-else>
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
                      disabled
                      name="title"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('title') }"
                    />

                    <has-error :form="form" field="title"></has-error>
                  </div>

                  <div class="form-group">
                    <label>Vacency</label>
                    <input
                      v-model="form.vacency"
                      disabled
                      name="vacency"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('vacency') }"
                    />
                    <has-error :form="form" field="vacency"></has-error>
                  </div>

                  <div class="form-group">
                    <label for="phone">Job Deadline </label>
                    <input
                      class="form-control"
                      disabled
                      v-model="form.deadline"
                      id=""
                    />
                  </div>

                  <div class="form-group">
                    <label for="phone_office">Description </label>
                    <ckeditor
                      :class="{ 'is-invalid': form.errors.has('description') }"
                      :editor="editor"
                      v-model="form.description"
                      :config="editorConfig"
                    ></ckeditor>
                    <has-error :form="form" field="description"> </has-error>
                  </div>

                  <div class="form-group text-center">
                    <img
                      v-if="form.image"
                      style="max-width: 80%"
                      :src="base_url + form.image"
                      class="image-responsive"
                    />
                    <img
                      v-else
                      style="max-width: 80%"
                      :src="base_url + 'images/no_image.jpg'"
                      class="image-responsive"
                    />
                  </div>
                  <br />
                </form>
                <router-link
                  class="btn btn-primary btn-block"
                  :to="{ name: 'carrier_list' }"
                >
                  Go Back
                </router-link>
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
import datePicker from "vue-bootstrap-datetimepicker";
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
        title: "",
        vacency: "",
        deadline: "",
        description: "",
        image: "",
      }),
      options: {
        format: "DD-MM-YYYY",
        useCurrent: false,
      },
      base_url: this.$store.state.storage,
      editor: ClassicEditor,
      editorConfig: {
        // The configuration of the editor.
      },
      loading: true,
      errors: [],
    };
  },

  methods: {
    getCarrier() {
      axios.get("/api/get/carrier/edit/" + this.$route.params.id).then((resp) => {
        console.log(resp);
        if (resp.data.success == "OK") {
          this.form.title = resp.data.carrier.title;
          this.form.vacency = resp.data.carrier.vacency;
          this.form.deadline = resp.data.carrier.deadline;
          this.form.description = resp.data.carrier.description;
          this.form.image = resp.data.carrier.image;
        }
      });
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
