<template lang="">
    <div>
          <!-- modal -->
					  <Modal
							:value="getDeleteModalObj.showModal"
							:closable="false"
							:mask-closable="false">
									<p slot="header" style="color:#f60;text-align:center">
										<Icon type="ios-information-circle"></Icon>
										<span>Delete confirmation</span>
									</p>
									<div style="text-align:center" >
										<p>This will be deleted permanently from the database.</p>
										<p>Will you delete it?</p>
									</div>
							<div slot="footer">
                               <Button type="default" @click="closeModal()" >Cancel</Button>
							   <Button type="error" @click="deleteItem()" :disabled="isLoading" :loading="isLoading">{{isLoading ? 'Deleting...' : 'Delete'}}</Button>
							</div>
                      </Modal>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    data() {
        return {
            isLoading : false
        }
    },
    computed : {
      ...mapGetters(['getDeleteModalObj'])
    },
    methods: {
           closeModal(){
              this.$store.commit('setIsDeleted',false)
           },
          async deleteItem(){
                this.isLoading = true
                const res = await this.callApi('delete' , this.getDeleteModalObj.deleteUrl , this.getDeleteModalObj.data);
                if(res.status === 200){
                    this.success(res.data)
                     this.$store.commit('setIsDeleted',true)
                   
                }else{
                    this.swr();
                     this.$store.commit('setIsDeleted',false)
                }
                this.isLoading = false;
	  }
    },
}
</script>
<style lang="">
    
</style>