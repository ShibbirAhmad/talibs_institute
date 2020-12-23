<template>
  <div>
    <div class="content-wrapper">

        <div class="row">
           <div class="col-md-4 col-lg-4"></div>
           <div class="col-md-4 col-lg-4">
              <div class="form_container">
                 <div style="margin:10px;" > 
                   <div style="padding-top:10px;" class="text-center">
                     <h5  class="heading"> Login to start your session </h5>
                   </div>
                   <form
                  @submit.prevent="adminLogin"
                >
                  <div class="form-group">
                    <label> Email </label>
                    <input
                      v-model="form.email"
                      :class="{ 'is-invalid': form.errors.has('email') }"
                      class="form-control"
                      type="text"
                      email="email"
                    />
                    <has-error :form="form" field="email"></has-error>
                  </div>
    
                  <div class="form-group">
                    <label> Password </label>
                    <input
                      v-model="form.password"
                      :class="{ 'is-invalid': form.errors.has('password') }"
                      class="form-control"
                      type="password"
                      email="password"
                    />
                    <has-error :form="form" field="password"></has-error>
                  </div>
           
                 <div  class="text-center form-group">
                  <button style="margin-bottom:10px;"
                    :disabled="form.busy"
                    class="btn btn-lg btn-info"
                    type="submit"
                  >
                    <i class="fa fa-spiner"></i> <i class="fa fa-cogs"></i> Login
                  </button>
                 </div>
                 
                </form>
               </div>
             </div>
           </div>
           <div class="col-md-4 col-lg-4"></div>
          </div>      
     
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
     let body= document.getElementsByTagName('body')[0];
     body.classList.remove('skin-blue');
     body.style.backgroundColor='#ecf0f5'
     console.log(body)
     console.log('created')
  },

  data() {
    return {
      form: new Form({
        email: "",
        password: "",
      }),
    };
  },
  methods: {
    adminLogin() {
       this.$Progress.start()
      this.form
        .post("/api/backend/category/admin/login", {
          // Transform form data to FormData
          transformRequest: [
            function (data, headers) {
              return objectToFormData(data);
            },
          ],
        })
        .then((resp) => {
          console.log(resp);
          if (resp.data.status == "SUCCESS") {
              this.$Progress.finish()
              this.$toasted.show(resp.data.message,{
                type:'success',
                position:'top-center',
                duration:3000,
              });
              localStorage.setItem("admin_token", resp.data.token);
              this.$store.commit("admin", resp.data.admin);
              this.$router.push({ name : 'admin_dashboard'});
              location.reload();
          }else{
              this.$toasted.show(resp.data.message,{
              type:'error',
              position:'top-center',
              duration:3000,
              });
             this.$Progress.fail() ;
          }
        });
    },

  },
};


 window.addEventListener('DOMContentLoaded', (event) => {
    
     $('#navBar').hide();
    
      document.getElementsByTagName('body')[0].background="#ddd";

});

</script>



<style scoped >

.form_container {

     margin-top:80px;
     background:#eee ;
     box-shadow: 1px 2px 1px #ddd;
}

</style>