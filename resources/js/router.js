
import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)


import AdminLogin        from "./components/admin/Login" ;

import AdminDashboard    from "./components/admin/Dashboard" ;

import Category          from "./components/admin/category/Index" ;
import AddCategory       from "./components/admin/category/Add" ;
import EditCategory      from "./components/admin/category/Edit" ;

import AdminList         from "./components/admin/admin/Index" ;
import addAdmin          from "./components/admin/admin/Add" ;
import editAdmin         from "./components/admin/admin/Edit" ;
import editAdminPassword from "./components/admin/admin/Password" ;
import adminProfile      from "./components/admin/admin/Profile" ;

import roleList          from "./components/admin/role/Index.vue" ;
import AddRole           from "./components/admin/role/Add.vue" ;
import EditRole          from "./components/admin/role/Edit.vue" ;
import ManageRole        from "./components/admin/role/ManageRole.vue" ;
import AssignRole        from "./components/admin/admin/AssignRole.vue" ;
import AssignPermission  from "./components/admin/admin/AssignPermissions.vue" ;

import permissionList    from "./components/admin/permission/Index.vue" ;
import AddPermission     from "./components/admin/permission/Add.vue" ;
import EditPermission    from "./components/admin/permission/Edit.vue" ;

import courseList        from "./components/admin/course/Index.vue" ;
import AddCourse         from "./components/admin/course/Add.vue" ;
import EditCourse        from "./components/admin/course/Edit.vue" ;


import postList          from "./components/admin/blog_post/Index.vue" ;
import AddPost           from "./components/admin/blog_post/Add.vue" ;
import EditPost          from "./components/admin/blog_post/Edit.vue" ;


import TeamMember        from "./components/admin/team/Index.vue" ;
import AddTeamMember     from "./components/admin/team/Add.vue" ;
import EditTeamMember    from "./components/admin/team/Edit.vue" ;


import sliderList        from "./components/admin/slider/Index.vue" ;
import AddSlider         from "./components/admin/slider/Add.vue" ;
import EditSlider        from "./components/admin/slider/Edit.vue" ;


import CategorySliderList from "./components/admin/category_slider/Index.vue" ;
import AddCategorySlider  from "./components/admin/category_slider/Add.vue" ;
import EditCategorySlider from "./components/admin/category_slider/Edit.vue" ;


import carrierList        from "./components/admin/carrier/Index.vue" ;
import AddCarrier         from "./components/admin/carrier/Add.vue" ;
import EditCarrier        from "./components/admin/carrier/Edit.vue" ;
import ShowCarrier        from "./components/admin/carrier/Show.vue" ;
import ApplicantCarrier   from "./components/admin/carrier/JobApplied.vue" ;



const Foo = { template: '<div>public </div>' }


