
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