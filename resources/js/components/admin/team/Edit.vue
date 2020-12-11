<template>
  <div>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'team_member' }" class="btn btn-primary"
            ><i class="fa fa-arrow-left"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>member</a>
          </li>
          <li class="active">Edit</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Edit member Information</h3>
              </div>
              <div class="box-body">
                <h1 v-if="loading"><i class="fa fa-spinner fa-spin"></i></h1>
                 <form
                  v-else
                  @submit.prevent="updateMember"
                  @keydown="form.onKeydown($event)"
                  enctype="multipart/form-data"
                >
          
                   <div class="form-group">
                    <label>Joining Date</label>
                    <date-picker autocomplete="off"  :class="{'is-invaid' : form.errors.has('joining_date')}" v-model="form.joining_date" :config="options" > </date-picker>
                     <has-error :form="form" field="joining_date"></has-error>
                    </div>
                  <div class="form-group">
                    <label>Name</label>

                    <input
                      v-model="form.name"
                      type="text"
                      name="name"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('name') }"
                      autofocus
                      autocomplete="off"
                      placeholder="name"
                    />

                    <has-error :form="form" field="name"></has-error>
                  </div>
    
                  <div class="form-group">
                    <label for="">Position</label>
                    <select
                      v-model="form.position"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('designation') }"
                      name="designation"
                    >
                    <option value="">Select position</option>
                      <option value="1">Top Managemnt</option>
                       <option value="2">Manager</option>
                      <option value="3">Technical Team</option>
                     <option value="4">Business Team</option>
                      <option value="5">Office Assistant</option>
                    </select>
                    <has-error :form="form" field="designation"> </has-error>
                  </div>

                  <div class="form-group">
                    <label>Email</label>
                    <input
                      v-model="form.email"
                      type="email"
                      name="email"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('email') }"
                      autofocus
                      autocomplete="off"
                      placeholder="email"
                    />
                    <has-error :form="form" field="email"></has-error>
                  </div>

                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input
                      type="text"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('phone') }"
                      autocomplete="off"
                      autofocus
                      v-model="form.phone"
                      name="phone"
                      id=""
                    />
                    <has-error :form="form" field="phone"> </has-error>
                  </div>

                  <div class="form-group">
                    <label for="designation">Designation</label>

                    <textarea placeholder="write title about this member"
                      v-model="form.designation"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('designation') }"
                      name="designation"
                      id=""
                      rows="3"
                    ></textarea>

                    <has-error :form="form" field="designation"> </has-error>
                  </div>
                    <div class="form-group text-center">
                       <img
                      :src=" form.image ? base_url+form.image : base_url+'images/no_image.jpg'"
                      style="width: 200px; height: 200px" id="preview_image"
                    />
                    </div>
                  <div class="form-group">
                    <label>Image</label>
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
                 <div class="form-group">
                    <label>CV/Resume (doc,pdf or zip)</label>
                    <input
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.has('resume') }"
                      type="file"
                      @change="uploadResume"
                      name="resume"
                    />
                    <has-error :form="form" field="resume"></has-error>
                  </div>

                  <button
                    :disabled="form.busy"
                    type="submit"
                    class="btn btn-primary"
                  >
                    <i class="fa fa-spin fa-spinner" v-if="form.busy"></i>Update
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

Vue.component(HasError.name, HasError);

export default {
  created() {
    setTimeout(() => {
      this.loading = false;
    }, 500);

    this.getmember();
  },
  data() {
    return {
      form: new Form({
        name: "",
        designation: "",
        email: "",
        phone: "",
        position: "",
        image: "",
        resume:"",
        joining_date:"",
      }),
      options:{
            format:"DD-MM-YYYY",
            useCurrent: false ,
        },
      loading: true,
     base_url:this.$store.state.storage ,

    };
  },

  methods: {
    updateMember() {
      this.form
        .post("/api/team/member/info/update/" + this.$route.params.id, {
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })

        .then((resp) => {
            console.log(resp)
          if (resp.data.success == "OK") {
            this.$router.push({ name: "team_member" });
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

    getmember() {
      axios.get("/api/get/editing/team/member/" + this.$route.params.id).then((resp) => {
        if (resp.data.success == "OK") {
          this.form.name = resp.data.member.name;
          this.form.email = resp.data.member.email;
          this.form.phone = resp.data.member.phone;
          this.form.joining_date = resp.data.member.joining_date;
          this.form.position = resp.data.member.position;
          this.form.designation = resp.data.member.designation;
          this.form.image = resp.data.member.avator;
        }
      });
    },

    uploadImage(e) {
      const file = e.target.files[0];
      this.form.image = file;
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = (evt) => {
        let img = new Image();
        img.onload = () => {
          console.log(img.width + "-" + img.height);
        };
        document.getElementById('preview_image').src=evt.target.result;
      };
    },
    uploadResume(e){
      const file = e.target.files[0];
      this.form.resume= file ;
    }
  },
  computed: {},
};
</script>

<style scoped>
.mb-2 {
  margin-bottom: 5px !important;
}
</style>
