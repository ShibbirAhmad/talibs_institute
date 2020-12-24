<template>
  <div>
    <header-section></header-section>
    <!-- Hero section -->
    <section class="hero-section">
	<div class="row">
	  <div class="col-lg-8 col-md-8 col-sm-8">
		  <div class="slider_container">
           <carousel
              v-if="landing_sliders"
              :items="1"
              :nav="false"
              :autoplay="true"
              :autoplayTimeout="2000"
            >
              <a v-for="slider in landing_sliders" :href="slider.url" :key="slider.id">
                <img :src="slider.image? base_url + slider.image : base_url+'images/no_image.jpg'" />
              </a>
            </carousel>
		  </div>
	  </div>
	  <div class="col-lg-4 col-md-4 col-sm-12">
		    <div class="baner_container">
				<img :src="base_url+'images/no_image.jpg'" >
			</div>
	   </div>	
	</div>
 
    </section>
    <!-- Hero section end -->

    <!-- Counter section  -->
    <section class="counter-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-6">
            <div class="big-icon">
              <i class="fa fa-graduation-cap"></i>
            </div>
            <div class="counter-content">
              <h2>NEXT COUSRE: Sales & Marketing Alignment</h2>
              <p><i class="fa fa-calendar-o"></i>07:00 PM - 09:00 PM</p>
            </div>
          </div>
          <div class="col-lg-5 col-md-6">
            <div class="counter">
              <div class="counter-item">
                <h4>20</h4>
                Days
              </div>
              <div class="counter-item">
                <h4>08</h4>
                Hrs
              </div>
              <div class="counter-item">
                <h4>40</h4>
                Mins
              </div>
              <div class="counter-item">
                <h4>56</h4>
                secs
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Counter section end -->

    <!-- Services section -->
    <section class="service-section spad">
      <div class="container services">
        <div class="section-title text-center">
          <h3>OUR SERVICES</h3>
          <p>We provides the opportunity to prepare for life</p>
        </div>
        <div class="row">
          <div class="col-lg-4 col-sm-6 service-item">
            <div class="service-icon">
              <img src="img/services-icons/1.png" alt="1" />
            </div>
            <div class="service-content">
              <h4>Art Studio</h4>
              <p>
                Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                Vivamus interdum ultrices augue. Aenean dos cursus lania.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 service-item">
            <div class="service-icon">
              <img src="img/services-icons/2.png" alt="1" />
            </div>
            <div class="service-content">
              <h4>Great Facility</h4>
              <p>
                Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                Vivamus interdum ultrices augue. Aenean dos cursus lania.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 service-item">
            <div class="service-icon">
              <img src="img/services-icons/3.png" alt="1" />
            </div>
            <div class="service-content">
              <h4>Activity Hub</h4>
              <p>
                Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                Vivamus interdum ultrices augue. Aenean dos cursus lania.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 service-item">
            <div class="service-icon">
              <img src="img/services-icons/4.png" alt="1" />
            </div>
            <div class="service-content">
              <h4>Fully Qualified</h4>
              <p>
                Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                Vivamus interdum ultrices augue. Aenean dos cursus lania.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 service-item">
            <div class="service-icon">
              <img src="img/services-icons/5.png" alt="1" />
            </div>
            <div class="service-content">
              <h4>Flexible Schedule</h4>
              <p>
                Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                Vivamus interdum ultrices augue. Aenean dos cursus lania.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6 service-item">
            <div class="service-icon">
              <img src="img/services-icons/6.png" alt="1" />
            </div>
            <div class="service-content">
              <h4>Chemistry Lab</h4>
              <p>
                Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                Vivamus interdum ultrices augue. Aenean dos cursus lania.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Services section end -->

    <!-- Enroll section -->
    <section class="enroll-section spad set-bg" data-setbg="img/enroll-bg.jpg">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <div class="section-title text-white">
              <h3>ENROLLMENT</h3>
              <p>Get started with us to explore the exciting</p>
            </div>
            <div class="enroll-list text-white">
              <div class="enroll-list-item">
                <span>1</span>
                <h5>Contact</h5>
                <p>
                  Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                  Vivamus interdum ultrices augue.
                </p>
              </div>
              <div class="enroll-list-item">
                <span>2</span>
                <h5>Consulting</h5>
                <p>
                  Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                  Vivamus interdum ultrices augue.
                </p>
              </div>
              <div class="enroll-list-item">
                <span>3</span>
                <h5>Register</h5>
                <p>
                  Lorem ipsum dolor sitdo amet, consectetur dont adipis elit.
                  Vivamus interdum ultrices augue.
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 offset-lg-1 p-lg-0 p-4">
            <img src="img/encroll-img.jpg" alt="" />
          </div>
        </div>
      </div>
    </section>
    <!-- Enroll section end -->

    <!-- Courses section -->
    <section class="courses-section spad">
      <div class="container">
        <div class="section-title text-center">
          <h3>OUR COURSES</h3>
          <p>Building a better world, one course at a time</p>
        </div>
        <div class="row">
          <!-- course item -->
          <div
            v-for="(course, index) in courses"
            :key="index"
            class="col-lg-4 col-md-6 course-item"
          >
            <div class="course-thumb">
              <img
                :src="
                  course.image
                    ? base_url + course.image
                    : base_url + 'images/no_image.jpg'
                "
                alt=""
              />
              <div class="course-cat">
                <span>{{ course.category_name.name }}</span>
              </div>
            </div>
            <div class="course-info">
              <div class="date">
                <i class="fa fa-clock-o"></i>
                {{ courseTimeFormater(course.start_date) }}
              </div>
              <h4>{{ course.name }}</h4>
              <h4 class="cource-price">{{ course.duration }}</h4>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Courses section end-->

    <!-- Fact section -->
    <section class="fact-section spad set-bg" data-setbg="img/fact-bg.jpg">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-lg-3 fact">
            <div class="fact-icon">
              <i class="ti-crown"></i>
            </div>
            <div class="fact-text">
              <h2>50</h2>
              <p>YEARS</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 fact">
            <div class="fact-icon">
              <i class="ti-briefcase"></i>
            </div>
            <div class="fact-text">
              <h2>80</h2>
              <p>TEACHERS</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 fact">
            <div class="fact-icon">
              <i class="ti-user"></i>
            </div>
            <div class="fact-text">
              <h2>500</h2>
              <p>STUDENTS</p>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3 fact">
            <div class="fact-icon">
              <i class="ti-pencil-alt"></i>
            </div>
            <div class="fact-text">
              <h2>800+</h2>
              <p>LESSONS</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Fact section end-->

    <!-- Event section -->
    <section class="event-section spad">
      <div class="container">
        <div class="section-title text-center">
          <h3>OUR EVENTS</h3>
          <p>Our department initiated a series of events</p>
        </div>
        <div class="row">
          <div class="col-md-6 event-item">
            <div class="event-thumb">
              <img src="img/event/1.jpg" alt="" />
              <div class="event-date">
                <span>24 Mar 2018</span>
              </div>
            </div>
            <div class="event-info">
              <h4>
                The dos and don'ts of writing a personal<br />statement for
                languages
              </h4>
              <p>
                <i class="fa fa-calendar-o"></i> 08:00 AM - 10:00 AM
                <i class="fa fa-map-marker"></i> Center Building, Block A
              </p>
              <a href="" class="event-readmore"
                >REGISTER <i class="fa fa-angle-double-right"></i
              ></a>
            </div>
          </div>
          <div class="col-md-6 event-item">
            <div class="event-thumb">
              <img src="img/event/2.jpg" alt="" />
              <div class="event-date">
                <span>22 Mar 2018</span>
              </div>
            </div>
            <div class="event-info">
              <h4>
                University interview tips:<br />confidence won't make up for
                flannel
              </h4>
              <p>
                <i class="fa fa-calendar-o"></i> 08:00 AM - 10:00 AM
                <i class="fa fa-map-marker"></i> Center Building, Block A
              </p>
              <a href="" class="event-readmore"
                >REGISTER <i class="fa fa-angle-double-right"></i
              ></a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Event section end -->

    <!-- Gallery section -->
    <div class="gallery-section">
      <div class="gallery">
        <div class="grid-sizer"></div>
        <div class="gallery-item gi-big set-bg" data-setbg="img/gallery/1.jpg">
          <a class="img-popup" href="img/gallery/1.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
        <div class="gallery-item set-bg" data-setbg="img/gallery/2.jpg">
          <a class="img-popup" href="img/gallery/2.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
        <div class="gallery-item set-bg" data-setbg="img/gallery/3.jpg">
          <a class="img-popup" href="img/gallery/3.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
        <div class="gallery-item gi-long set-bg" data-setbg="img/gallery/5.jpg">
          <a class="img-popup" href="img/gallery/5.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
        <div class="gallery-item gi-big set-bg" data-setbg="img/gallery/8.jpg">
          <a class="img-popup" href="img/gallery/8.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
        <div class="gallery-item gi-long set-bg" data-setbg="img/gallery/4.jpg">
          <a class="img-popup" href="img/gallery/4.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
        <div class="gallery-item set-bg" data-setbg="img/gallery/6.jpg">
          <a class="img-popup" href="img/gallery/6.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
        <div class="gallery-item set-bg" data-setbg="img/gallery/7.jpg">
          <a class="img-popup" href="img/gallery/7.jpg"
            ><i class="ti-plus"></i
          ></a>
        </div>
      </div>
    </div>
    <!-- Gallery section -->

    <!-- Blog section -->
    <section class="blog-section spad">
      <div class="container">
        <div class="section-title text-center">
          <h3>LATEST NEWS</h3>
          <p>Get latest breaking news & top stories today</p>
        </div>
        <div class="row">
          <div v-for="(post, index) in blogPosts" :key="index" class="col-xl-6">
            <div class="blog-item">
              <div class="blog-thumb set-bg" data-setbg="img/blog/1.jpg"></div>
              <div class="blog-content">
                <h4>{{ post.title }}</h4>
                <div class="blog-meta">
                  <span
                    ><i class="fa fa-calendar-o"></i>
                    {{ postTimeFormater(post.created_at) }}
                  </span>
                  <span
                    ><i class="fa fa-user"></i> {{ post.admin_name.name }}
                  </span>
                </div>
                <p v-html="post.description.substr(1, 200)"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog section -->

    <!-- Newsletter section -->
    <section class="newsletter-section">
      <div class="container">
        <div class="row">
          <div class="col-md-5 col-lg-7">
            <div class="section-title mb-md-0">
              <h3>NEWSLETTER</h3>
              <p>
                Subscribe and get the latest news and useful tips, advice and
                best offer.
              </p>
            </div>
          </div>
          <div class="col-md-7 col-lg-5">
            <form class="newsletter">
              <input type="text" placeholder="Enter your email" />
              <button class="site-btn">SUBSCRIBE</button>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- Newsletter section end -->

    <footer-section> </footer-section>
  </div>
