<template>
  <div>
    <navbar></navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Applied appliers of jobs</li>
        </ol>
      </section>

      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-11">
              <div class="job_heading  divShadow text-center">
                <h4 class="heading">{{ jobTitle }}</h4>
              </div>
            </div>
          </div>

          <div class="row applier" v-for="(applier, index) in appliers.data" v-bind:key="index">
            <div>
              <div class="col-md-4">
                <div class="job-content bg-white text-center divShadow">
                  <h4 style="margin-top: 10px; margin-bottom: 15px">
                    {{ applier.name }}
                  </h4>
                  <p>
                    {{ applier.phone }}
                  </p>
                  <p>
                    {{ applier.email }}
                  </p>

                  <button
                    download
                    @click="downloadCV(applier.id)"
                    class="btn btn-lg btnCV"
                  >
                    <i style="font-size: 54px" class="fa fa-lg fa-file"></i>
                  </button>
                </div>
              </div>

              <div class="col-md-7">
                      <div class="job-content bg-white divShadow">
                   <p style="line-height:25px;" v-html="applier.message" >  </p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>


<script>
export default {
  created() {
    this.getApplierList();
  },

  data() {
    return {
      jobTitle: "",
      appliers: "",
      coverLetter: "",
    };
  },
  methods: {
    getApplierList() {
      axios
        .get("/api/applied/applier/job/" + this.$route.params.id)
        .then((resp) => {
          console.log(resp);
          if (resp.data.status == "OK") {
            this.appliers = resp.data.appliers;
            this.jobTitle = resp.data.appliers.data[0].job.title;
          }
        });
    },

    downloadCV(applier_id) {
      window.open("/api/download/user/resume/" + applier_id);
    },
  },
};
</script>

<style>
.job_heading {
  min-height: 60px;
  margin-top: 20px;
  margin-bottom: 30px;
}

.job_heading h4 {
  padding-top: 20px;
}

.divShadow {
  box-shadow: 2px 1px 3px #3c8dbc;
  margin-bottom: 30px;
}

.divShadow p {
  line-height: 15px;
}

.btnCV {
  background: #3c8dbc;
  color: #fff;
  width: 76px;
  height: 76px;
  margin-top: 10px;
  border-radius: 5px;
  border: dashed 2px;
}
.bg-white{
  background: #fff;
}
</style>