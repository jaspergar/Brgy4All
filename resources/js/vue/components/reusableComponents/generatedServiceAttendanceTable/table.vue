<template>
     <div>
        <Table border ref="selection"  max-height="700" :columns="columns10" :data="citizenList"></Table>
        <div style="text-align:end; margin-top:1rem">
            <Button @click="cancelAttendance()" type="error">Cancel</Button>
            <Button @click="createAttendance()" type="success">Create Attendance</Button> 
        </div>
    </div>
</template>
<script>
    import expandRow from './table-expand.vue';
    export default {
        components: { expandRow },
        data () {
            return {
                columns10: [
                    
                      {
                        type: 'selection',
                        width: 60,
                        align: 'center'
                    },
                    {
                        type: 'expand',
                        width: 50,
                        render: (h, params) => {
                            return h(expandRow, {
                                props: {
                                    row: params.row
                                }
                            })
                        }
                    },
                    {
                        type: 'index',
                        width: 60,
                        align: 'center'
                    },
                    {
                        title: 'Last name',
                        key: `lname`,
                        width: 200
                    },
                    {
                        title: 'First name',
                        key: `fname`,
                        width: 200
                    },
                    {
                        title: 'M.I',
                        key: `mname`,
                        width: 60
                    },
                    {
                        title: 'Age',
                        key: 'age',
                        width: 80
                    },
                    {
                        title: 'Sex',
                        key: 'sex',
                        width: 100
                    },
                    {
                        title: 'Full Address',
                        key: 'Address'
                    },
                    {
                        title: 'Status',
                        key: 'status',
                        width: 150
                    },

                ],
                citizenList: [],
                serviceId: null
            }
        },
        props : [
            "citList"
        ],
         methods: {
           getCitList(){
               console.log(this.citList)
              this.citizenList = this.citList.list
              this.serviceId = this.citList.serviceId
           },
           async createAttendance(){
               const data = {
                    citizenList : this.citizenList,
                    serviceId : this.serviceId
               }
              const res = await this.callApi('post', '/app/create_attendance' , data)
                  if(res.status === 200){
                      this.$router.push({name : 'Service'})
                  }
              
           },
           cancelAttendance(){
            this.citizenList = [];
            this.$router.push({name : 'Service'})
           },
            handleSelectAll (status) {
                this.$refs.selection.selectAll(status);
            }
        },
        created() {
          this.getCitList();
        },
    }
</script>