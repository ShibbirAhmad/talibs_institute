import Vue from 'vue'
import Vuex from 'vuex'
import router from './router.js'
Vue.use(Vuex)

const store = new Vuex.Store({


  state: {

    storage:'/../storage/' ,

    //store admin
    admin: {},



  },


  actions:{

       //session check
    //every time this session check, for admin session running or expired
    admin(context) {
        axios
            .get("/api/check/session/admin")

            //if session status ruuning
            .then((resp) => {
                if (resp.data.status == "RUNNING") {
                    context.commit('admin', resp.data.admin)

                }

                //if session is expired, admin redirect ot login again
                if (resp.data.status == "EXPIRED") {

                    localStorage.removeItem("admin_token");
                    router.push({ name: "adminLogin" });
                    return;
                }
            })
            //error handaling
            .catch(() => {
                router.push({ name: "adminLogin" });
            });
    },
  },


  mutations: {
      
       admin(state, payload){
         return state.admin= payload ;
       }
  },

  getters:{
       admin(state){
         return state.admin ;
       }
  },

 


})
global.store = store;
export default store ;