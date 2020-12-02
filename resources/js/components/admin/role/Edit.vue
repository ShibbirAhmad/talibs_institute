<template>
  <div>
      <navbar> </navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'role_list' }" class="btn btn-primary"
            ><i class="fa fa-arrow-right"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Role</li>
        </ol>
      </section>
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-lg-offset-2">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Add Role</h3>
              </div>
              <div class="box-body">
                <form
                  @submit.prevent="updateRole"
                >
                  <div class="form-group">
                    <label> Role Name </label>
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
                    <label> Guarde Name </label>
                    <input
                      v-model="form.guard_name"
                      :class="{ 'is-invalid': form.errors.has('guard_name') }"
                      class="form-control"
                      type="text"
                      name="guard_name"
                    />
                    <has-error :form="form" field="guard_name"></has-error>
                  </div>
                  <br />
                 
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
  created() {

      this.getEditRole();
  },

  data() {
    return {
      form: new Form({
        name: "",
        guard_name:"",
      }),
     
    };
  },
  methods: {
      
    getEditRole(){
       this.$Progress.start() ;
       axios.get('/api/get/edit/role/item/'+this.$route.params.id)
       .then(resp => {
           this.form.name=resp.data.role.name ;
           this.form.guard_name=resp.data.role.guard_name ;
           this.$Progress.finish();
       })
   },

    updateRole() {
       this.$Progress.start()
      this.form
        .post("/api/edit/role/"+this.$route.params.id, {
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
              this.$router.push({ name : 'role_list'});
          }else{
             this.$Progress.fail()
          }
        });
    },

  },
};
</script>


<style>
</style>