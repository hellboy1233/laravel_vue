<script setup>
import axios from 'axios'
import { onMounted,ref,reactive, toDisplayString, } from 'vue';
import jquery from 'jquery'
import { Form ,Field } from 'vee-validate';
// import { Schema } from 'yup';
import * as yup from 'yup';
import toastr from '../../toastr.js'

window.$=window.jquery=jquery;
    const users=ref([]);
    const editing=ref(false);

    // const addnewusers=reactive({
                
    //             name:'',
    //             email:'',
    //             password:''
    //         });

    const createschema = yup.object({
        name:yup.string().required(),
        email:yup.string().email().required(),
        password:yup.string().required().min(8)
    })
    const editschema = yup.object({
        name:yup.string().required(),
        email:yup.string().email().required(),
        password:yup.string().when((password,schema)=>{
            return password?schema.required().min(8):schema;
        })
    })
    const getusers=()=>{
        axios.get('/api/users')
        .then((response)=>{
            users.value=response.data;
        })
        .catch((error)=>{
            console.log(error)
        })
    };
    
    const submitform=(values)=>{
        console.log(values);
            if(editing.value==true){
                axios.put('/api/users/update',values)
                .then((res=>{
                    $('#exampleModal').modal('hide')
                    users.value.push(res.data)
                    console.log(res.data)
                    toastr.success('user updated successfully')
                }))
            }else{
                axios.post('/api/users/add',values)
                .then((res=>{
                    console.log(res.data)
                    
                    users.value.push(res.data)
                    
                    //.unshift.push
                    $('#exampleModal').modal('hide')
                    toastr.success('user added successfully')
                    
                }))
            }
            
            
            
    };
    const deleteuser = (id)=>{
        axios.get(`/api/users/delete/${id}`)
        .then((res)=>{console.log(res)})
        toastr.success('user deleted successfully')
    }
    
    const formvalues=ref()
    const adduser=()=>{
      
        editing.value=(false)
    }
    
    const edituser=(item )=>{
        editing.value=true;
        
        formvalues.value={ 
            id:item.id,
            name:item.name,
            email:item.email
        }
        
        // console.log(id)
        // axios.post(`/api/users/edit/${id }`)
            //  .then((res=>{
            //     console.log(res.data)
            //     formvalues.value=res.data
            //     console.log(formvalues.value)
                // users.value.push(res.data) 
                // //.unshift.push
                // $('#exampleModal').modal('hide')
                  
                
            // }))
    }
    

    onMounted(()=>{
        getusers()
        toastr.options = {
        closeButton: true,
        positionClass: 'toast-bottom-right',
        progressBar: true,
        timeOut: 5000,
        extendedTimeOut: 2000
        }
        
    })

    
</script>

<template>
    <!-- Button trigger modal -->

    <div class="content">
        <div class="container-fluid">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Users</h1>
                            <button type="button" @click="adduser" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Add New Users
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            
                                            <h5 class="modal-title" id="exampleModalLabel" v-if="editing">Edit Users</h5>
                                            <h5 class="modal-title" id="exampleModalLabel" v-else>Add New Users</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <Form ref="myForm" @reset="resetForm" @submit="submitform" :validation-schema="editing ? editschema :createschema" v-slot="{errors}" :initial-values="formvalues">
                                                <div class="form-group">
                                                    <Field type="hidden" name="id"/>
                                                    <label for="name">Name</label>
                                                    <Field type="text" class="form-control" id="name" :class="{'is-invalid':errors.name}"
                                                        placeholder="John Wick" name="name" />
                                                        <span class="invalid-feedback">{{ errors.name }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <Field type="text" class="form-control" id="email"
                                                        placeholder="john34@example.com" name="email" :class="{'is-invalid':errors.email}"/>
                                                        <span class="invalid-feedback">{{ errors.email }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <Field type="password" class="form-control" id="password"
                                                        placeholder="........" name="password" :class="{'is-invalid':errors.password}"/>
                                                        <span class="invalid-feedback">{{ errors.password }}</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cancel</button>
                                                    
                                                    
                                                    <button type="submit" class="btn btn-primary" v-if="editing==true">Update</button>
                                                    <button type="submit" class="btn btn-primary" v-else>Save</button>
                                                </div>
                                            </Form>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Starter Page</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>

                        <th scope="col">email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in users" :key="item.id">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ item.name }}</td>

                        <td>{{ item.email }}</td>
                        <td>    
                            <button type="button" @click="edituser(item)"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Edit
                            </button>
                            <button type="button" @click="deleteuser(item.id)"  class="btn btn-danger" >
                            Delete
                            </button>
                        </td>
                        
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    
</template>
<!-- <script>
import axios from 'axios';
import jquery from 'jquery'
import { Form ,Field } from 'vee-validate';

window.$=window.jquery=jquery;
export default {
    data() {
        return {
            users: [],
            
            addnewusers:{
                
                name:'',
                email:'',
                password:''
            }

        }
    },
    async mounted() {
        await axios.get('/api/users')
            .then((res) => {
                this.users = res.data
            })

    },
    methods:{
        async submitform(values){
            console.log(values)
            // await axios.post('/api/users/add',{
            //     name:this.addnewusers.name,
            //     email:this.addnewusers.email,
            //     password:this.addnewusers.password
            // }).then((res=>{
            //     console.log(res.data)
                
            //     $('#exampleModal').modal('hide')
            //     this.$router.push({name:'admin.users'})
                
            // }))
            
            
        },
        // async edituser(id){
        //     console.log(id)
        //     await axios.get('/api/users/edit',{id:this.id})
        //     .then((res)=>{
        //         console.log(res)
        //     })
        // }
    }
}

</script> -->
    