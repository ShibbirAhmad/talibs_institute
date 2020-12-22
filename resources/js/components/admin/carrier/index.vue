<template>
  <div>
    <navbar></navbar>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          <router-link :to="{ name: 'add_carrier' }" class="btn btn-primary"
            ><i class="fa fa-plus"></i
          ></router-link>
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li class="active">Carrier</li>
        </ol>
      </section>

      <section class="content">
        <div class="container">
          <div class="row">
            <div style="margin-left:80px;" class="col-lg-12">
              <div class="box box-primary">
                <div class="box-header with-border"></div>
                <div class="row">
                  <div style="margin-left: 10px" class="col-md-2">
                    <select
                      @change="getcarrierList"
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
                </div>
                <div class="box-body">
                  <table class="table text-center">
                    <thead>
                      <tr>
                        <th scope="col">Serial</th>
                        <th scope="col">Title</th>
                        <th scope="col">Applied Total</th>
                        <th scope="col">Vacency</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <h1 class="text-center" v-if="loading">
                        <i class="fa fa-spin fa-spinner"></i>
                      </h1>
                      <tr
                        v-for="(carrier, index) in carrierList.data"
                        :key="index"
                      >
                        <td>{{ index+1 }}</td>
                        <td> <router-link :to="{ name: 'candidate_carrier', params:{ id : carrier.id } }"> {{ carrier.title }} </router-link> </td>
                        <td> <span class="badge badge-success"> {{ carrier.applied_user.length }}  </span> </td>
                        <td>{{ carrier.vacency }}</td>
                        <td>{{ carrier.deadline }}</td>
                        <td>
                          <img
                            v-if="carrier.image"
                            :src="base_url + carrier.image"
                            style="width: 40px; height: 40px"
                          />
                          <img
                            v-else
                            :src="base_url + 'images/no_image.jpg'"
                            style="width: 40px; height: 40px"
                          />
                        </td>

                        <td>
                          <span
                            v-if="carrier.status == 1"
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
                              name: 'show_carrier',
                              params: { id: carrier.id },
                            }"
                            class="btn btn-sm btn-primary"
                          >
                            <i class="fa fa-eye"></i>
                          </router-link>

                          <router-link
                            :to="{
                              name: 'edit_carrier',
                              params: { id: carrier.id },
                            }"
                            class="btn btn-sm btn-success"
                          >
                            <i class="fa fa-edit"></i>
                          </router-link>

                          <button
                            v-if="carrier.status == 1"
                            class="btn btn-sm btn-warning"
                          >
                            <i class="fa fa-ban" @click="deActive(carrier)">
                            </i>
                          </button>
                          <button
                            v-else
                            @click="active(carrier)"
                            class="btn btn-sm btn-success"
                          >
                            <i class="fa fa-check"> </i>
                          </button>

                          <a
                            @click="trash_carrier(carrier.id, index)"
                            class="btn btn-sm btn-danger"
                          >
                            <i class="fa fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="row">
                    <div class="col-md-6">
                      <pagination
                        :data="carrierList"
                        @pagination-change-page="getcarrierList"
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
                        showing <strong>{{ carrierList.from }} </strong> to
                        <strong>{{ carrierList.from }} </strong> of total
                        entities {{ carrierList.total }}
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
    console.log("mounted carrier");
    setTimeout(() => {
      this.loading = false;
    }, 500);
    this.getcarrierList();
  },

  data() {
    return {
      carrierList: {},
      loading: true,
      item: 10,
      base_url: this.$store.state.storage,
    };
  },

  methods: {
    deActive(carrier) {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want de-active this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/carrier/deactive/" + carrier.id)
            .then((resp) => {
              if (resp.data.success == "OK") {
                this.getcarrierList();
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
    active(carrier) {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want active this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
      }).then((result) => {
        if (result.value) {
          axios
            .get("/api/carrier/active/" + carrier.id)
            .then((resp) => {
              if (resp.data.success == "OK") {
                this.getcarrierList();
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

    getcarrierList(page = 1) {
      axios
        .get("/api/carrier/list?page=" + page, {
          params: { item: this.item },
        })
        .then((resp) => {
          console.log(resp);
          if (resp.data.success == "OK") {
            this.carrierList = resp.data.carriers;
          }
        })
        .catch();
    },

    trash_carrier(carrier_id, index) {
      if (confirm("Are you sure to remove")) {
        axios
          .get("/api/carrier/trash/" + carrier_id)
          .then((resp) => {
            console.log(resp);
            if (resp.data.success == "OK") {
              alert(resp.data.message);
              this.carrierList.data.splice(index, 1);
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
