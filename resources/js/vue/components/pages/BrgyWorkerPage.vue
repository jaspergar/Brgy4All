<template lang="">
    <div>
         	<div class="content">
			<div class="container-fluid">
              <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <div style="display:flex ; justify-content:space-between;">
                        <p class="_title0">Barangay Workers </p>
                         <Button type="success"  @click="updateModalState({'type' : 'Add'})"> <Icon type="md-add" /> Add Barangay Workers </Button>
                    </div>
					 
				
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th></th>
								<th>Full name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
                                	<!-- ITEMS -->
							<tr  v-for="(worker , index) in workers" :ke="index" v-if="workers.length">
								<td>{{index+1}}</td>
								<td>{{worker.brgy_worker_fullname}}</td>
								<td>{{worker.brgy_worker_username}}</td>
								<td>{{worker.brgy_worker_email}}</td>
								<td>{{worker.created_at}}</td>
								<td>
									<!-- <Button type="default" v-if=" service.numberOfBeneficiaries <= 0" @click="updateCreateAttendanceModalState(service.id)">Set Attendance</Button> 
									<Button type="info" :to="'/services/serviceDetails/'+ service.id" v-else>View full details</Button> -->
                                    <Button type="warning" @click="updateModalState({'type':'Edit','worker' : worker,'index' : index})">Edit</Button>
									<Button type="error"  @click="showDeleteModal(worker , index)">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->
                        
						</table>
					</div>
				</div>     


				 <!-- modal -->
					  <Modal
							v-model="modal"
							:closable="false"
							:mask-closable="false"
							:footer-hide="true">
 
                                <p slot="header" style="color:#111;text-align:left" >
									<span>{{ modalType}} Worker</span>
								</p>
							<Form label-position="left" :label-width="100">
								
						        <FormItem  label="Full Name">
									<Input  type="text" v-model="data.brgy_worker_fullname" placeholder="Worker Fullname" v-if="modalType === 'Add'"/>
									<Input  type="text" v-model="worker.brgy_worker_fullname" placeholder="Worker Fullname" v-if="modalType === 'Edit'"/>
								</FormItem>
                                <FormItem  label="Username">
									<Input v-model="data.brgy_worker_username"  type="text" :autosize="{minRows: 5,maxRows: 10}" placeholder="Worker Username ..." v-if="modalType === 'Add'"/>
									<Input v-model="worker.brgy_worker_username"  type="text" :autosize="{minRows: 5,maxRows: 10}" placeholder="Worker Username ..." v-if="modalType === 'Edit'"/>
								</FormItem>
								 <FormItem  label="Email">
									<Input v-model="data.brgy_worker_email" type="text" :autosize="{minRows: 5,maxRows: 10}" placeholder="Worker Email ..." v-if="modalType === 'Add'"/>
									<Input v-model="worker.brgy_worker_email"  type="text" :autosize="{minRows: 5,maxRows: 10}" placeholder="Worker Email ..." v-if="modalType === 'Edit'"/>
								</FormItem>
								 <FormItem  label="Password">
									<Input v-model="data.brgy_worker_password" type="password" :autosize="{minRows: 5,maxRows: 10}" placeholder="Worker Password ..." v-if="modalType === 'Add'"/>
									<Input v-model="worker.brgy_worker_password" type="password" :autosize="{minRows: 5,maxRows: 10}" placeholder="Worker Password ..." v-if="modalType === 'Edit'"/>
								</FormItem>
								
							
								<FormItem style="text-align:end;">
									<Button type="default" @click="updateModalState({'close':true})" >Close</Button>
									<Button type="success" @click="addWorker()" :disabled="isLoading" :loading="isLoading" v-if="modalType === 'Add'">{{isLoading ? 'Adding Worker...' : 'Add Worker'}}</Button>
									<Button type="info" @click="editWorker()" :disabled="isLoading" :loading="isLoading" v-if="modalType === 'Edit'">{{isLoading ? 'Editing Worker...' : 'Edit Worker'}}</Button>
								</FormItem>
							</Form>
                      </Modal>
   
                    <DeleteModal></DeleteModal>       
                    
			</div>
		</div>
    </div>
