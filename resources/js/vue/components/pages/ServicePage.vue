<template lang="">
    <div>
       	<div class="content">
			<div class="container-fluid">
					 
                       
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <div style="display:flex ; justify-content:space-between;">
                        <p class="_title0">Services </p>
                         <Button type="success" @click="updateModalState({'type' : 'Add'})"> <Icon type="md-add" /> Add Service </Button>
                    </div>
					 
				
					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr v-if="services.length">
								<th></th>
                                <th>Image</th> 
								<th>Service Type</th>
								<th>Service Title</th>
								<th>Service Status</th>
								<th>Num of Citizen</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
                                	<!-- ITEMS -->
							<tr v-for="(service , index) in services" :ke="index" v-if="services.length">
								<td>{{index+1}}</td>
								<td class="tbl_imagecontainer"><img :src="service.serviceImage" class="tbl_image"/></td>
								<td>{{service.serviceType}}</td>
								<td>{{service.serviceTitle}}</td>
								<td>{{service.serviceStatus}}</td>
								<!-- <td>{{service.created_at}}</td> -->
                                <td>{{ service.numberOfBeneficiaries <= 0 ?  'Not Set' : service.numberOfBeneficiaries}}</td>
								<td>
									<Button type="default" v-if=" service.numberOfBeneficiaries <= 0" @click="updateCreateAttendanceModalState(service.id)">Set Attendance</Button> 
									<Button type="info" :to="'/services/serviceDetails/'+ service.id" v-else>View full details</Button>
                                    <Button type="warning"  @click="updateModalState({'type':'Edit','service' : service,'index' : index})">Edit</Button>
									<Button type="error"  @click="showDeleteModal(service , index)">Delete</Button>
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
									<span>{{ modalType}} Service</span>
								</p>
							<Form label-position="left" :label-width="100">
								<FormItem label="Service Type">
									<Select v-model="data.serviceType" placeholder="Select Service Type"  v-if="modalType === 'Add'">
										<Option value="Agriculture">Agriculture</Option>
										<Option value="Human Health">Human Health</Option>
										<Option value="Animal Health">Animal Health</Option>
										<Option value="Goods">Goods</Option>
										<Option value="Money">Money</Option>
									</Select>
									<Select v-model="service.serviceType" placeholder="Select Service Type" v-if="modalType === 'Edit'">
										<Option value="Agriculture">Agriculture</Option>
										<Option value="Human Health">Human Health</Option>
										<Option value="Animal Health">Animal Health</Option>
										<Option value="Goods">Goods</Option>
										<Option value="Money">Money</Option>
									</Select>
								</FormItem>
						        <FormItem  label="Service Title">
									<Input v-model="data.serviceTitle" placeholder="Service Title" v-if="modalType === 'Add'"/>
									<Input v-model="service.serviceTitle" placeholder="Service Title" v-if="modalType === 'Edit'"/>
								</FormItem>
                                <FormItem  label="Service Description">
									<Input v-model="data.serviceDescription" type="textarea" :autosize="{minRows: 5,maxRows: 10}" placeholder="Service Description ..." v-if="modalType === 'Add'"/>
									<Input v-model="service.serviceDescription" type="textarea" :autosize="{minRows: 5,maxRows: 10}" placeholder="Service Description ..." v-if="modalType === 'Edit'"/>
								</FormItem>
									<!-- Edit -->
								<Upload
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
									v-show="serviceImageNew">
									<div style="padding: 20px 0">
										<Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
										<p>Click or drag files here to upload</p>
									</div>
								</Upload>
								<!-- add -->
								<div class="upload-list" v-if="data.serviceImage">
									<img :src= "data.serviceImage" class="image"/>
									<div class="upload-list-cover">
										<Icon type="ios-trash-outline" size="52" color="white" @click="deleteImage()"></Icon>
									</div>
								</div>
								<!-- edit -->
								<div class="upload-list" v-if="service.serviceImage">
									<img :src= "service.serviceImage" class="image"/>
									<div class="upload-list-cover">
										<Icon type="ios-trash-outline" size="52" color="white" @click="deleteImage(false)"></Icon>
									</div>
								</div>
	
								<FormItem style="text-align:end;margin-top:2rem;">
									<Button type="default" @click="updateModalState({'close':true})" >Close</Button>
									<Button type="success" @click="addService()" :disabled="isLoading" :loading="isLoading" v-if="modalType === 'Add'">{{isLoading ? 'Adding Service...' : 'Add Service'}}</Button>
									<Button type="info" @click="editService()" :disabled="isLoading" :loading="isLoading" v-if="modalType === 'Edit'">{{isLoading ? 'Editing Service...' : 'Edit Service'}}</Button>
								</FormItem>
							</Form>
                      </Modal>

                         <Modal
							:value="createAttendanceModal"
							:closable="false"
							:mask-closable="false">
									<p slot="header" style="color:#2d8cf0;text-align:center">
										<Icon type="md-add"></Icon>
										<span>Create Citizen Attendance List</span>
									</p>
									<div style="text-align:center" >
									<Button type="info" @click="updateGenerateModalState">Generate Attendance</Button>
									<Button type="info" @click="updateManualCreateModalState">Manual Create Attendance</Button>
									</div>
							<div slot="footer">
                               <Button type="default" @click="updateCreateAttendanceModalState">Cancel</Button>
							</div>
                       </Modal>

					   <!-- generate attendance modal -->
					     <Modal
							:value="generateAttandanceModal"
							:closable="false"
							:mask-closable="false"
							:footer-hide="true">

							<p slot="header" style="color:#2d8cf0;text-align:center">
								<Icon type="md-add"></Icon>
								<span>Generate Attendance List</span>
							</p>
							   <h3 style="text-align:center;margin-bottom:2rem;">Who can avail the service?</h3>
								<Form  >
									<FormItem style="text-align:center;">
										<CheckboxGroup v-model="requiredCitizen">
											<Checkbox label="Pwd"></Checkbox>
											<Checkbox label="No Job"></Checkbox>
											<Checkbox label="Solo Parent"></Checkbox>
											<Checkbox label="Senior"></Checkbox>
											<Checkbox label="Teenager"></Checkbox>
										</CheckboxGroup>
									</FormItem>
								   <FormItem style="text-align:end;margin-top:2rem;">
										<Button type="default" @click="updateGenerateModalState">Cancel</Button>
										<Button type="info" @click="generateAttendance">Generate</Button>
							      </FormItem>
							   </Form>
							
                       </Modal>
                        <!-- generate attendance modal  -->

                          <!-- manual create attendance modal -->
					     <Modal
							:value="manualCreateAttendanceModal"
							:closable="false"
							:mask-closable="false">
									<p slot="header" style="color:#2d8cf0;text-align:center">
										<Icon type="md-add"></Icon>
										<span>Create Citizen Attendance List</span>
									</p>
									<div style="text-align:center" >
									<Button type="info" >Generate Attendance</Button>
									<Button type="info">Manual Create Attendance</Button>
									</div>
							<div slot="footer">
                               <Button type="default">Cancel</Button>
							</div>
                       </Modal>
                          <!-- manual create attendance modal -->

                      <DeleteModal></DeleteModal>
					  <div v-if="!services.length">
						  <h3>No Services Created.</h3>
		              </div>
			</div>	
		</div>
    </div>
