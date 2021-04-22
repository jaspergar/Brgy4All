<template lang="">
    <div>
         	<div class="content">
			<div class="container-fluid">

			<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <div style="display:flex ; justify-content:space-between;">
                        <p class="_title0">Announcements </p>
                         <Button type="success"  @click="updateModalState({'type' : 'Add'})"> <Icon type="md-add" /> Add Announcement </Button>
                    </div>
					 
				
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th></th>
								<th>Subject</th>
								<th>Description</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
                                	<!-- ITEMS -->
							<tr  v-for="(announcement , index) in announcements" :ke="index" v-if="announcements.length">
								<td>{{index+1}}</td>
								<td>{{announcement.subject}}</td>
								<td>{{announcement.description}}</td>
								<td>{{announcement.created_at}}</td>
								<td>
									<!-- <Button type="default" v-if=" service.numberOfBeneficiaries <= 0" @click="updateCreateAttendanceModalState(service.id)">Set Attendance</Button> 
									<Button type="info" :to="'/services/serviceDetails/'+ service.id" v-else>View full details</Button> -->
                                    <Button type="warning" @click="updateModalState({'type':'Edit','announcement' : announcement,'index' : index})">Edit</Button>
									<Button type="error"  @click="showDeleteModal(announcement , index)">Delete</Button>
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
									<span>{{ modalType}} Announcement</span>
								</p>
							<Form label-position="left" :label-width="100">
								
						        <FormItem  label="Subject">
									<Input v-model="data.subject" placeholder="Announcement Subject" v-if="modalType === 'Add'"/>
									<Input v-model="announcement.subject" placeholder="Announcement Subject" v-if="modalType === 'Edit'"/>
								</FormItem>
                                <FormItem  label="Description">
									<Input v-model="data.description" type="textarea" :autosize="{minRows: 5,maxRows: 10}" placeholder="Announcement Description ..." v-if="modalType === 'Add'"/>
									<Input v-model="announcement.description" type="textarea" :autosize="{minRows: 5,maxRows: 10}" placeholder="Announcement Description ..." v-if="modalType === 'Edit'"/>
								</FormItem>
								
								<!-- <Upload
									ref="uploads"
									type="drag"
									:headers = "{'x-csrf-token' : token , 'X-Requested-With': 'XMLHttpRequest'}"
									:on-success="handleSuccess"
									:on-error="handleError"
									:format="['jpg','jpeg','png']"
									:max-size="2048"
									:on-format-error="handleFormatError"
									:on-exceeded-size="handleMaxSize"
									action="/app/upload_file" 
									v-show="imageNew">
									<div style="padding: 20px 0">
										<Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
										<p>Click or drag files here to upload</p>
									</div>
								</Upload>-->
								<!-- add -->
								<!-- <div class="upload-list" v-if="data.image">
									<img :src= "data.image" class="image"/>
									<div class="upload-list-cover">
										<Icon type="ios-trash-outline" size="52" color="white" @click="deleteImage()"></Icon>
									</div>
								</div> -->
								<!-- edit -->
								<!-- <div class="upload-list" v-if="announcement.image">
									<img :src= "announcement.image" class="image"/>
									<div class="upload-list-cover">
										<Icon type="ios-trash-outline" size="52" color="white" @click="deleteImage(false)"></Icon>
									</div>
								</div>  -->
	
								<FormItem style="text-align:end;">
									<Button type="default" @click="updateModalState({'close':true})" >Close</Button>
									<Button type="success" @click="addAnnouncement()" :disabled="isLoading" :loading="isLoading" v-if="modalType === 'Add'">{{isLoading ? 'Adding Announcement...' : 'Add Announcement'}}</Button>
									<Button type="info" @click="editAnnouncement()" :disabled="isLoading" :loading="isLoading" v-if="modalType === 'Edit'">{{isLoading ? 'Editing Announcement...' : 'Edit Announcement'}}</Button>
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
  name : "Announcement",
  data(){
	  return{
		  data : {
			 subject: '',
			 description: '',
			//  image: ''
		  },
		  modalType: '',
		  modal : false,
		  isLoading: false,
		  announcements: [],
		  announcement: {},
		  index: -1,
        //   token:'',
		//   imageNew:false,
          isEditingItem: false,
		//   deletedOrigImage : false,
	  }
  },
  methods: {
		updateModalState(data){
		  if(data){
			//    this.imageNew = true	
				if(data.index || data.announcement){
							let storeData = {
							id : data.announcement.id,
							subject : data.announcement.subject,
							description : data.announcement.description,
							// image : data.announcement.image,
                            // prevImage : '',
 							}
							this.announcement = storeData;
							this.index = data.index  
							// this.imageNew = false	
							this.isEditingItem = true						
				}
			  
		     this.modalType = data.type
			  
			if(data.close){
			//   this.deleteImage()
			  this.isEditingItem = false
			  this.announcement = {}
		      }
		  }
		 
		  this.modal = !this.modal		  
	  },
	   showDeleteModal(announcement, i){
        const  deleteModalObj = {
            showModal: true,
            deleteUrl: '/app/delete_announcement',
            data: announcement,
            index : i,
			isDeleted : false
        }
		console.log('delete modal called')
		this.$store.commit('setDeleteModalObj' , deleteModalObj)
	  },
	  async addAnnouncement(){
		  this.isLoading = true;
		  if(this.data.subject.trim()=='') {
			  this.isLoading = false
			  return this.error('Subject is required' , 'Error')  
			  };
			if(this.data.description.trim()=='') {
			  this.isLoading = false
			  return this.error('Description is required' , 'Error')  
			  };
			 

		  const res = await this.callApi('post' , '/app/create_announcement' , this.data)
		  if(res.status === 201){
			   this.announcements.unshift(res.data);
			  this.success('Announcement is successfully created');
			  this.data.subject= '';
			  this.data.description= '';
			//   this.$refs.uploads.clearFiles()
			  this.isLoading = false;
			  this.updateModalState();
		  }else{
			  if(res.status=== 422){
				  if(res.data.errors.subject){
					  this.info(res.data.errors.subject[0])
					  this.isLoading= false;
				  }
				   if(res.data.errors.description){
					  this.info(res.data.errors.description[0])
					  this.isLoading= false;
				  }
			  }
			  else{
					    this.swr();
				  }
			
		  }

	  },
	  async getAnnouncements(){
		  const res = await this.callApi('get' , '/app/getall_announcements');
		  if(res.status === 200){
			  this.announcements = res.data
		  }else{
			  this.swr()
		  }
		  
	  },
	  async editAnnouncement(){
           this.isLoading = true;
		   if(this.announcement.subject.trim()=='') {
			  this.isLoading = false
			  return this.error('Subject Type is required' , 'Error')  
			  };
			   if(this.announcement.description.trim()=='') {
			  this.isLoading = false
			  return this.error('Description Title is required' , 'Error')  
			  };
			   
             
		  const res = await this.callApi('put' , '/app/edit_announcement' , this.announcement);
		  if(res.status === 200){
			  this.announcements[this.index].subject = this.announcement.subject
			  this.announcements[this.index].description = this.announcement.description
			  this.success('Edited Successfully');
			  this.isLoading = false;
			  this.announcement = {}
			  this.isEditingItem =false;
			  this.updateModalState();
		  } else{
			  if(res.status=== 422){
				   if(res.data.errors.subject){
					  this.info(res.data.errors.subject[0])
					  this.isLoading= false;
				  }
				    if(res.data.errors.description){
					  this.info(res.data.errors.description[0])
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
	  this.getAnnouncements();
	  
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
			  this.announcements.splice(obj.index , 1)
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