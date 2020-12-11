<?php
   if (Session()->has('admin')) {
     $admin= session()->get('admin');
   }
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('backend/dist/img/user2-160x160.jpg ') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Rasel Ahmed</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        @if ($admin->hasPermissionTo('view dashboard'))
            <li class="active treeview"><router-link :to="{ name : 'admin_dashboard'}"> <i class="fa fa-dashboard"></i> Dashboard</router-link></li> 
        @endif
         <li class="treeview">
          <a href="#">
            <i class="fa fa-user-secret"></i> <span>Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><router-link :to=" { name : 'add_admin' }" ><i class="fa fa-plus"></i> Add</router-link></li>
            <li class="active"><router-link :to="{ name : 'admin_list' }"><i class="fa fa-eye"></i>Menage</router-link></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-list-alt" aria-hidden="true"></i> <span>Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><router-link :to=" { name : 'add_category' }" ><i class="fa fa-plus"></i> Add</router-link></li>
            <li class="active"><router-link :to="{ name : 'category' }"><i class="fa fa-eye"></i>Menage</router-link></li>
          </ul>
        </li>


          <li class="treeview">
          <a href="#">
            <i class="fa fa-list-ul" aria-hidden="true"></i> <span>Course</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><router-link :to=" { name : 'add_course' }" ><i class="fa fa-plus"></i> Add</router-link></li>
            <li class="active"><router-link :to="{ name : 'course_list' }"><i class="fa fa-eye"></i>Menage</router-link></li>
          </ul>
         </li>


         <li class="treeview">
          <a href="#">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Blog Posts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><router-link :to=" { name : 'add_post' }" ><i class="fa fa-plus"></i> Add</router-link></li>
            <li class="active"><router-link :to="{ name : 'post_list' }"><i class="fa fa-eye"></i>Menage</router-link></li>
          </ul>
         </li>



         <li class="treeview">
          <a href="#">
            <i class="fa fa-users" aria-hidden="true"></i> <span>Team Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><router-link :to=" { name : 'add_team_member' }" ><i class="fa fa-plus"></i> Add</router-link></li>
            <li class="active"><router-link :to="{ name : 'team_member' }"><i class="fa fa-eye"></i>Menage</router-link></li>
          </ul>
         </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><router-link :to="{ name : 'role_list' }"><i class="fa fa-cog"></i> Role </router-link></li>
            <li class="active"><router-link :to="{ name : 'permission_list' }"><i class="fa fa-check-square-o" aria-hidden="true"></i>Permission </router-link></li>
          </ul>
        </li>



      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
