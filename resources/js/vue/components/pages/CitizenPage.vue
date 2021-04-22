<template lang="">
    <div>
         	<div class="content">
			<div class="container-fluid">

			<CitizenTable :cit-list="citizenList"/>                 
                    
			</div>
		</div>
    </div>
</template>
<script>
import CitizenTable from '../reusableComponents/masterListCitizenTable/table'
export default {
  name : "Citizen",
  data() {
	  return {
		  citizenList : []
	  }
  },
  methods: {
	   async getAllCitizen(){
		   const res = await this.callApi('get' , '/app/getall_citizen')
		   if(res.status === 200){
			//    this.citizenList = res.data
			    // let array = [];
                // let list = [];
                // array = res.data;
                // array.forEach(element => {
                //     list.push(element);
                // });
				this.citizenList =res.data
		   }
	   }

  },
  components:{
	  CitizenTable
  },
  created() {
	  this.getAllCitizen();
  },
}
</script>
<style lang="">
    
</style>