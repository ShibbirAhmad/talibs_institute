<template>
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