</template>

<script>

import carousel from "vue-owl-carousel";
export default {
 
  created() {
    this.getCourseList();
    this.getPostList();
    this.$store.dispatch("landing_sliders");
  },

  data() {
    return {
      courses: "",
      blogPosts: "",
	  base_url: this.$store.state.storage,
	  
    };
  },

  methods: {
    getCourseList() {
      axios.get("/api/display/course/public").then((resp) => {
        console.log(resp);
        if (resp.data.status == "OK") {
          this.courses = resp.data.courses;
        }
      });
    },

    getPostList() {
      axios.get("/api/blog/post/public").then((resp) => {
        console.log(resp);
        if (resp.data.status == "OK") {
          this.blogPosts = resp.data.blog_posts;
        }
      });
    },

    courseTimeFormater(start_date) {
      let dayMonthYear = new Date(start_date);
      var days = dayMonthYear.getDay();
      var months = dayMonthYear.getMonth();
      var years = dayMonthYear.getFullYear();

      const dm = new Date(years, months, days);
      const yea = new Intl.DateTimeFormat("en", { year: "numeric" }).format(dm);
      const mon = new Intl.DateTimeFormat("en", { month: "short" }).format(dm);
      const dy = new Intl.DateTimeFormat("en", { day: "2-digit" }).format(dm);
      let c_date = `${dy}-${mon}-${yea}`;
      return c_date;
    },

    postTimeFormater(created_at) {
      let dmy = new Date(created_at);
      var day = dmy.getDay();
      var month = dmy.getMonth();
      var year = dmy.getFullYear();

      const d = new Date(year, month, day);
      const ye = new Intl.DateTimeFormat("en", { year: "numeric" }).format(d);
      const mo = new Intl.DateTimeFormat("en", { month: "short" }).format(d);
      const da = new Intl.DateTimeFormat("en", { day: "2-digit" }).format(d);
      let r_date = `${da}-${mo}-${ye}`;
      return r_date;
    },
  },

  computed: {
    landing_sliders() {
      return this.$store.getters.landing_sliders;
    },
  },

  components: { 

	    carousel ,

	  },


};
</script>


<style scoped>
h4 {
  font-size: 16px;
}

.slider_container{

	 margin: 10px;
	 box-shadow: 1px 2px 1px #ddd;
}

.baner_container{

	 margin: 10px;
	 box-shadow: 1px 2px 1px #ddd;
}

</style>