</template>
<script>
import DeleteModal from '../reusableComponents/deleteModal'
import {mapGetters} from 'vuex'
export default {
  name : "BrgyWorker",
data(){
	  return{
		  data : {
			 brgy_worker_username: '',
			 brgy_worker_fullname: '',
			 brgy_worker_email: '',
			 brgy_worker_password:''
		  },
		  modalType: '',
		  modal : false,
		  isLoading: false,
		  workers: [],
		  worker: {},
		  index: -1,
          isEditingItem: false,
	  }
  },
  methods: {
		updateModalState(data){
		  if(data){
			//    this.imageNew = true	
				if(data.index || data.worker){
							let storeData = {
							id : data.worker.id,
							brgy_worker_fullname : data.worker.brgy_worker_fullname,
							brgy_worker_email : data.worker.brgy_worker_email,
							brgy_worker_username : data.worker.brgy_worker_username,
							brgy_worker_password : data.worker.brgy_worker_password,
							// image : data.worker.image,
                            // prevImage : '',
 							}
							this.worker = storeData;
							this.index = data.index  
							// this.imageNew = false	
							this.isEditingItem = true						
				}
			  
		     this.modalType = data.type
			  
			if(data.close){
			//   this.deleteImage()
			  this.isEditingItem = false
			  this.worker = {}
		      }
		  }
		 
		  this.modal = !this.modal		  
	  },
	   showDeleteModal(worker, i){
        const  deleteModalObj = {
            showModal: true,
            deleteUrl: '/app/delete_worker',
            data: worker,
            index : i,
			isDeleted : false
        }
		console.log('delete modal called')
		this.$store.commit('setDeleteModalObj' , deleteModalObj)
	  },
	  async addWorker(){
		  this.isLoading = true;
		  if(this.data.brgy_worker_username.trim()=='') {
			  this.isLoading = false
			  return this.error('Username is required' , 'Error')  
			  };
			if(this.data.brgy_worker_fullname.trim()=='') {
			  this.isLoading = false
			  return this.error('Full name is required' , 'Error')  
			  };
			  if(this.data.brgy_worker_email.trim()=='') {
			  this.isLoading = false
			  return this.error('Email is required' , 'Error')  
			  };
			  if(this.data.brgy_worker_password.trim()=='') {
			  this.isLoading = false
			  return this.error('Password is required' , 'Error')  
			  };
			  if(this.data.brgy_worker_password.length <= 7) {
			  this.isLoading = false
			  return this.error('Password must contain atleast 8 characters' , 'Error')  
			  };
			 

		  const res = await this.callApi('post' , '/app/create_worker' , this.data)
		  if(res.status === 201){
			   this.workers.unshift(res.data);
			  this.success('Worker is successfully created');
			  this.data.brgy_worker_username= '';
			  this.data.brgy_worker_fullname= '';
			  this.data.brgy_worker_email= '';
			  this.data.brgy_worker_password= '';
			//   this.$refs.uploads.clearFiles()
			  this.isLoading = false;
			  this.updateModalState();
		  }else{
			  if(res.status=== 422){
				  if(res.data.errors.brgy_worker_username){
					  this.info(res.data.errors.brgy_worker_username[0])
					  this.isLoading= false;
				  }
				   if(res.data.errors.brgy_worker_fullname){
					  this.info(res.data.errors.brgy_worker_fullname[0])
					  this.isLoading= false;
				  }
				  if(res.data.errors.brgy_worker_email){
					  this.info(res.data.errors.brgy_worker_email[0])
					  this.isLoading= false;
				  }
				  if(res.data.errors.brgy_worker_password){
					  this.info(res.data.errors.brgy_worker_password[0])
					  this.isLoading= false;
				  }
			  }
			  else{
					    this.swr();
				  }
			
		  }

	  },
	  async getWorkers(){
		  const res = await this.callApi('get' , '/app/getall_workers');
		  if(res.status === 200){
			  this.workers = res.data
		  }else{
			  this.swr()
		  }
		  
	  },
	  async editWorker(){
           this.isLoading = true;
		    if(this.worker.brgy_worker_username.trim()=='') {
			  this.isLoading = false
			  return this.error('Username is required' , 'Error')  
			  };
			if(this.worker.brgy_worker_fullname.trim()=='') {
			  this.isLoading = false
			  return this.error('Full name is required' , 'Error')  
			  };
			  if(this.worker.brgy_worker_email.trim()=='') {
			  this.isLoading = false
			  return this.error('Email is required' , 'Error')  
			  };
			  if(this.worker.brgy_worker_password.trim()=='') {
			  this.isLoading = false
			  return this.error('Password is required' , 'Error')  
			  };
			  if(this.worker.brgy_worker_password.length <= 7) {
			  this.isLoading = false
			  return this.error('Password must contain atleast 8 characters' , 'Error')  
			  };
			   
             
		  const res = await this.callApi('put' , '/app/edit_worker' , this.worker);
		  if(res.status === 200){
			  this.workers[this.index].brgy_worker_username = this.worker.brgy_worker_username
			  this.workers[this.index].brgy_worker_fullname = this.worker.brgy_worker_fullname
			  this.workers[this.index].brgy_worker_email = this.worker.brgy_worker_email
			  this.workers[this.index].brgy_worker_password = this.worker.brgy_worker_password
			  this.success('Edited Successfully');
			  this.isLoading = false;
			  this.worker = {}
			  this.isEditingItem =false;
			  this.updateModalState();
		  } else{
			  if(res.status=== 422){
				   if(res.data.errors.brgy_worker_username){
					  this.info(res.data.errors.brgy_worker_username[0])
					  this.isLoading= false;
				  }
				   if(res.data.errors.brgy_worker_fullname){
					  this.info(res.data.errors.brgy_worker_fullname[0])
					  this.isLoading= false;
				  }
				  if(res.data.errors.brgy_worker_email){
					  this.info(res.data.errors.brgy_worker_email[0])
					  this.isLoading= false;
				  }
				  if(res.data.errors.brgy_worker_password){
					  this.info(res.data.errors.brgy_worker_password[0])
					  this.isLoading= false;
				  }
				  
			  }
			  else{
				this.swr();
				}
			
		  }
	  },

  },
    created() {
    //   this.token = window.Laravel.csrfToken
	  this.getWorkers();
	  
  },
  components :{
	  DeleteModal
  },
   computed : {
	  ...mapGetters(['getIsDeletedState'])
  },
  watch : {
	  getIsDeletedState(obj){
		  if(obj.isDeleted){
			  this.workers.splice(obj.index , 1)
		  }
	  }
  }
}
</script>
<style scoped>
    .upload-list{
        position:relative;
		width:100px;
		height: 100px;
		background:red;
	 }
	 .image{
		 height:100%;
		 width:100%;
		 object-fit: cover;
	 }

	 .upload-list-cover{
       height:100%;
	   width:100%;
	   position:absolute;
	   top:0;
	   left:0;
	   right:0;
	   bottom:0;
	   display:none;
	   background: rgba(1,1,1, .5);
	 }

	 .upload-list:hover  .upload-list-cover{
		display:flex;
		justify-content:center;
		align-items:center;
		cursor:pointer;
	 }

	 .tbl_imagecontainer{
		 height:80px;
		 width:150px;
	 }
	 .tbl_image{
		 height:100%;
		 width:100%;
		 object-fit: cover;
	 }

    
</style>