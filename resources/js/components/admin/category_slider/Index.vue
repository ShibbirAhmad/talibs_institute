 <template>
    <div>
        <admin-main></admin-main>
        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <router-link :to="{name:'add_category_slider'}" class="btn btn-primary"><i class="fa fa-plus"></i></router-link>

                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                    <li class="active">Category Slider</li>
                </ol>
            </section>
            <section class="content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div style="margin-left:290px;" class="col-lg-8 col-lg-offset-1">
                            <div class="box box-primary">
                                <div class="box-header with-border text-center">
                                 <h3 class="box-title"> Category Slider table</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Position</th>
                                            <th scope="col">status</th>
                                            <th scope="col">action</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        <h1 v-if="loading"><i class="fa fa-spin fa-spinner"></i></h1>
                                        <tr v-for="(slider,index) in sliders.data" :key="index" v-else>
                                            <td scope="row">{{index+1}}</td>
                                            <td>
                                                <div v-if="slider.image.length">
                                                   <img :src="'/../storage/'+slider.image"
                                                     style="width: 100px;" alt="slider Image">     
                                                </div>
                                                <div v-else> 
                                                    <img :src="basePath+slider.image"
                                                     style="width: 100px;" alt="slider Image"> 
                                                 </div>
                                       
                                            </td>
                                             <td>
                                                 <span v-if="slider.page_position == 1" class="bage"> Category  </span>
                                                 <span v-else class="bage"> SubCategory  </span>
                                             </td>
                                            <td>
                                                <span v-if="slider.status==1" class="badge">Active</span>
                                                <span v-else class="badge">De-active</span>
                                            </td>
                                            <td>
                                                <router-link class="btn btn-success" :to="{ name : 'category_slider_edit', params :{ id : slider.id }}"> <i class="fa fa-edit"> </i></router-link>
                                                <a class="btn btn-danger" @click="destroy(slider)"><i class="fa fa-trash"></i></a>

                                                <a class="btn btn-warning" title="De-active" @click="deActive(slider)"
                                                   v-if="slider.status==1"><i class="fa fa-ban"></i></a>
                                                <a class="btn btn-primary" title="active" @click="active(slider)"
                                                   v-else><i
                                                    class="fa fa-check"></i></a>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <pagination :data="sliders"
                                                        @pagination-change-page="getSlider">

                                            </pagination>

                                        </div>
                                        <div class="col-lg-6 mt-1" style="margin-top: 25px;text-align:right;">
                                            <p>Showing <strong>{{sliders.from}}</strong> to
                                                <strong>{{sliders.to}}</strong> of total
                                                <strong>{{sliders.total}}</strong> entries
                                            </p>
                                        </div>
                                    </div>

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

            setTimeout(() => {
                this.getSlider();
            }, 500)
        },
        data() {
            return {
                sliders: {},
                loading: true,
                search: '',
                basePath:this.$store.state.image_base_link,
            }
        },
        methods: {

            getSlider(page = 1) {
                axios.get('/api/category/list/slider?page=', + page )
                    .then((resp) => {
                        console.log(resp);
                        if (resp.data.status == 'SUCCESS') {
                            this.sliders = resp.data.sliders;
                            this.loading = false
                        } else {
                            this.$toasted.show('some thing went wrong', {
                                type: "error",
                                position: 'top-center',
                                duration: 5000
                            });
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                        this.$toasted.show('some thing want to wrong', {
                            type: "error",
                            position: 'top-center',
                            duration: 4000
                        });
                    })
            },

            active(slider) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't active this!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {

                        axios.get('/api/category/active/slider/' + slider.id)
                            .then((resp) => {
                                if (resp.data.status == 'SUCCESS') {
                                    this.getSlider();
                                    this.$toasted.show(resp.data.message, {
                                        position: 'top-center',
                                        type: 'success',
                                        duration: 4000
                                    });
                                } else {
                                    this.$toasted.show('some thing want to wrong', {
                                        position: 'top-center',
                                        type: 'error',
                                        duration: 4000
                                    });
                                }

                            })
                            .catch((error) => {
                                this.$toasted.show('some thing want to wrong', {
                                    position: 'top-center',
                                    type: 'error',
                                    duration: 4000
                                });
                            })


                    } else {
                        this.$toasted.show('Ok ! no action here', {
                            position: 'top-center',
                            type: 'info',
                            duration: 3000
                        });
                    }
                })
            },
            deActive(slider) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't de-active this!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {

                        axios.get('/api/category/deActive/slider/' + slider.id)
                            .then((resp) => {
                                if (resp.data.status == 'SUCCESS') {
                                    this.getSlider();
                                    this.$toasted.show(resp.data.message, {
                                        position: 'top-center',
                                        type: 'success',
                                        duration: 4000
                                    });
                                } else {
                                    this.$toasted.show('some thing want to wrong', {
                                        position: 'top-center',
                                        type: 'error',
                                        duration: 4000
                                    });
                                }

                            })
                            .catch((error) => {
                                this.$toasted.show('some thing want to wrong', {
                                    position: 'top-center',
                                    type: 'error',
                                    duration: 4000
                                });
                            })


                    } else {
                        this.$toasted.show('Ok ! no action here', {
                            position: 'top-center',
                            type: 'info',
                            duration: 3000
                        });
                    }
                })
            },
            destroy(slider) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't delete this slider!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {

                        axios.get('/api/category/delete/slider/' + slider.id)
                            .then((resp) => {
                                //console.log(resp)
                                if (resp.data.status == 'SUCCESS') {
                                    this.getSlider();
                                    this.$toasted.show(resp.data.message, {
                                        position: 'top-center',
                                        type: 'success',
                                        duration: 4000
                                    });
                                } else {
                                    this.$toasted.show('some thing want to wrong', {
                                        position: 'top-center',
                                        type: 'error',
                                        duration: 4000
                                    });
                                }

                            })
                            .catch((error) => {
                                console.log(error)
                                this.$toasted.show('some thing want to wrong', {
                                    position: 'top-center',
                                    type: 'error',
                                    duration: 4000
                                });
                            })


                    } else {
                        this.$toasted.show('Ok ! no action here', {
                            position: 'top-center',
                            type: 'info',
                            duration: 3000
                        });
                    }
                })
            },
            

        }
    }

</script>

<style >

</style>