</template>
<script>
import DeleteModal from '../reusableComponents/deleteModal'
import {mapGetters} from 'vuex'
export default {
  name : "Service",
    data(){
	  return{
		  data : {
			 serviceType: '',
			 serviceTitle: '',
			 serviceDescription: '',
			 serviceImage: '',
			 user_id: null,
			 barangay_id : null
		  },
		  modalType: '',
		  modal : false,
		  isLoading: false,
		  services: [],
		  service: {},
		  numberOfAllAttendanceInService : [],
		  index: -1,
          token:'',
		  serviceImageNew:false,
          isEditingItem: false,
		  deletedOrigImage : false,

		  createAttendanceModal : false,
          generateAttandanceModal : false,
		  manualCreateAttendanceModal : false,

        
		  serviceId : null,
		  requiredCitizen : []
		  
		 
	  }
  },
  methods : {
	    updateModalState(data){
		  if(data){
			   this.serviceImageNew = true	
				if(data.index || data.service){
							let storeData = {
							id : data.service.id,
							serviceType : data.service.serviceType,
							serviceTitle : data.service.serviceTitle,
							serviceDescription : data.service.serviceDescription,
							serviceImage : data.service.serviceImage,
                            prevServiceIconImage : '',
 							}
							this.service = storeData;
							this.index = data.index  
							this.serviceImageNew = false		
							this.isEditingItem = true						
				}
			  
		     this.modalType = data.type
			  
			if(data.close){
			  this.deleteImage()
			  this.isEditingItem = false
			  this.service = {}
		      }
		  }
		 
		  this.modal = !this.modal		  
	  },
	   showDeleteModal(service, i){
        const  deleteModalObj = {
            showModal: true,
            deleteUrl: '/app/delete_service',
            data: service,
            index : i,
			isDeleted : false
        }
		console.log('delete modal called')
		this.$store.commit('setDeleteModalObj' , deleteModalObj)
	  },

	  async deleteImage(isAdd = true){
			let image 
			// let type = this.modalType
          if(!isAdd){
			  let storeImage  = {
				  'prevImage' : this.service.serviceImage
			  }
			  this.serviceImageNew = true
			  this.service.prevServiceIconImage = storeImage.prevImage
			//   image = this.category.categoryIconImage
			  this.deletedOrigImage = true
			  this.service.serviceImage = ''
			  this.$refs.uploads.clearFiles()
		  }else{
			  if(this.deletedOrigImage){
				  if(this.service.serviceImage){
					  image = this.service.serviceImage
					  this.data.serviceImage = ''
				      this.$refs.uploads.clearFiles()
					  this.deletedOrigImage = false
				  }
			  }else{
                image = this.data.serviceImage
				this.data.serviceImage = ''
				this.$refs.uploads.clearFiles()
			  }
			   
		  }

			
			const res = await this.callApi('post' , '/app/delete_file' , {imageName : image});
			if(res.status != 200){
				this.data.serviceImage = image;
				this.swr();
			}
		},
		async addService(){
		  this.isLoading = true;
		  if(this.data.serviceType.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Type is required' , 'Error')  
			  };
			if(this.data.serviceTitle.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Title is required' , 'Error')  
			  };
			  if(this.data.serviceDescription.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Description is required' , 'Error')  
			  };
			  if(this.data.serviceImage.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Image is required' , 'Error')  
			  };

		  const res = await this.callApi('post' , '/app/create_service' , this.data)
		  if(res.status === 201){
			   this.services.unshift(res.data);
			  this.success('Service is successfully created');
			  this.data.serviceType= '';
			  this.data.serviceTitle= '';
			  this.data.serviceDescription= '';
			  this.data.serviceImage= '';
			  this.$refs.uploads.clearFiles()
			  this.isLoading = false;
			  this.updateModalState();
		  }else{
			  if(res.status=== 422){
				  if(res.data.errors.serviceType){
					  this.info(res.data.errors.serviceType[0])
					  this.isLoading= false;
				  }
				   if(res.data.errors.serviceTitle){
					  this.info(res.data.errors.serviceTitle[0])
					  this.isLoading= false;
				  }
				   if(res.data.errors.serviceDescription){
					  this.info(res.data.errors.serviceDescription[0])
					  this.isLoading= false;
				  }
				  if(res.data.errors.serviceImage){
					  this.info(res.data.errors.serviceImage[0])
					  this.isLoading= false;
				  }
			  }
			  else{
					    this.swr();
				  }
			
		  }

	  },
	
	  async getServices(){
		  const res = await this.callApi('get' , '/app/getall_services');
		  if(res.status === 200){
			  this.services = res.data
			//    let array = []
			//    let servicesId = {
			// 	   'service_id' : []
			//    }
            //   array = res.data
			//   array.forEach(element => {
			// 	  var id = element.id
			// 	  servicesId.service_id.push(id)
			//   });
			//   console.log(servicesId);
			//   const result = await this.callApi('post', '/app/countAllNumOfAttendance', servicesId );
			//   if(result.status === 200){
			// 	  console.log(result.data)
				//    this.numberOfAllAttendanceInService = result.data
			//   }
		  }else{
			  this.swr()
		  }
		  
	  },
	  async editService(){
           this.isLoading = true;
		   if(this.service.serviceType.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Type is required' , 'Error')  
			  };
			   if(this.service.serviceTitle.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Title is required' , 'Error')  
			  };
			   if(this.service.serviceDescription.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Description is required' , 'Error')  
			  };
			   if(this.service.serviceImage.trim()=='') {
			  this.isLoading = false
			  return this.error('Service Image is required' , 'Error')  
			  };

             
		  const res = await this.callApi('put' , '/app/edit_service' , this.service);
		  if(res.status === 200){
			  this.services[this.index].serviceType = this.service.serviceType
			  this.services[this.index].serviceTitle = this.service.serviceTitle
			  this.services[this.index].serviceDescription = this.service.serviceDescription
			  this.services[this.index].serviceImage = this.service.serviceImage
			  this.success('Edited Successfully');
			  this.isLoading = false;
			  this.$refs.uploads.clearFiles()
			  this.service = {}
			  this.isEditingItem =false;
			  this.deletedOrigImage = false
			  this.updateModalState();
		  } else{
			  if(res.status=== 422){
				   if(res.data.errors.serviceType){
					  this.info(res.data.errors.serviceType[0])
					  this.isLoading= false;
				  }
				    if(res.data.errors.serviceTitle){
					  this.info(res.data.errors.serviceTitle[0])
					  this.isLoading= false;
				  }
				    if(res.data.errors.serviceDescription){
					  this.info(res.data.errors.serviceDescription[0])
					  this.isLoading= false;
				  }
				  if(res.data.errors.serviceImage){
					  this.info(res.data.errors.serviceImage[0])
					  this.isLoading= false;
				  }
			  }
			  else{
				this.swr();
				}
			
		  }
	  },

	  // --- front end image upload to server validation 
		handleSuccess (res, file) {
			res = `/uploads/${res}`
			if(this.isEditingItem){
				return this.service.serviceImage =res
			}
			this.data.serviceImage = res
		},
		handleError (res, file) {
			console.log('res' , res)
			console.log('file', file)
			this.$Notice.warning({
				title: 'The file format is incorrect',
				desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}`
			});
		},
		handleFormatError (file) {
			this.$Notice.warning({
				title: 'The file format is incorrect',
				desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
			});
		},
		handleMaxSize (file) {
			this.$Notice.warning({
				title: 'Exceeding file size limit',
				desc: 'File  ' + file.name + ' is too large, no more than 2M.'
			});
		},


		//create attendance methods

		//modal
		updateCreateAttendanceModalState(serId){
            this.createAttendanceModal = !this.createAttendanceModal
			this.serviceId = serId
		},
		updateGenerateModalState(){
			this.createAttendanceModal = !this.createAttendanceModal
			this.generateAttandanceModal = !this.generateAttandanceModal
		},
		updateManualCreateModalState(){
			this.manualCreateAttendanceModal = !this.manualCreateAttendanceModal
		},
		//call to server
		async generateAttendance(){
			 const res = await this.callApi('post' , '/app/generate_attendance' , this.requiredCitizen);
			  if(res.status === 200){
			   console.log(res)
			
			   const generatedList = {
				   serviceId : this.serviceId,
				   list : res.data
			   }
			   console.log(generatedList)
			   this.$store.commit('setGeneratedList' , generatedList)
			   this.$router.push({name : 'GeneratedList'})
		      }
		},
  },
   created() {
      this.token = window.Laravel.csrfToken
	  this.data.user_id = this.getUserState.id
	  this.data.barangay_id = this.getUserState.barangay_id
	  this.getServices();
	  
  },
  components :{
	  DeleteModal
  },
   computed : {
	  ...mapGetters(['getIsDeletedState','getUserState'])
  },
  watch : {
	  getIsDeletedState(obj){
		  if(obj.isDeleted){
			  this.services.splice(obj.index , 1)
		  }
	  },
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