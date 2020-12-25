<template>
<<<<<<< HEAD
    <div>
 
	<!-- Header section  -->
	<nav class="nav-section">
		<div class="container">
			<div class="nav-right">
				<a href=""><i class="fa fa-search"></i></a>
				<a href=""><i class="fa fa-shopping-cart"></i></a>
			</div>
			<ul class="main-menu">
				<li class="active"><a href="index.html">Home</a></li>
				<li><a href="about.html">About Us</a></li>
				<li><a href="#">Event</a></li>
				<li><a href="course.html">COURSES</a></li>
				<li><a href="blog.html">blog</a></li>
				<li><a href="contact.html">Contact</a></li>
			</ul>
		</div>
	</nav>
	<!-- Header section end -->
    </div>
=======
  <div>

    <!-- Header section  -->
    <nav class="nav-section">
      <div class="container">
        <div class="nav-right">
          <a href=""><i class="fa fa-search"></i></a>
          <a href=""><i class="fa fa-shopping-cart"></i></a>
        </div>
        <ul class="main-menu">
          <li
            v-for="(category, index) in categories"
            :key="index"
           
          >
          <a href=""> {{ category.name }} </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- Header section end -->
  </div>
>>>>>>> e1d2e371f11ec098830befe73e6b82cd3e2a0365
</template>

<script>
export default {
  mounted() {

    this.$store.dispatch("categories");
    
  },

  data() {
    return {};
  },

  methods: {},

  computed: {
    categories() {
    return  this.$store.getters.categories;
    },
  },
};
</script>