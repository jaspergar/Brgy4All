<template lang="">
    <div>
       <div class="content">
			<div class="container-fluid">
                <div>
                    <h1>
                        Review generated list
                    </h1>
                </div>
              <TableExpand :cit-list="list"/>
			</div>
		</div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import TableExpand from '../../reusableComponents/generatedServiceAttendanceTable/table'
export default {
    name : 'GeneratedList',
           data () {
            return {
               list : {
                   serviceId : null,
                   list : []
               }
            }
        },
         methods : {
             getList(){
               this.list = this.getGeneratedList
            // console.log(this.getGeneratedList)
             }
         },
         computed :{
           ...mapGetters(['getGeneratedList'])
         },
         created() {
             this.getList()
         },
        components : {
            TableExpand
        }
}
</script>
<style lang="">
    
</style>