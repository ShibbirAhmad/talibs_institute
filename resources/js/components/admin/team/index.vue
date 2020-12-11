<template>
  <div>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'add_team_member' }" class="btn btn-primary"
            ><i class="fa fa-plus"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Team</li>
        </ol>
      </section>

      <section class="content">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border"></div>

                <div class="box-body">
                  <div style="margin-bottom:20px;" class="row">
                    <div class="col-md-2">
                      <select
                        @change="getmemberList"
                        v-model="item"
                        class="form-control"
                        id=""
                      >
                        <option selected value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                      </select>
                    </div>
                    <div class="col-md-5"></div>
                    <div class="col-md-5">
                      <input
                        type="text"
                        v-model="search_data"
                        class="form-control"
                        placeholder="search member name,phone or email "
                        @keyup="searchMember"
                      />
                    </div>
                  </div>
                  <table class="table text-center">
                    <thead>
                      <tr>
                        <th scope="col">Serial</th>
                        <th scope="col">Name</th>
                        <th scope="col">Designation</th>
                        <th scope="col">phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Image</th>
                        <th scope="col">CV/Resume</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <h1 class="text-center" v-if="loading">
                        <i class="fa fa-spin fa-spinner"></i>
                      </h1>
                      <tr
                        v-for="(member, index) in memberList.data"
                        :key="index"
                      >
                        <td>{{ index + 1 }}</td>
                        <td>
                      
                            {{ member.name }}
                        
                        </td>
                        <td>{{ member.designation }}</td>
                     
                        <td>{{ member.phone }}</td>

                         <td>{{ member.email }}</td>
                        <td>
                          <img
                            :src="member.avator ? basePath+member.avator : basePath+'images/no_image.jpg'"
                             class="small-image" 
                          />
                        </td>
                        <td>
                          <a
                            class="btn btn-success"
                            :href="basePath + member.resume"
                            download
                          >
                            <i class="fa fa-lg fa-download"></i>
                          </a>
                        </td>
                        <td>
                          <span
                            v-if="member.status == 1"
                            class="badge btn-success"
                            >Active</span
                          >
                          <span v-else class="badge btn-warning"
                            >De-Active</span
                          >
                        </td>
                        <td>
                          <router-link
                            :to="{
                              name: 'edit_team_member',
                              params: { id: member.id },
                            }"
                            class="btn btn-sm btn-success"
                          >
                            <i class="fa fa-edit"></i>
                          </router-link>

                          <button
                            v-if="member.status == 1"
                            class="btn btn-sm btn-warning"
                          >
                            <i class="fa fa-ban" @click="deActive(member)"> </i>
                          </button>
                          <button v-else class="btn btn-sm btn-success">
                            <i class="fa fa-check" @click="active(member)"> </i>
                          </button>

                          <a class="btn btn-sm btn-danger">
                            <i
                              @click="trash_member(member.id, index)"
                              class="fa fa-trash"
                            ></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="row">
                    <div class="col-md-6">
                      <pagination
                        :data="memberList"
                        @pagination-change-page="getmemberList"
                      >
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                      </pagination>
                    </div>
                    <div
                      class="col-md-6"
                      style="margin-top: 25px; text-align: right"
                    >
                      <p>
                        showing <strong>{{ memberList.from }} </strong> to
                        <strong>{{ memberList.from }} </strong> of total
                        entities {{ memberList.total }}
                      </p>
                    </div>
                  </div>
                </div>
                <div class="box-footer"></div>
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
  mounted() {
    console.log("mounted member");
    setTimeout(() => {
      this.loading = false;
    }, 500);
    this.getmemberList();
  },

  data() {
    return {
      memberList: {},
      loading: true,
      item: 10,
      basePath: this.$store.state.storage,
      search_data: "",
    };
  },

  methods: {
    searchMember() {
      if (this.search_data.length >= 3) {
        axios
          .get("/api/team/members/search/" + this.search_data)
          .then((resp) => {
            this.memberList = resp.data.members;
          });
      } else {
        this.getmemberList();
      }
    },

    deActive(member) {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want de-active this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/team/members/deactive/" + member.id)
            .then((resp) => {
              if (resp.data.success == "OK") {
                this.getmemberList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("some thing want to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              this.$toasted.show("some thing want to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("OK ! no action here", {
            position: "top-center",
            type: "info",
            duration: 3000,
          });
        }
      });
    },
    active(member) {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want active this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/team/members/active/" + member.id)
            .then((resp) => {
              if (resp.data.success == "OK") {
                this.getmemberList();
                this.$toasted.show(resp.data.message, {
                  position: "top-center",
                  type: "success",
                  duration: 4000,
                });
              } else {
                this.$toasted.show("some thing want to wrong", {
                  position: "top-center",
                  type: "error",
                  duration: 4000,
                });
              }
            })
            .catch((error) => {
              this.$toasted.show("some thing want to wrong", {
                position: "top-center",
                type: "error",
                duration: 4000,
              });
            });
        } else {
          this.$toasted.show("Ok ! no action here", {
            position: "top-center",
            type: "info",
            duration: 3000,
          });
        }
      });
    },

    getmemberList(page = 1) {
      axios
        .get("/api/team/members/list?page=" + page, {
          params: { item: this.item },
        })
        .then((resp) => {
          console.log(resp);
          if (resp.data.success == "OK") {
            this.memberList = resp.data.members;
          }
        })
        .catch();
    },

    trash_member(member_id, index) {
      if (confirm("Are you sure to remove")) {
        axios
          .get("/api/team/members/trash/" + member_id)
          .then((resp) => {
            console.log(resp);
            if (resp.data.success == "OK") {
              alert(resp.data.message);
              this.memberList.data.splice(index, 1);
            }
          })
          .catch();
      }
    },
  },
};
</script>



<style scoped>
.dropbtn {
  width: 100% !important;
  margin-bottom: 5px !important;
}
.dropbtn-active {
  display: block !important;
}
.dropdown-action {
  display: none;
  width: 90px;
  position: absolute;
}
</style>