const routes = [

  
  { path: '/', 
    component: Foo,
    name: 'home'
   },


    { 
    path: '/backend/category/admin/login', 
    component: AdminLogin,
    name : 'admin_login',
    meta: {  title:'Admin Login' } 
    },

    { 
    path: '/backend/admin/add', 
    component: addAdmin,
    name : 'add_admin',
    meta: {  title:'Admin Register',
             authAdmin: true  } 
    },
    
    { 
    path: '/backend/admin/edit/:id', 
    component: editAdmin,
    name : 'edit_admin',
    meta: {  title:'Admin Edit',
             authAdmin: true  } 
    },

     { 
    path: '/backend/admin/password/edit/', 
    component: editAdminPassword,
    name : 'edit_admin_password',
    meta: {  title:'Admin Password Edit',
             authAdmin: true  } 
    },

    
     { 
    path: '/backend/admin/profile', 
    component: adminProfile,
    name : 'admin_profile',
    meta: {  title:'Admin Profile Info',
             authAdmin: true  } 
    },

    { 
    path: '/backend/admin/list', 
    component: AdminList,
    name : 'admin_list',
    meta: {  title:'Admin List',
             authAdmin: true  } 
    },

  { 
    path: '/backend/admin/dashboard', 
    component: AdminDashboard,
    name : 'admin_dashboard',
    meta: {  title:'Admin Dashboard',
             authAdmin: true  } 
   },

    { 
    path: '/backend/category/list', 
    component: Category,
    name : 'category',
    meta: {  title:'category list' ,
             authAdmin: true 
          } 
    },
    
    { 
    path: '/backend/category/add', 
    component: AddCategory,
    name : 'add_category',
    meta: {  title:'category add',
             authAdmin: true ,
          } 
    },
    { 
    path: '/backend/category/edit/:id', 
    component: EditCategory,
    name : 'edit_category',
    meta: {  title:'category edit',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/role/list', 
    component: roleList,
    name : 'role_list',
    meta: {  title:'crole',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/role/add', 
    component: AddRole,
    name : 'add_role',
    meta: {  title:'role add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/role/edit/:id', 
    component: EditRole,
    name : 'edit_role',
    meta: {  title:'role edit',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/manage/role/edit/:id', 
    component: ManageRole,
    name : 'manage_role',
    meta: {  title:'role management',
             authAdmin: true 
           } 
    },

     { 
    path: '/backend/model/assign/role/:id', 
    component: AssignRole,
    name : 'assign_role',
    meta: {  title:'admin giving role ',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/role/assign/permissions/:id', 
    component: AssignPermission,
    name : 'assign_permission',
    meta: {  title:'role giving permission ',
             authAdmin: true 
           } 
    },


   { 
    path: '/backend/permission/list', 
    component: permissionList,
    name : 'permission_list',
    meta: {  title:'permission',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/permission/add', 
    component: AddPermission,
    name : 'add_permission',
    meta: {  title:'permission add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/permission/edit/:id', 
    component: EditPermission,
    name : 'edit_permission',
    meta: {  title:'permission edit',
             authAdmin: true 
           } 
 
    },

    
   { 
    path: '/backend/course/list', 
    component: courseList,
    name : 'course_list',
    meta: {  title:'courses',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/course/add', 
    component: AddCourse,
    name : 'add_course',
    meta: {  title:'course add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/course/edit/:id', 
    component: EditCourse,
    name : 'edit_course',
    meta: {  title:'course edit',
             authAdmin: true 
           } 
    },


      
   { 
    path: '/backend/blog/post/list', 
    component: postList,
    name : 'post_list',
    meta: {  title:'posts',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/blog/post/add', 
    component: AddPost,
    name : 'add_post',
    meta: {  title:'post add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/blog/post/edit/:id', 
    component: EditPost,
    name : 'edit_post',
    meta: {  title:'post edit',
             authAdmin: true 
           } 
    },
  
      
   { 
    path: '/backend/employee/list', 
    component: TeamMember,
    name : 'team_member',
    meta: {  title:'teams',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/employee/add', 
    component: AddTeamMember,
    name : 'add_team_member',
    meta: {  title:'team member add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/employee/edit/:id', 
    component: EditTeamMember,
    name : 'edit_team_member',
    meta: {  title:'team member edit',
             authAdmin: true 
           } 
    },



      { 
    path: '/backend/slider/list', 
    component: sliderList,
    name : 'slider_list',
    meta: {  title:'sliders',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/slider/add', 
    component: AddSlider,
    name : 'add_slider',
    meta: {  title:'slider add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/slider/edit/:id', 
    component: EditSlider,
    name : 'edit_slider',
    meta: {  title:'slider edit',
             authAdmin: true 
           } 
    },



    
      { 
    path: '/backend/for/category/slider/list', 
    component: CategorySliderList,
    name : 'category_slider_list',
    meta: {  title:'category sliders',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/for/category/slider/add', 
    component: AddCategorySlider,
    name : 'add_category_slider',
    meta: {  title:'category slider add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/for/category/slider/edit/:id', 
    component: EditCategorySlider,
    name : 'edit_category_slider',
    meta: {  title:'category slider edit',
             authAdmin: true 
           } 
    },


     { 
    path: '/backend/carrier/post/list', 
    component: carrierList,
    name : 'carrier_list',
    meta: {  title:'carriers',
             authAdmin: true 
           } 
    },

   { 
    path: '/backend/carrier/post/add', 
    component: AddCarrier,
    name : 'add_carrier',
    meta: {  title:'carrier add',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/carrier/post/edit/:id', 
    component: EditCarrier,
    name : 'edit_carrier',
    meta: {  title:'carrier edit',
             authAdmin: true 
           } 
    },
 
    { 
    path: '/backend/carrier/post/show/:id', 
    component: ShowCarrier,
    name : 'show_carrier',
    meta: {  title:'carrier show',
             authAdmin: true 
           } 
    },

    { 
    path: '/backend/applicant/carrier/post/:id', 
    component: ApplicantCarrier,
    name : 'candidate_carrier',
    meta: {  title:'carrier applicant show',
             authAdmin: true 
           } 
    },





    
]

const router = new VueRouter({
  routes,
  mode:'history'
})


router.beforeEach ( (to,from,next) => {

     if (to.matched.some( record => record.meta.authAdmin ) ) {
       if (localStorage.getItem('admin_token')) {
          next()
          return 
       } 
       next('/backend/category/admin/login') ;
     }else{
       next() 
     }
} )

export default router;